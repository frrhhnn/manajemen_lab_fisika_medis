<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanItem;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource (for admin).
     */
    public function index()
    {
        $peminjamans = Peminjaman::with('peminjamanItems.alat')
                                ->latest()
                                ->paginate(10);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Show available equipment for users to borrow
     */
    public function showAvailable()
    {
        $alats = Alat::with('kategoriAlat')
                    ->tersedia()
                    ->latest()
                    ->get();
        return view('user.peminjaman.available', compact('alats'));
    }

    /**
     * Show the form for creating a new resource (user request).
     */
    public function create()
    {
        $alats = Alat::with('kategoriAlat')->tersedia()->get();
        return view('user.peminjaman.create', compact('alats'));
    }

    /**
     * Store a newly created resource in storage (user request).
     */
    public function store(Request $request)
    {
        \Log::info('Peminjaman store method called', [
            'request_data' => $request->all(),
            'url' => $request->url(),
            'method' => $request->method()
        ]);
        
        $validated = $request->validate([
            'namaPeminjam' => 'required|string|max:255',
            'is_mahasiswa_usk' => 'boolean',
            'npm_nim' => 'nullable|string|max:20',
            'noHp' => 'required|string|max:20',
            'tujuanPeminjaman' => 'nullable|string',
            'tanggal_pinjam' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $dayOfWeek = \Carbon\Carbon::parse($value)->dayOfWeek;
                    if ($dayOfWeek === 0 || $dayOfWeek === 6) {
                        $fail('Tanggal peminjaman tidak boleh pada hari Minggu atau hari libur.');
                    }
                }
            ],
            'tanggal_pengembalian' => [
                'required',
                'date',
                'after:tanggal_pinjam',
                function ($attribute, $value, $fail) {
                    $dayOfWeek = \Carbon\Carbon::parse($value)->dayOfWeek;
                    if ($dayOfWeek === 0 || $dayOfWeek === 6) {
                        $fail('Tanggal pengembalian tidak boleh pada hari Minggu atau hari libur.');
                    }
                }
            ],
            'items' => 'required|array|min:1',
            'items.*.alat_id' => 'required|exists:alat,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Check availability for all items
            foreach ($validated['items'] as $item) {
                $alat = Alat::find($item['alat_id']);
                if (!$alat->isAvailable($item['jumlah'])) {
                    throw new \Exception("Alat {$alat->nama} tidak tersedia dalam jumlah yang diminta.");
                }
            }

            // Create peminjaman
            $peminjaman = Peminjaman::create([
                'namaPeminjam' => $validated['namaPeminjam'],
                'is_mahasiswa_usk' => $validated['is_mahasiswa_usk'] ?? false,
                'npm_nim' => $validated['npm_nim'] ?? null,
                'noHp' => $validated['noHp'],
                'tujuanPeminjaman' => $validated['tujuanPeminjaman'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_pengembalian' => $validated['tanggal_pengembalian'],
                'status' => 'Menunggu'
            ]);

            // Create peminjaman items
            foreach ($validated['items'] as $item) {
                PeminjamanItem::create([
                    'peminjamanId' => $peminjaman->id,
                    'alat_id' => $item['alat_id'],
                    'jumlah' => $item['jumlah']
                ]);
            }

            DB::commit();

            \Log::info('Peminjaman created successfully', [
                'peminjaman_id' => $peminjaman->id,
                'redirect_route' => 'user.peminjaman.tracking'
            ]);

            return redirect()->route('user.peminjaman.tracking', $peminjaman)
                            ->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->withInput()
                            ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load('peminjamanItems.alat.kategoriAlat');
        return view('user.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show user's peminjaman history
     */
    public function userHistory(Request $request)
    {
        $noHp = $request->get('noHp');
        $peminjamans = collect();
        
        if ($noHp) {
            $peminjamans = Peminjaman::with('peminjamanItems.alat')
                                   ->where('noHp', $noHp)
                                   ->latest()
                                   ->paginate(10);
        }
        
        return view('user.peminjaman.history', compact('peminjamans', 'noHp'));
    }

    /**
     * Admin approve peminjaman
     */
    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Menunggu') {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman sudah diproses.'
                ], 400);
            }
            return redirect()->back()
                            ->with('error', 'Peminjaman sudah diproses.');
        }

        try {
            DB::beginTransaction();

            // Check availability again
            foreach ($peminjaman->peminjamanItems as $item) {
                if (!$item->alat->isAvailable($item->jumlah)) {
                    throw new \Exception("Alat {$item->alat->nama} tidak tersedia dalam jumlah yang diminta.");
                }
            }

            // Update equipment stock
            foreach ($peminjaman->peminjamanItems as $item) {
                $alat = $item->alat;
                $alat->update([
                    'jumlah_tersedia' => $alat->jumlah_tersedia - $item->jumlah,
                    'jumlah_dipinjam' => $alat->jumlah_dipinjam + $item->jumlah
                ]);
            }

            // Update peminjaman status
            $peminjaman->update(['status' => 'Disetujui']);

            DB::commit();

            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Peminjaman disetujui dan stok alat telah diperbarui.']);
            }

            return redirect()->back()
                            ->with('success', 'Peminjaman disetujui dan stok alat telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            
            return redirect()->back()
                            ->with('error', $e->getMessage());
        }
    }

    /**
     * Admin reject peminjaman
     */
    public function reject(Peminjaman $peminjaman)
    {
        if (!in_array($peminjaman->status, ['Menunggu', 'Disetujui'])) {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman tidak dapat ditolak.'
                ], 400);
            }
            return redirect()->back()
                            ->with('error', 'Peminjaman tidak dapat ditolak.');
        }

        try {
            DB::beginTransaction();

            // If status is Disetujui, we need to revert the stock changes
            if ($peminjaman->status === 'Disetujui') {
                foreach ($peminjaman->peminjamanItems as $item) {
                    $alat = $item->alat;
                    $alat->update([
                        'jumlah_tersedia' => $alat->jumlah_tersedia + $item->jumlah,
                        'jumlah_dipinjam' => $alat->jumlah_dipinjam - $item->jumlah
                    ]);
                }
            }

            $peminjaman->update(['status' => 'Ditolak']);

            DB::commit();

            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Peminjaman ditolak.']);
            }

            return redirect()->back()
                            ->with('success', 'Peminjaman ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            
            return redirect()->back()
                            ->with('error', $e->getMessage());
        }
    }

    /**
     * Admin confirm peminjaman (after letter signed)
     */
    public function confirm(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Disetujui') {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman tidak dapat dikonfirmasi.'
                ], 400);
            }
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak dapat dikonfirmasi.'
            ], 400);
        }

        try {
            $peminjaman->update([
                'status' => 'Dipinjam'
            ]);

            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Peminjaman berhasil dikonfirmasi.'
                ]);
            }

            return redirect()->back()
                            ->with('success', 'Peminjaman berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            \Log::error('Error confirming peminjaman: ' . $e->getMessage());

            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengkonfirmasi peminjaman.'
                ], 500);
            }

            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan saat mengkonfirmasi peminjaman.');
        }
    }

    /**
     * Admin complete peminjaman (when returned)
     */
    public function complete(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Dipinjam') {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman tidak dapat diselesaikan. Status harus Dipinjam terlebih dahulu.'
                ], 400);
            }
            return redirect()->back()
                            ->with('error', 'Peminjaman tidak dapat diselesaikan. Status harus Dipinjam terlebih dahulu.');
        }

        // Check if already returned
        if (!empty($peminjaman->kondisi_pengembalian)) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman sudah selesai dikembalikan.'
                ], 400);
            }
            return redirect()->back()
                            ->with('error', 'Peminjaman sudah selesai dikembalikan.');
        }

        $validated = $request->validate([
            'kondisi_pengembalian' => 'required|string',
            'items' => 'required|array',
            'items.*.jumlah_baik' => 'required|integer|min:0',
            'items.*.jumlah_rusak' => 'required|integer|min:0',
        ]);

        \Log::info('Starting complete peminjaman process', [
            'peminjaman_id' => $peminjaman->id,
            'status' => $peminjaman->status,
            'validated_data' => $validated
        ]);

        try {
            DB::beginTransaction();

            // Update equipment stock based on condition
            foreach ($peminjaman->peminjamanItems as $index => $item) {
                $alat = $item->alat;
                
                if (!isset($validated['items'][$index])) {
                    throw new \Exception("Data item tidak lengkap untuk alat {$alat->nama}");
                }
                
                $jumlahBaik = $validated['items'][$index]['jumlah_baik'];
                $jumlahRusak = $validated['items'][$index]['jumlah_rusak'];

                \Log::info('Processing item', [
                    'alat_nama' => $alat->nama,
                    'jumlah_dipinjam' => $item->jumlah,
                    'jumlah_baik' => $jumlahBaik,
                    'jumlah_rusak' => $jumlahRusak,
                    'total_kembali' => $jumlahBaik + $jumlahRusak
                ]);

                if (($jumlahBaik + $jumlahRusak) !== $item->jumlah) {
                    throw new \Exception("Total jumlah kembali ({$jumlahBaik} + {$jumlahRusak} = " . ($jumlahBaik + $jumlahRusak) . ") tidak sesuai dengan jumlah dipinjam ({$item->jumlah}) untuk alat {$alat->nama}.");
                }

                $alat->update([
                    'jumlah_tersedia' => $alat->jumlah_tersedia + $jumlahBaik,
                    'jumlah_dipinjam' => $alat->jumlah_dipinjam - $item->jumlah,
                    'jumlah_rusak' => $alat->jumlah_rusak + $jumlahRusak
                ]);
            }

            // Update peminjaman - mark as returned and completed
            $peminjaman->update([
                'kondisi_pengembalian' => $validated['kondisi_pengembalian'],
                'status' => 'Selesai'
            ]);

            DB::commit();

            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Peminjaman diselesaikan dan stok alat telah diperbarui.']);
            }

            return redirect()->back()
                            ->with('success', 'Peminjaman diselesaikan dan stok alat telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            
            return redirect()->back()
                            ->with('error', $e->getMessage());
        }
    }

    /**
     * Admin complete peminjaman simple (without form)
     */
    public function completeSimple(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Dipinjam') {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman tidak dapat diselesaikan. Status harus Dipinjam terlebih dahulu.'
                ], 400);
            }
            return redirect()->back()
                            ->with('error', 'Peminjaman tidak dapat diselesaikan. Status harus Dipinjam terlebih dahulu.');
        }

        // Check if already returned
        if (!empty($peminjaman->kondisi_pengembalian)) {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman sudah selesai dikembalikan.'
                ], 400);
            }
            return redirect()->back()
                            ->with('error', 'Peminjaman sudah selesai dikembalikan.');
        }

        \Log::info('Starting complete simple peminjaman process', [
            'peminjaman_id' => $peminjaman->id,
            'status' => $peminjaman->status
        ]);

        try {
            DB::beginTransaction();

            // Update equipment stock - assume all items returned in good condition
            foreach ($peminjaman->peminjamanItems as $item) {
                $alat = $item->alat;
                
                \Log::info('Processing item for simple complete', [
                    'alat_nama' => $alat->nama,
                    'jumlah_dipinjam' => $item->jumlah,
                    'jumlah_kembali' => $item->jumlah
                ]);

                $alat->update([
                    'jumlah_tersedia' => $alat->jumlah_tersedia + $item->jumlah,
                    'jumlah_dipinjam' => $alat->jumlah_dipinjam - $item->jumlah
                ]);
            }

            // Update peminjaman - mark as completed
            $peminjaman->update([
                'kondisi_pengembalian' => 'Dikembalikan dalam kondisi baik',
                'status' => 'Selesai'
            ]);

            DB::commit();

            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Peminjaman diselesaikan dan stok alat telah diperbarui.']);
            }

            return redirect()->back()
                            ->with('success', 'Peminjaman diselesaikan dan stok alat telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            
            return redirect()->back()
                            ->with('error', $e->getMessage());
        }
    }

    /**
     * Show tracking page for borrowing
     */
    public function tracking(Peminjaman $peminjaman)
    {
        \Log::info('Tracking method called', [
            'peminjaman_id' => $peminjaman->id,
            'status' => $peminjaman->status
        ]);
        
        $peminjaman->load('peminjamanItems.alat');
        
        // Calculate progress percentage for status bar
        $progressWidth = 0;
        switch ($peminjaman->status) {
            case 'Menunggu':
                $progressWidth = 25;
                break;
            case 'Disetujui':
                $progressWidth = 50;
                break;
            case 'Dipinjam':
                $progressWidth = 75;
                break;
            case 'Selesai':
                $progressWidth = 100;
                break;
            case 'Ditolak':
                $progressWidth = 0;
                break;
        }
        
        // Status text mapping for user-friendly display
        $statusText = [
            'Menunggu' => 'Menunggu Persetujuan Admin',
            'Disetujui' => 'Berhasil Divalidasi - Menunggu Konfirmasi (Datang ke Lab untuk TTD Surat)',
            'Dipinjam' => 'Berhasil - Alat Sedang Dipinjam',
            'Selesai' => 'Selesai - Peminjaman Telah Dikembalikan',
            'Ditolak' => 'Ditolak'
        ][$peminjaman->status] ?? 'Status Tidak Diketahui';
        
        // Check if request is for status check (AJAX)
        if (request('check_status')) {
            return response()->json([
                'status' => $peminjaman->status,
                'progress_width' => $progressWidth
            ]);
        }
        
        return view('user.components.facilities.equipment-rental-tracking', compact('peminjaman', 'progressWidth', 'statusText'));
    }

    /**
     * Download borrowing letter (dummy for now)
     */
    public function downloadLetter(Peminjaman $peminjaman)
    {
        // Check if borrowing is approved
        if (!in_array($peminjaman->status, ['Disetujui', 'Dipinjam', 'Selesai'])) {
            return redirect()->back()->with('error', 'Surat peminjaman belum tersedia. Status peminjaman harus disetujui terlebih dahulu.');
        }
        
        $peminjaman->load('peminjamanItems.alat');
        
        // For now, return a simple HTML view that can be printed/saved as PDF
        // In the future, you can generate actual PDF using libraries like TCPDF or DomPDF
        return view('user.components.facilities.equipment-rental-letter', compact('peminjaman'));
    }

    /**
     * Get detail peminjaman for admin (AJAX)
     */
    public function detail(Peminjaman $peminjaman)
    {
        $peminjaman->load('peminjamanItems.alat');
        
        $html = view('admin.components.shared.rental-detail', compact('peminjaman'))->render();
        
        return response()->json(['html' => $html]);
    }

    /**
     * Get items for completion form (AJAX)
     */
    public function items(Peminjaman $peminjaman)
    {
        $items = $peminjaman->peminjamanItems->map(function ($item) {
            return [
                'nama' => $item->alat->nama,
                'kode' => $item->alat->kode,
                'jumlah' => $item->jumlah
            ];
        });
        
        return response()->json(['items' => $items]);
    }
}

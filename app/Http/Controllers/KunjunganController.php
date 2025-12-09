<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function create()
    {
        return view('user.components.facilities.lab-visit');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Kunjungan store request received:', [
                'all_data' => $request->all(),
                'waktu_kunjungan' => $request->waktu_kunjungan,
                'tanggal' => $request->tanggal
            ]);
            
            $request->validate([
                'namaPengunjung' => 'required|string|max:255',
                'noHp' => 'required|string|max:20',
                'namaInstansi' => 'required|string|max:255',
                'tujuan' => 'required|string',
                'tanggal' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                    function ($attribute, $value, $fail) {
                        $dayOfWeek = \Carbon\Carbon::parse($value)->dayOfWeek;
                        if ($dayOfWeek === 0) { // 0 = Sunday
                            $fail('Kunjungan tidak dapat dilakukan pada hari Minggu. Silakan pilih hari lain.');
                        }
                    }
                ],
                'waktu_kunjungan' => 'required|string|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/',
                'jumlahPengunjung' => 'required|integer|min:1|max:50',
                'suratPengajuan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Store error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['general' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])->withInput();
        }

        // Validate waktu_kunjungan format "09:00-10:00"
        if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $request->waktu_kunjungan)) {
            return back()->withErrors(['waktu_kunjungan' => 'Format waktu kunjungan tidak valid. Gunakan format HH:MM-HH:MM'])->withInput();
        }
        
        // Parse waktu_kunjungan
        $waktuParts = explode('-', $request->waktu_kunjungan);
        $jamMulai = trim($waktuParts[0]);
        $jamSelesai = trim($waktuParts[1]);
        
        \Log::info('Waktu kunjungan validation:', [
            'waktu_kunjungan' => $request->waktu_kunjungan,
            'jamMulai' => $jamMulai,
            'jamSelesai' => $jamSelesai
        ]);

        // Check if the selected time slot is available and not already booked
        $selectedSchedule = Jadwal::where('tanggal', $request->tanggal)
            ->where('waktuKunjungan', $request->waktu_kunjungan)
            ->where('isActive', true)
            ->first();

        if (!$selectedSchedule) {
            return back()->withErrors(['waktu_kunjungan' => 'Slot waktu yang dipilih tidak tersedia.'])->withInput();
        }

        // Check if slot is already booked
        if ($selectedSchedule->kunjunganId) {
            return back()->withErrors(['waktu_kunjungan' => 'Slot waktu sudah dibooking oleh pengunjung lain.'])->withInput();
        }

        // Handle file upload
        $suratPath = $request->file('suratPengajuan')->store('surat-pengajuan', 'public');

        // Create kunjungan
        $kunjungan = Kunjungan::create([
            'namaPengunjung' => $request->namaPengunjung,
            'noHp' => $request->noHp,
            'namaInstansi' => $request->namaInstansi,
            'tujuan' => $request->tujuan,
            'jumlahPengunjung' => $request->jumlahPengunjung,
            'waktuKunjungan' => $request->waktu_kunjungan,
            'status' => 'PENDING',
            'suratPengajuan' => $suratPath
        ]);

        // Update the schedule to link with this kunjungan
        $selectedSchedule->update(['kunjunganId' => $kunjungan->id]);

        return redirect()->route('kunjungan.tracking', $kunjungan)
            ->with('success', 'Pengajuan kunjungan berhasil dikirim!');
    }

    public function tracking(Kunjungan $kunjungan)
    {
        $kunjungan->load('jadwal');
        return view('user.components.facilities.visit-tracking', compact('kunjungan'));
    }

    public function cancel(Kunjungan $kunjungan)
    {
        if (!$kunjungan->canBeCancelled()) {
            return back()->with('error', 'Kunjungan tidak dapat dibatalkan.');
        }

        // Free up the schedule
        $kunjungan->jadwal()->update(['kunjunganId' => null]);
        
        $kunjungan->update(['status' => 'CANCELLED']);

        return back()->with('success', 'Kunjungan berhasil dibatalkan.');
    }

    // Admin methods
    public function index()
    {
        $kunjungan = Kunjungan::with('jadwal')
            ->latest()
            ->paginate(10);

        return view('admin.components.tabs.visits', compact('kunjungan'));
    }

    public function show(Kunjungan $kunjungan)
    {
        return view('admin.components.shared.visit-detail', compact('kunjungan'));
    }

    public function detail(Kunjungan $kunjungan)
    {
        $kunjungan->load('jadwal');
        
        $html = view('admin.components.shared.visit-detail', compact('kunjungan'))->render();
        
        return response()->json(['html' => $html]);
    }

    public function approve(Kunjungan $kunjungan)
    {
        if (!$kunjungan->canBeApproved()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kunjungan tidak dapat disetujui.']);
            }
            return back()->with('error', 'Kunjungan tidak dapat disetujui.');
        }

        $kunjungan->update(['status' => 'PROCESSING']);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Kunjungan berhasil disetujui.']);
        }
        return back()->with('success', 'Kunjungan berhasil disetujui.');
    }

    public function reject(Kunjungan $kunjungan)
    {
        if (!$kunjungan->canBeApproved()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kunjungan tidak dapat ditolak.']);
            }
            return back()->with('error', 'Kunjungan tidak dapat ditolak.');
        }

        // Free up the schedule
        $kunjungan->jadwal()->update(['kunjunganId' => null]);
        
        $kunjungan->update(['status' => 'CANCELLED']);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Kunjungan berhasil ditolak.']);
        }
        return back()->with('success', 'Kunjungan berhasil ditolak.');
    }

    public function complete(Kunjungan $kunjungan)
    {
        if (!$kunjungan->canBeCompleted()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kunjungan tidak dapat diselesaikan.']);
            }
            return back()->with('error', 'Kunjungan tidak dapat diselesaikan.');
        }

        $kunjungan->update(['status' => 'COMPLETED']);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Kunjungan berhasil diselesaikan.']);
        }
        return back()->with('success', 'Kunjungan berhasil diselesaikan.');
    }
} 
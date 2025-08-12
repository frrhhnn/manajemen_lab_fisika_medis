<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiodataPengurus;
use App\Models\VisionMission;
use App\Models\Alat;
use App\Models\KategoriAlat;
use App\Models\Peminjaman;
use App\Models\Artikel;
use App\Models\Gambar;
use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get statistics
        $stats = [
            'total_alat' => Alat::count(),
            'total_kategori' => KategoriAlat::count(),
            'total_peminjaman' => Peminjaman::count(),
            'total_kunjungan' => Kunjungan::count(),
            'total_artikel' => Artikel::count(),
            'total_gambar' => Gambar::count(),
            'total_tersedia' => Alat::sum('jumlah_tersedia'),
            'total_dipinjam' => Alat::sum('jumlah_dipinjam'),
            'total_rusak' => Alat::sum('jumlah_rusak'),
        ];

        // Get recent rentals
        $recent_rentals = Peminjaman::with(['peminjamanItems.alat.kategoriAlat'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent visits
        $recent_visits = Kunjungan::with('jadwal')
            ->latest()
            ->take(5)
            ->get();

        // Kunjungan data untuk chart (6 bulan terakhir)
        $kunjunganChart = [];
        $peminjamanChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');
            
            // Data kunjungan per bulan
            $kunjunganCount = Kunjungan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            // Data peminjaman per bulan
            $peminjamanCount = Peminjaman::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $kunjunganChart[] = [
                'month' => $monthName,
                'count' => $kunjunganCount
            ];
            
            $peminjamanChart[] = [
                'month' => $monthName,
                'count' => $peminjamanCount
            ];
        }

        // Status distribution untuk pie chart
        $kunjunganByStatus = [
            'PENDING' => Kunjungan::where('status', 'PENDING')->count(),
            'PROCESSING' => Kunjungan::where('status', 'PROCESSING')->count(),
            'COMPLETED' => Kunjungan::where('status', 'COMPLETED')->count(),
            'CANCELLED' => Kunjungan::where('status', 'CANCELLED')->count(),
        ];

        $peminjamanByStatus = [
            'Menunggu' => Peminjaman::where('status', 'Menunggu')->count(),
            'Disetujui' => Peminjaman::where('status', 'Disetujui')->count(),
            'Dipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
            'Selesai' => Peminjaman::where('status', 'Selesai')->count(),
            'Ditolak' => Peminjaman::where('status', 'Ditolak')->count(),
        ];

        // Top 5 alat paling sering dipinjam
        $topAlat = Alat::withCount(['peminjamanItems' => function($query) {
                $query->whereHas('peminjaman', function($q) {
                    $q->whereIn('status', ['Disetujui', 'Dipinjam', 'Selesai']);
                });
            }])
            ->orderBy('peminjaman_items_count', 'desc')
            ->take(5)
            ->get()
            ->map(function($alat) {
                return [
                    'nama' => $alat->nama,
                    'count' => $alat->peminjaman_items_count ?? 0
                ];
            })
            ->filter(function($alat) {
                return $alat['count'] > 0; // Only include alat with actual usage
            });

        // Get all alat for equipment management
        $alats = Alat::with('kategoriAlat')->get();

        // Get all categories
        $kategoris = KategoriAlat::all();

        // Get all peminjaman for rental management
        $peminjamans = Peminjaman::with(['peminjamanItems.alat.kategoriAlat'])
            ->latest()
            ->get();

        // Get peminjaman statistics
        $peminjamanStats = [
            'Menunggu' => Peminjaman::where('status', 'Menunggu')->count(),
            'Disetujui' => Peminjaman::where('status', 'Disetujui')->count(),
            'Dipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
            'Selesai' => Peminjaman::where('status', 'Selesai')->count(),
            'Ditolak' => Peminjaman::where('status', 'Ditolak')->count(),
            'Overdue' => Peminjaman::where('status', 'Dipinjam')
                ->where('tanggal_pengembalian', '<', now())
                ->count(),
        ];

        // Get all kunjungan for visit management (no filtering, just pagination)
        $kunjungan = Kunjungan::with('jadwal')->latest()->paginate(10);

        // Get admin data for admin management (only for super admin)
        $admins = collect();
        $adminStats = [
            'super_admin' => 0,
            'admin' => 0,
            'total' => 0
        ];
        
        if (auth()->user()->isSuperAdmin()) {
            $admins = User::whereIn('role', ['admin', 'super_admin'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            $adminStats = [
                'super_admin' => User::where('role', 'super_admin')->count(),
                'admin' => User::where('role', 'admin')->count(),
                'total' => User::whereIn('role', ['admin', 'super_admin'])->count()
            ];
        }

        // Get shared data
        $sharedData = $this->getSharedData();

        // Add currentMonth for the schedule tab (format: Y-m)
        $currentMonth = now()->format('Y-m');

        return view('admin.dashboard', array_merge(
            compact('stats', 'recent_rentals', 'recent_visits', 'alats', 'kategoris', 'peminjamans', 'peminjamanStats', 'kunjungan', 'currentMonth', 'admins', 'adminStats', 'kunjunganChart', 'peminjamanChart', 'kunjunganByStatus', 'peminjamanByStatus', 'topAlat'),
            $sharedData
        ));
    }

    // Equipment Management - Integrated with Dashboard
    public function alatStore(Request $request)
    {
        try {
            // Debug logging
            \Log::info('alatStore called', [
                'data' => $request->all(),
                'hasFile' => $request->hasFile('image')
            ]);
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|unique:alat,kode|max:255',
                'deskripsi' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stok' => 'required|integer|min:0',
                'nama_kategori' => 'required|string|exists:kategori_alat,nama_kategori',
                'harga' => 'nullable|numeric|min:0'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('alat-images', 'public');
                $validated['image_url'] = $imagePath;
            } else {
                // Set default image path if no image uploaded
                $validated['image_url'] = 'images/facilities/default-alat.jpg';
            }

            // Set jumlah_tersedia sama dengan stok awal
            $validated['jumlah_tersedia'] = $validated['stok'];
            $validated['jumlah_dipinjam'] = 0;
            $validated['jumlah_rusak'] = 0;

            unset($validated['image']); // Remove image from validated data

            Alat::create($validated);

            // Always return JSON if Accept header contains application/json
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Alat berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Alat berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan alat: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan alat: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function alatUpdate(Request $request, Alat $alat)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|max:255|unique:alat,kode,' . $alat->id,
                'deskripsi' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stok' => 'required|integer|min:0',
                'jumlah_tersedia' => 'required|integer|min:0',
                'jumlah_dipinjam' => 'required|integer|min:0',
                'jumlah_rusak' => 'required|integer|min:0',
                'nama_kategori' => 'required|string|exists:kategori_alat,nama_kategori',
                'harga' => 'nullable|numeric|min:0'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($alat->image_url && Storage::disk('public')->exists($alat->image_url)) {
                    Storage::disk('public')->delete($alat->image_url);
                }
                
                $imagePath = $request->file('image')->store('alat-images', 'public');
                $validated['image_url'] = $imagePath;
            }

            unset($validated['image']); // Remove image from validated data

            $alat->update($validated);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Alat berhasil diperbarui'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Alat berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui alat: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui alat: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function alatDestroy(Alat $alat)
    {
        try {
            // Debug logging
            \Log::info('alatDestroy called', [
                'alat_id' => $alat->id,
                'alat_name' => $alat->nama
            ]);
            // Check if alat is being borrowed
            if ($alat->jumlah_dipinjam > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alat tidak dapat dihapus karena sedang dipinjam'
                ], 400);
            }

            // Delete image
            if ($alat->image_url && Storage::disk('public')->exists($alat->image_url)) {
                Storage::disk('public')->delete($alat->image_url);
            }

            $alat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Alat berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus alat: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getSharedData()
    {
        // Get data needed by artikel and galeri tabs
        $articles = Artikel::with('gambar')->latest()->get();
        $gambarPengurus = Gambar::pengurus()->with('biodataPengurus')->latest()->get();
        $gambarAcara = Gambar::acara()->with('artikel')->latest()->get();
        $gambarFasilitas = Gambar::fasilitas()->latest()->get();
        $pengurusList = \App\Models\BiodataPengurus::all();
        $artikelList = Artikel::all();
        
        // Convert articles to JSON for Alpine.js
        $articlesJson = $articles->map(function($artikel) {
            return [
                'id' => $artikel->id,
                'namaAcara' => $artikel->namaAcara,
                'penulis' => $artikel->penulis,
                'tanggalAcara' => $artikel->tanggalAcara->format('Y-m-d'),
                'formatted_date' => $artikel->formatted_date,
                'deskripsi' => $artikel->deskripsi,
                'excerpt' => $artikel->excerpt,
                'featured_image' => $artikel->featured_image,
                'gambar' => $artikel->gambar->map(function($gambar) {
                    return [
                        'id' => $gambar->id,
                        'url' => $gambar->url,
                        'full_url' => $gambar->fullUrl,
                        'judul' => $gambar->judul,
                        'deskripsi' => $gambar->deskripsi
                    ];
                })
            ];
        });
        
        return compact('articles', 'articlesJson', 'gambarPengurus', 'gambarAcara', 'gambarFasilitas', 'pengurusList', 'artikelList');
    }

    // Staff Management
    public function staffStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Create staff member
            $staff = BiodataPengurus::create([
                'nama' => $validated['nama'],
                'jabatan' => $validated['jabatan'],
            ]);

            // Handle image upload and create gambar record
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('staff', 'public');
                $imageUrl = 'storage/' . $imagePath;
                
                // Create gambar record
                \App\Models\Gambar::create([
                    'pengurusId' => $staff->id,
                    'acaraId' => null,
                    'url' => $imageUrl,
                    'kategori' => 'PENGURUS',
                    'judul' => $validated['nama'],
                    'deskripsi' => 'Foto ' . $validated['nama'],
                    'isVisible' => true,
                ]);
            } else {
                // Create default image record if no image uploaded
                \App\Models\Gambar::create([
                    'pengurusId' => $staff->id,
                    'acaraId' => null,
                    'url' => 'images/pengurus/default-pengurus.png',
                    'kategori' => 'PENGURUS',
                    'judul' => $validated['nama'],
                    'deskripsi' => 'Foto ' . $validated['nama'],
                    'isVisible' => true,
                ]);
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Pengurus berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Pengurus berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan pengurus: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan pengurus: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function staffUpdate(Request $request, $pengurusId)
    {
        try {
            \Log::info('Pengurus update request received', [
                'pengurus_id' => $pengurusId,
                'request_data' => $request->all(),
                'method' => $request->method(),
                'is_ajax' => $request->ajax()
            ]);

            // Find staff manually if route model binding fails
            $pengurus = BiodataPengurus::find($pengurusId);
            if (!$pengurus) {
                throw new \Exception("Pengurus dengan ID {$pengurusId} tidak ditemukan");
            }

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            \Log::info('Validation passed', ['validated_data' => $validated]);

            // Update pengurus member
            $pengurus->update([
                'nama' => $validated['nama'],
                'jabatan' => $validated['jabatan'],
            ]);

            // Handle image upload and update gambar record
            if ($request->hasFile('image')) {
                // Delete old image if exists
                $oldGambar = $pengurus->fotoPengurus;
                if ($oldGambar) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $oldGambar->url));
                    $oldGambar->delete();
                }

                $imagePath = $request->file('image')->store('staff', 'public');
                $imageUrl = 'storage/' . $imagePath;
                
                // Create new gambar record
                \App\Models\Gambar::create([
                    'pengurusId' => $pengurus->id,
                    'acaraId' => null,
                    'url' => $imageUrl,
                    'kategori' => 'PENGURUS',
                    'judul' => $validated['nama'],
                    'deskripsi' => 'Foto ' . $validated['nama'],
                    'isVisible' => true,
                ]);
                
                \Log::info('Image uploaded', ['image_path' => $imagePath]);
            } else {
                // If no image uploaded, check if pengurus already has an image
                // If not, create a default image record
                $existingGambar = $pengurus->fotoPengurus;
                if (!$existingGambar) {
                    \App\Models\Gambar::create([
                        'pengurusId' => $pengurus->id,
                        'acaraId' => null,
                        'url' => 'images/pengurus/default-pengurus.png',
                        'kategori' => 'PENGURUS',
                        'judul' => $validated['nama'],
                        'deskripsi' => 'Foto ' . $validated['nama'],
                        'isVisible' => true,
                    ]);
                }
            }

            \Log::info('Pengurus updated successfully', ['pengurus_id' => $pengurus->id]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Pengurus berhasil diperbarui'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Pengurus berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Pengurus update failed', [
                'pengurus_id' => $pengurusId ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui pengurus: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui pengurus: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function staffDestroy($pengurusId)
    {
        try {
            $pengurus = BiodataPengurus::find($pengurusId);
            if (!$pengurus) {
                throw new \Exception("Pengurus dengan ID {$pengurusId} tidak ditemukan");
            }

            $gambar = $pengurus->fotoPengurus;
            if ($gambar) {
                Storage::disk('public')->delete(str_replace('storage/', '', $gambar->url));
                $gambar->delete();
            }
            
            $pengurus->delete();

            return response()->json([
                'success' => true, 
                'message' => 'Pengurus berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pengurus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function staffEdit($pengurusId)
    {
        $pengurus = BiodataPengurus::findOrFail($pengurusId);
        return response()->json([
            'id' => $pengurus->id,
            'nama' => $pengurus->nama,
            'jabatan' => $pengurus->jabatan,
            'image_url' => $pengurus->image_url,
        ]);
    }

    // Vision Mission Management
    public function visionMissionIndex()
    {
        $visionMissions = VisionMission::orderBy('created_at', 'desc')->get();
        return response()->json($visionMissions);
    }

    public function visionMissionStore(Request $request)
    {
        $request->validate([
            'vision' => 'required|string|max:1000',
            'mission' => 'required|string|max:2000'
        ]);

        VisionMission::create([
            'vision' => $request->vision,
            'mission' => $request->mission
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Visi dan Misi berhasil ditambahkan'
        ]);
    }

    public function visionMissionEdit($id)
    {
        $visionMission = VisionMission::findOrFail($id);
        return response()->json($visionMission);
    }

    public function visionMissionUpdate(Request $request, $id)
    {
        $request->validate([
            'vision' => 'required|string|max:1000',
            'mission' => 'required|string|max:2000'
        ]);

        $visionMission = VisionMission::findOrFail($id);
        $visionMission->update([
            'vision' => $request->vision,
            'mission' => $request->mission
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Visi dan Misi berhasil diperbarui'
        ]);
    }

    public function visionMissionDestroy($id)
    {
        $visionMission = VisionMission::findOrFail($id);
        $visionMission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Visi dan Misi berhasil dihapus'
        ]);
    }

    // Article Management Methods
    public function artikelIndex()
    {
        // Redirect to dashboard since artikel management is handled there
        return redirect()->route('admin.dashboard');
    }

    public function artikelCreate()
    {
        return redirect()->route('admin.dashboard');
    }

    public function artikelStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'namaAcara' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'penulis' => 'nullable|string|max:255',
                'tanggalAcara' => 'required|date',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $artikel = Artikel::create($validated);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('artikel', 'public');
                    
                    Gambar::create([
                        'acaraId' => $artikel->id,
                        'url' => 'storage/' . $imagePath,
                        'kategori' => 'ACARA',
                        'judul' => $request->namaAcara,
                        'deskripsi' => 'Gambar untuk artikel: ' . $request->namaAcara,
                        'isVisible' => true,
                    ]);
                }
            }

            // Check if it's an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Artikel berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan artikel: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan artikel: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function artikelShow(Artikel $artikel)
    {
        return redirect()->route('admin.dashboard');
    }

    public function artikelEdit(Artikel $artikel)
    {
        return redirect()->route('admin.dashboard');
    }

    public function artikelUpdate(Request $request, Artikel $artikel)
    {
        try {
            $validated = $request->validate([
                'namaAcara' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'penulis' => 'nullable|string|max:255',
                'tanggalAcara' => 'required|date',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $artikel->update($validated);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('artikel', 'public');
                    
                    Gambar::create([
                        'acaraId' => $artikel->id,
                        'url' => 'storage/' . $imagePath,
                        'kategori' => 'ACARA',
                        'judul' => $request->namaAcara,
                        'deskripsi' => 'Gambar untuk artikel: ' . $request->namaAcara,
                        'isVisible' => true,
                    ]);
                }
            }

            // Check if it's an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil diperbarui'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Artikel berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui artikel: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui artikel: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function artikelDestroy(Artikel $artikel)
    {
        try {
            // Delete related images from storage and database
            foreach ($artikel->gambar as $gambar) {
                if (Storage::disk('public')->exists(str_replace('storage/', '', $gambar->url))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $gambar->url));
                }
                $gambar->delete();
            }

            $artikel->delete();

            // Check if it's an AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Artikel berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus artikel: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus artikel: ' . $e->getMessage()]);
        }
    }

    // Gallery Management Methods
    public function galeriIndex()
    {
        $gambarPengurus = Gambar::pengurus()->with('biodataPengurus')->latest()->get();
        $gambarAcara = Gambar::acara()->with('artikel')->latest()->get();
        $gambarFasilitas = Gambar::fasilitas()->latest()->get();
        
        // Get data for dropdowns
        $pengurusList = BiodataPengurus::all();
        $artikelList = Artikel::all();
        
        return redirect()->route('admin.dashboard', ['tab' => 'galeri'])
            ->with('galleryData', compact('gambarPengurus', 'gambarAcara', 'gambarFasilitas', 'pengurusList', 'artikelList'));
    }

    public function galeriStore(Request $request)
    {
        try {
            // Debug: Log the request data
            \Log::info('Galeri Store Request:', [
                'all_data' => $request->all(),
                'has_file' => $request->hasFile('image'),
                'file_size' => $request->file('image') ? $request->file('image')->getSize() : 'no file',
                'kategori' => $request->input('kategori'),
                'judul' => $request->input('judul'),
                'isVisible' => $request->input('isVisible')
            ]);

            $validated = $request->validate([
                'kategori' => 'required|in:PENGURUS,ACARA,FASILITAS',
                'pengurusId' => 'nullable|exists:biodataPengurus,id',
                'acaraId' => 'nullable|exists:artikel,id',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'isVisible' => 'nullable'
            ]);

            \Log::info('Validation passed');

            // Validate based on kategori
            if ($validated['kategori'] === 'PENGURUS' && empty($validated['pengurusId'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengurus harus dipilih untuk kategori Pengurus'
                ], 422);
            }

            if ($validated['kategori'] === 'ACARA' && empty($validated['acaraId'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel harus dipilih untuk kategori Acara'
                ], 422);
            }

            $imagePath = $request->file('image')->store('galeri', 'public');
            \Log::info('Image stored at: ' . $imagePath);
            
            // Handle isVisible field correctly
            $isVisible = $request->has('isVisible') ? true : false;
            
            $gambar = Gambar::create([
                'pengurusId' => $validated['pengurusId'],
                'acaraId' => $validated['acaraId'],
                'url' => 'storage/' . $imagePath,
                'kategori' => $validated['kategori'],
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'isVisible' => $isVisible
            ]);

            \Log::info('Gambar created successfully:', $gambar->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil ditambahkan ke galeri'
            ]);
        } catch (\Exception $e) {
            \Log::error('Galeri Store Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan gambar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function galeriUpdate(Request $request, Gambar $gambar)
    {
        try {
            // Debug logging
            \Log::info('Galeri Update Request:', [
                'all_data' => $request->all(),
                'has_file' => $request->hasFile('image'),
                'file_size' => $request->file('image') ? $request->file('image')->getSize() : 'no file',
                'gambar_id' => $gambar->id,
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type')
            ]);

            // Check if required fields are present
            if (!$request->has('judul') || empty($request->input('judul'))) {
                \Log::error('Missing or empty judul field');
                return response()->json([
                    'success' => false,
                    'message' => 'Judul field is required'
                ], 422);
            }

            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'isVisible' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            \Log::info('Validation passed');

            $data = [
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'] ?? '',
                'isVisible' => $request->has('isVisible')
            ];

            // Update image if provided
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload');
                
                // Delete old image if exists
                if ($gambar->url && Storage::disk('public')->exists(str_replace('storage/', '', $gambar->url))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $gambar->url));
                    \Log::info('Old image deleted');
                }
                
                $imagePath = $request->file('image')->store('galeri', 'public');
                $data['url'] = 'storage/' . $imagePath;
                \Log::info('New image stored at: ' . $data['url']);
            }

            $gambar->update($data);
            \Log::info('Gambar updated successfully:', $gambar->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            \Log::error('Galeri Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui gambar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function galeriEdit(Gambar $gambar)
    {
        try {
            return response()->json([
                'success' => true,
                'gambar' => [
                    'id' => $gambar->id,
                    'judul' => $gambar->judul,
                    'deskripsi' => $gambar->deskripsi,
                    'isVisible' => $gambar->isVisible,
                    'fullUrl' => $gambar->fullUrl,
                    'kategori' => $gambar->kategori
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data gambar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function galeriDestroy(Gambar $gambar)
    {
        try {
            // Delete image from storage
            if (Storage::disk('public')->exists(str_replace('storage/', '', $gambar->url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $gambar->url));
            }

            $gambar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus dari galeri'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function galeriToggleVisibility(Gambar $gambar)
    {
        try {
            $gambar->update(['isVisible' => !$gambar->isVisible]);
            
            return response()->json([
                'success' => true,
                'message' => 'Status tampilan gambar berhasil diubah',
                'isVisible' => $gambar->isVisible
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status tampilan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Admin Management Methods (Only for Super Admin)
    public function adminStore(Request $request)
    {
        try {
            // Check if user is super admin
            if (!auth()->user()->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya super admin yang dapat menambah admin.'
                ], 403);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|in:admin,super_admin'
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $validated['email_verified_at'] = now();

            User::create($validated);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Admin berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan admin: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan admin: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function adminUpdate(Request $request, User $admin)
    {
        try {
            // Check if user is super admin
            if (!auth()->user()->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya super admin yang dapat mengubah admin.'
                ], 403);
            }

            $rules = [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $admin->id,
                'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
                'role' => 'required|in:admin,super_admin'
            ];

            // Only validate password if provided
            if ($request->filled('password')) {
                $rules['password'] = 'required|string|min:6|confirmed';
            }

            $validated = $request->validate($rules);

            // Hash password if provided
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $admin->update($validated);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin berhasil diupdate'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Admin berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate admin: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal mengupdate admin: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function adminDestroy(User $admin)
    {
        try {
            // Check if user is super admin
            if (!auth()->user()->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya super admin yang dapat menghapus admin.'
                ], 403);
            }

            // Prevent deleting self
            if ($admin->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus akun sendiri.'
                ], 400);
            }

            $admin->delete();

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus admin: ' . $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\KategoriAlat;
use App\Models\Peminjaman;
use App\Models\Artikel;
use App\Models\Gambar;
use App\Models\Kunjungan;
use App\Models\User;
use App\Models\BiodataPengurus;

class DashboardController extends Controller
{
    public function index(Request $request)
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

        // Get shared data for content management
        $sharedData = $this->getSharedData();

        // Add currentMonth for the schedule tab (format: Y-m)
        $currentMonth = now()->format('Y-m');

        return view('admin.dashboard', array_merge(
            compact('stats', 'recent_rentals', 'recent_visits', 'alats', 'kategoris', 'peminjamans', 'peminjamanStats', 'kunjungan', 'currentMonth', 'admins', 'adminStats', 'kunjunganChart', 'peminjamanChart', 'kunjunganByStatus', 'peminjamanByStatus', 'topAlat'),
            $sharedData
        ));
    }

    private function getSharedData()
    {
        // Get data needed by artikel and galeri tabs
        $articles = Artikel::with('gambar')->latest()->get();
        $gambarPengurus = Gambar::pengurus()->with('biodataPengurus')->latest()->get();
        $gambarAcara = Gambar::acara()->with('artikel')->latest()->get();
        $gambarFasilitas = Gambar::fasilitas()->latest()->get();
        $pengurusList = BiodataPengurus::all();
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
}

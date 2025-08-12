<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Gambar;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample articles
        $artikel1 = Artikel::create([
            'namaAcara' => 'Inovasi Terbaru dalam Teknologi Deteksi Radiasi',
            'deskripsi' => 'Tim peneliti laboratorium berhasil mengembangkan prototipe detector radiasi generasi baru yang memiliki sensitivitas 40% lebih tinggi dari teknologi sebelumnya, membuka peluang aplikasi baru dalam bidang medis.',
            'penulis' => 'Dr. Ahmad Razak',
            'tanggalAcara' => '2024-12-25'
        ]);

        $artikel2 = Artikel::create([
            'namaAcara' => 'Kolaborasi Internasional Riset Aplikasi Nuklir',
            'deskripsi' => 'Laboratorium Fisika Medis USK menjalin kerjasama strategis dengan universitas terkemuka di Jepang untuk pengembangan aplikasi nuklir dalam diagnosis medis yang lebih presisi dan aman.',
            'penulis' => 'Prof. Dr. Sari Melati',
            'tanggalAcara' => '2024-12-20'
        ]);

        $artikel3 = Artikel::create([
            'namaAcara' => 'Workshop Keselamatan Radiasi untuk Tenaga Medis',
            'deskripsi' => 'Laboratorium menyelenggarakan workshop komprehensif tentang protokol keselamatan radiasi bagi tenaga medis di rumah sakit se-Aceh.',
            'penulis' => 'Dr. Fitri Rahmawati',
            'tanggalAcara' => '2024-12-10'
        ]);

        // Create sample images for articles
        Gambar::create([
            'acaraId' => $artikel1->id,
            'url' => 'images/facilities/geiger-muller-counter.jpg',
            'kategori' => 'ACARA',
            'judul' => 'Teknologi Deteksi Radiasi Terbaru',
            'deskripsi' => 'Prototipe detector radiasi generasi baru'
        ]);

        Gambar::create([
            'acaraId' => $artikel2->id,
            'url' => 'images/facilities/fasilitas.jpg',
            'kategori' => 'ACARA',
            'judul' => 'Kerjasama Internasional',
            'deskripsi' => 'Kolaborasi riset dengan universitas Jepang'
        ]);

        Gambar::create([
            'acaraId' => $artikel3->id,
            'url' => 'images/facilities/sr-radioaktif.jpg',
            'kategori' => 'ACARA',
            'judul' => 'Workshop Keselamatan Radiasi',
            'deskripsi' => 'Pelatihan protokol keselamatan radiasi'
        ]);
    }
}
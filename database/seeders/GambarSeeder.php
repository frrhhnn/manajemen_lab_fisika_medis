<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gambar;

class GambarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gambar::create([
            'pengurusId' => null,
            'acaraId' => null,
            'url' => 'images/facilities/fasilitas.jpg',
            'kategori' => 'FASILITAS',
            'judul' => 'Ruangan Laboratorium Fisika Medis',
            'deskripsi' => 'Ruangan laboratorium fisika medis yang berisi peralatan laboratorium fisika medis',
            'isVisible' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriAlat;

class KategoriAlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Detektor Radiasi',
            'Imaging Medical',
            'Dosimetri',
            'Kalibrasi',
            'Peralatan Laboratorium',
            'Sumber Radioaktif',
            'Alat Ukur',
            'Proteksi Radiasi',
            'Lainnya'
        ];

        foreach ($kategoris as $kategori) {
            KategoriAlat::create([
                'nama_kategori' => $kategori
            ]);
        }
    }
}

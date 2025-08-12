<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BiodataPengurus;
use App\Models\Gambar;
use Illuminate\Support\Str;

class BiodataPengurusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengurus = [
            [
                'nama' => 'Prof. Dr.Eng. Elin Yusibani, S.Si, M.Eng',
                'jabatan' => 'Dosen',
                'image_url' => 'images/staff/Elin-Yusibani.jpg',
            ],
            [
                'nama' => 'Dr. Rini Safitri, M.Si.',
                'jabatan' => 'Kepala Laboratorium',
                'image_url' => 'images/staff/Rini-Safitri.jpeg',
            ],
            [
                'nama' => 'Evi Yuvita, S.Si, M.Si.',
                'jabatan' => 'Dosen',
                'image_url' => 'images/staff/Evi-Yufita.jpeg',
            ],
            [
                'nama' => 'Irhamni, S.Si, M.Si.',
                'jabatan' => 'Dosen',
                'image_url' => 'images/staff/Irhamni.jpeg',
            ],
            [
                'nama' => 'Edwar Iswardy, S.Si, M.Si., Ph.D',
                'jabatan' => 'Dosen',
                'image_url' => 'images/staff/Edwar-Iswardy.jpeg',
            ],
            [
                'nama' => 'Fashbir, S.T, M.S.',
                'jabatan' => 'Dosen',
                'image_url' => 'images/staff/Fashbir.jpg',
            ],
            [
                'nama' => 'Intan Mulia Sari, S.Si, M.Si.',
                'jabatan' => 'Dosen',
                'image_url' => 'images/staff/Intan-Mulia-Sari.jpg',
            ],
        ];

        foreach ($pengurus as $member) {
            // Create pengurus member
            $pengurusMember = BiodataPengurus::create([
                'id' => Str::uuid(),
                'nama' => $member['nama'],
                'jabatan' => $member['jabatan'],
            ]);

            // Create corresponding gambar record
            Gambar::create([
                'pengurusId' => $pengurusMember->id,
                'acaraId' => null,
                'url' => $member['image_url'],
                'kategori' => 'PENGURUS',
                'judul' => $member['nama'],
                'deskripsi' => 'Foto ' . $member['nama'],
            ]);
        }
    }
}
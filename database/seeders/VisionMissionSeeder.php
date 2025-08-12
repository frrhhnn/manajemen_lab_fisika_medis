<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisionMission;

class VisionMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisionMission::create([
            'vision' => 'Menjadi laboratorium fisika medis terdepan yang unggul dalam pengembangan teknologi kesehatan dan pelayanan kesehatan yang berkualitas tinggi.',
            'mission' => "Menyediakan layanan laboratorium fisika medis yang akurat dan terpercaya.\nMengembangkan teknologi dan inovasi dalam bidang fisika medis.\nMeningkatkan kompetensi sumber daya manusia dalam bidang fisika medis.\nBerperan aktif dalam penelitian dan pengembangan ilmu pengetahuan.\nMemberikan kontribusi positif bagi kemajuan kesehatan masyarakat."
        ]);
    }
}

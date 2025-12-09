<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisionMission;

class VisionMissionController extends Controller
{
    public function index()
    {
        $visionMissions = VisionMission::orderBy('created_at', 'desc')->get();
        return response()->json($visionMissions);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'vision' => 'required|string|max:1000',
                'mission' => 'required|string|max:2000'
            ]);

            VisionMission::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Visi dan Misi berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan visi dan misi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(VisionMission $visionMission)
    {
        return response()->json($visionMission);
    }

    public function edit(VisionMission $visionMission)
    {
        return response()->json($visionMission);
    }

    public function update(Request $request, VisionMission $visionMission)
    {
        try {
            $validated = $request->validate([
                'vision' => 'required|string|max:1000',
                'mission' => 'required|string|max:2000'
            ]);

            $visionMission->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Visi dan Misi berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui visi dan misi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(VisionMission $visionMission)
    {
        try {
            $visionMission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Visi dan Misi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus visi dan misi: ' . $e->getMessage()
            ], 500);
        }
    }
}

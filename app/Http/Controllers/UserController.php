<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisionMission;
use App\Models\Gambar;

class UserController extends Controller
{
    /**
     * Display staff page
     */
    public function staffDisplay()
    {
        return view('user.components.staff.staff');
    }

    /**
     * Get latest vision and mission
     */
    public function getLatestVisionMission()
    {
        $visionMission = VisionMission::getLatest();
        return response()->json($visionMission);
    }

    /**
     * Display equipment rental page with real data
     */
    public function equipmentRental()
    {
        // Get real data from database - show all equipment including rented and damaged
        $alats = \App\Models\Alat::with('kategoriAlat')
                    ->latest()
                    ->get();
                    
        $kategoris = \App\Models\KategoriAlat::all();

        return view('user.components.facilities.equipment-rental', compact('alats', 'kategoris'));
    }

    /**
     * Display equipment detail page
     */
    public function equipmentDetail($id)
    {
        // Get real data from database
        $alat = \App\Models\Alat::with('kategoriAlat')->findOrFail($id);
        
        return view('user.components.facilities.equipment-detail', compact('alat'));
    }

    /**
     * Display lab visit page with consistent layout
     */
    public function labVisit()
    {
        return view('user.components.facilities.lab-visit');
    }
}

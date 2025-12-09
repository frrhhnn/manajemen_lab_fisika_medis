<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiodataPengurus;
use App\Models\Gambar;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class StaffController extends Controller
{
    public function index()
    {
        $staffList = BiodataPengurus::with('fotoPengurus')->latest()->get();
        return view('admin.staff.index', compact('staffList'));
    }

    public function store(Request $request)
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
                $imagePath = ImageHelper::storeImage($request->file('image'), 'staff', 'staff');
                $imageUrl = 'storage/' . $imagePath;
                
                // Create gambar record
                Gambar::create([
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
                Gambar::create([
                    'pengurusId' => $staff->id,
                    'acaraId' => null,
                    'url' => 'images/staff/default-staff.svg',
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

            return redirect()->route('admin.staff.index')
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

    public function show(BiodataPengurus $pengurus)
    {
        return view('admin.staff.show', compact('pengurus'));
    }

    public function edit(BiodataPengurus $pengurus)
    {
        return response()->json([
            'id' => $pengurus->id,
            'nama' => $pengurus->nama,
            'jabatan' => $pengurus->jabatan,
            'image_url' => $pengurus->image_url,
        ]);
    }

    public function update(Request $request, BiodataPengurus $pengurus)
    {
        try {
            \Log::info('Pengurus update request received', [
                'pengurus_id' => $pengurus->id,
                'request_data' => $request->all(),
                'method' => $request->method(),
                'is_ajax' => $request->ajax()
            ]);

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
                if ($oldGambar && is_object($oldGambar) && method_exists($oldGambar, 'delete')) {
                    // Use ImageHelper to delete old image
                    ImageHelper::deleteImage($oldGambar->url);
                    $oldGambar->delete();
                }

                $imagePath = ImageHelper::storeImage($request->file('image'), 'staff', 'staff');
                $imageUrl = 'storage/' . $imagePath;
                
                // Create new gambar record
                Gambar::create([
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
                    Gambar::create([
                        'pengurusId' => $pengurus->id,
                        'acaraId' => null,
                        'url' => 'images/staff/default-staff.svg',
                        'kategori' => 'PENGURUS',
                        'judul' => $validated['nama'],
                        'deskripsi' => 'Foto ' . $validated['nama'],
                        'isVisible' => true,
                    ]);
                } else {
                    // Update existing image title/description if exists
                    if (is_object($existingGambar) && method_exists($existingGambar, 'update')) {
                        $existingGambar->update([
                            'judul' => $validated['nama'],
                            'deskripsi' => 'Foto ' . $validated['nama'],
                        ]);
                    }
                }
            }

            \Log::info('Pengurus updated successfully', ['pengurus_id' => $pengurus->id]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Pengurus berhasil diperbarui'
                ]);
            }

            return redirect()->route('admin.staff.index')
                ->with('success', 'Pengurus berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Pengurus update failed', [
                'pengurus_id' => $pengurus->id ?? 'unknown',
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

    public function destroy(BiodataPengurus $pengurus)
    {
        try {
            $gambar = $pengurus->fotoPengurus;
            if ($gambar && is_object($gambar) && method_exists($gambar, 'delete')) {
                // Use ImageHelper for consistent image deletion
                ImageHelper::deleteImage($gambar->url);
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
}

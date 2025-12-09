<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gambar;
use App\Models\BiodataPengurus;
use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $gambarPengurus = Gambar::pengurus()->with('biodataPengurus')->latest()->get();
        $gambarAcara = Gambar::acara()->with('artikel')->latest()->get();
        $gambarFasilitas = Gambar::fasilitas()->latest()->get();
        
        // Get data for dropdowns
        $pengurusList = BiodataPengurus::all();
        $artikelList = Artikel::all();
        
        return view('admin.gallery.index', compact('gambarPengurus', 'gambarAcara', 'gambarFasilitas', 'pengurusList', 'artikelList'));
    }

    public function store(Request $request)
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

    public function show(Gambar $gambar)
    {
        return view('admin.gallery.show', compact('gambar'));
    }

    public function edit(Gambar $gambar)
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

    public function update(Request $request, Gambar $gambar)
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

    public function destroy(Gambar $gambar)
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

    public function toggleVisibility(Gambar $gambar)
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
}

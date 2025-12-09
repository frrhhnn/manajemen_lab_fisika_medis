<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\KategoriAlat;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategoriAlat')->get();
        $kategoris = KategoriAlat::all();
        
        return view('admin.equipment.index', compact('alats', 'kategoris'));
    }

    public function store(Request $request)
    {
        try {
            // Debug logging
            \Log::info('alatStore called', [
                'data' => $request->all(),
                'hasFile' => $request->hasFile('image')
            ]);
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|unique:alat,kode|max:255',
                'deskripsi' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stok' => 'required|integer|min:0',
                'nama_kategori' => 'required|string|exists:kategori_alat,nama_kategori',
                'harga' => 'nullable|numeric|min:0'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('alat-images', 'public');
                $validated['image_url'] = $imagePath;
            } else {
                // Set default image path if no image uploaded
                $validated['image_url'] = 'images/facilities/default-alat.jpg';
            }

            // Set jumlah_tersedia sama dengan stok awal
            $validated['jumlah_tersedia'] = $validated['stok'];
            $validated['jumlah_dipinjam'] = 0;
            $validated['jumlah_rusak'] = 0;

            unset($validated['image']); // Remove image from validated data

            Alat::create($validated);

            // Always return JSON if Accept header contains application/json
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Alat berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.equipment.index')
                ->with('success', 'Alat berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan alat: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan alat: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function update(Request $request, Alat $alat)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|max:255|unique:alat,kode,' . $alat->id,
                'deskripsi' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stok' => 'required|integer|min:0',
                'jumlah_tersedia' => 'required|integer|min:0',
                'jumlah_dipinjam' => 'required|integer|min:0',
                'jumlah_rusak' => 'required|integer|min:0',
                'nama_kategori' => 'required|string|exists:kategori_alat,nama_kategori',
                'harga' => 'nullable|numeric|min:0'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($alat->image_url && Storage::disk('public')->exists($alat->image_url)) {
                    Storage::disk('public')->delete($alat->image_url);
                }
                
                $imagePath = $request->file('image')->store('alat-images', 'public');
                $validated['image_url'] = $imagePath;
            }

            unset($validated['image']); // Remove image from validated data

            $alat->update($validated);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Alat berhasil diperbarui'
                ]);
            }

            return redirect()->route('admin.equipment.index')
                ->with('success', 'Alat berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui alat: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui alat: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Alat $alat)
    {
        try {
            // Debug logging
            \Log::info('alatDestroy called', [
                'alat_id' => $alat->id,
                'alat_name' => $alat->nama
            ]);
            
            // Check if alat is being borrowed
            if ($alat->jumlah_dipinjam > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alat tidak dapat dihapus karena sedang dipinjam'
                ], 400);
            }

            // Delete image
            if ($alat->image_url && Storage::disk('public')->exists($alat->image_url)) {
                Storage::disk('public')->delete($alat->image_url);
            }

            $alat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Alat berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus alat: ' . $e->getMessage()
            ], 500);
        }
    }

    // Category management methods
    public function categoryStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_kategori' => 'required|string|unique:kategori_alat,nama_kategori|max:255',
                'deskripsi' => 'nullable|string'
            ]);

            KategoriAlat::create($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.equipment.index')
                ->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan kategori: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan kategori: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function categoryUpdate(Request $request, KategoriAlat $kategori)
    {
        try {
            $validated = $request->validate([
                'nama_kategori' => 'required|string|max:255|unique:kategori_alat,nama_kategori,' . $kategori->id,
                'deskripsi' => 'nullable|string'
            ]);

            $kategori->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil diperbarui'
                ]);
            }

            return redirect()->route('admin.equipment.index')
                ->with('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui kategori: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui kategori: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function categoryDestroy(KategoriAlat $kategori)
    {
        try {
            // Check if category is being used
            if ($kategori->alat()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh alat'
                ], 400);
            }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Gambar;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Artikel::with('gambar')->latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'namaAcara' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'penulis' => 'nullable|string|max:255',
                'tanggalAcara' => 'required|date',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $artikel = Artikel::create($validated);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('artikel', 'public');
                    
                    Gambar::create([
                        'acaraId' => $artikel->id,
                        'url' => 'storage/' . $imagePath,
                        'kategori' => 'ACARA',
                        'judul' => $request->namaAcara,
                        'deskripsi' => 'Gambar untuk artikel: ' . $request->namaAcara,
                        'isVisible' => true,
                    ]);
                }
            }

            // Check if it's an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.articles.index')
                ->with('success', 'Artikel berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan artikel: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan artikel: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Artikel $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Artikel $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        try {
            $validated = $request->validate([
                'namaAcara' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'penulis' => 'nullable|string|max:255',
                'tanggalAcara' => 'required|date',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $artikel->update($validated);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('artikel', 'public');
                    
                    Gambar::create([
                        'acaraId' => $artikel->id,
                        'url' => 'storage/' . $imagePath,
                        'kategori' => 'ACARA',
                        'judul' => $request->namaAcara,
                        'deskripsi' => 'Gambar untuk artikel: ' . $request->namaAcara,
                        'isVisible' => true,
                    ]);
                }
            }

            // Check if it's an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil diperbarui'
                ]);
            }

            return redirect()->route('admin.articles.index')
                ->with('success', 'Artikel berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui artikel: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal memperbarui artikel: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Artikel $artikel)
    {
        try {
            // Delete related images from storage and database
            foreach ($artikel->gambar as $gambar) {
                if (Storage::disk('public')->exists(str_replace('storage/', '', $gambar->url))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $gambar->url));
                }
                $gambar->delete();
            }

            $artikel->delete();

            // Check if it's an AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.articles.index')
                ->with('success', 'Artikel berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus artikel: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus artikel: ' . $e->getMessage()]);
        }
    }

    public function deleteImage(Gambar $gambar)
    {
        try {
            // Check if gambar belongs to an article
            if ($gambar->kategori !== 'ACARA') {
                return response()->json([
                    'success' => false,
                    'message' => 'Gambar ini bukan milik artikel'
                ], 400);
            }

            // Delete image from storage
            if (Storage::disk('public')->exists(str_replace('storage/', '', $gambar->url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $gambar->url));
            }

            $gambar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }
}

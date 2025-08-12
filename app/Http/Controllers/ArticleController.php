<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Gambar;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        // Get articles from database with gambar relationship
        $articles = Artikel::with(['gambar' => function($query) {
            $query->where('kategori', 'ACARA');
        }])
        ->published()
        ->latest()
        ->get();

        $featuredArticle = $articles->first();
        $otherArticles = $articles->skip(1)->take(5);

        return view('user.components.article.index', compact('featuredArticle', 'otherArticles'));
    }

    /**
     * Display the specified article.
     */
    public function show($id)
    {
        $article = Artikel::with(['gambar' => function($query) {
            $query->where('kategori', 'ACARA');
        }])
        ->findOrFail($id);

        return view('user.components.article.show', compact('article'));
    }
} 
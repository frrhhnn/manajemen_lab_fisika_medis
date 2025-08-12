@extends('layouts.user-section')

@section('title', $article->namaAcara . ' - Laboratorium Fisika Medis')

@section('breadcrumb')
    <li class="text-white/60 flex-shrink-0">•</li>
    <li class="flex-shrink-0"><a href="{{ route('article.index') }}" class="text-white/80 hover:text-white transition-colors">Artikel</a></li>
    <li class="text-white/60 flex-shrink-0">•</li>
    <li class="text-white font-medium truncate">
        <span class="hidden md:inline">{{ Str::limit($article->namaAcara, 50) }}</span>
        <span class="md:hidden">{{ Str::limit($article->namaAcara, 20) }}</span>
    </li>
@endsection

@section('page-title', $article->namaAcara)

@section('page-description', $article->excerpt)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <!-- Article Content Section -->
    <section class="py-16 bg-white/50 backdrop-blur-sm">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <!-- Article Meta Info Card -->
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-100/50 mb-8" data-aos="fade-up">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <!-- Category Badge -->
                        <div class="flex items-center gap-4">
                            <div class="bg-emerald-500 text-white px-4 py-2 rounded-full font-bold text-sm">
                                Artikel
                            </div>
                        </div>
                        
                        <!-- Article Meta -->
                        <div class="flex flex-wrap items-center gap-6 text-gray-600">
                            @if($article->penulis)
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($article->penulis, 0, 1) }}
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $article->penulis }}</p>
                                    <p class="text-xs text-gray-500">Penulis</p>
                                </div>
                            </div>
                            @endif
                            <div class="flex items-center gap-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-calendar-alt text-emerald-500"></i>
                                    <span>{{ $article->formatted_date }}</span>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>

                <!-- Featured Image -->
                <div class="mb-12" data-aos="fade-up">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ $article->featured_image }}" alt="{{ $article->namaAcara }}" class="w-full h-64 md:h-96 object-cover" onerror="this.src='{{ asset('images/facilities/default-alat.jpg') }}'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                </div>

                <!-- Article Content -->
                <div class="prose prose-lg prose-gray max-w-none" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100/50">
                        <!-- Article Excerpt -->
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-r-xl mb-8">
                            <p class="text-lg text-emerald-800 font-medium leading-relaxed italic">
                                {{ $article->excerpt }}
                            </p>
                        </div>

                        <!-- Article Body -->
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($article->deskripsi)) !!}
                        </div>

                        <!-- Article Tags (Optional) -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Tags:</h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium">#FisikaMedis</span>
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium">#AplikasiNuklir</span>
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium">#Penelitian</span>
                                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium">#Teknologi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation & Share -->
                <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-6" data-aos="fade-up" data-aos-delay="300">
                    <!-- Back Button -->
                    <a href="{{ route('article.index') }}" class="group flex items-center gap-3 bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-arrow-left transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                        Kembali ke Artikel
                    </a>

                    <!-- Share Again -->
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600 font-medium">Bagikan artikel ini:</span>
                        <div class="flex gap-2">
                            <button class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Articles Section (Optional) -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Artikel Terkait</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Jelajahi artikel lainnya yang mungkin menarik bagi Anda.
                </p>
            </div>

            <!-- Related Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @php
                    $relatedArticles = \App\Models\Artikel::with(['gambar' => function($query) {
                        $query->where('kategori', 'ACARA');
                    }])
                    ->where('id', '!=', $article->id)
                    ->published()
                    ->latest()
                    ->take(3)
                    ->get();
                @endphp
                
                @foreach($relatedArticles as $index => $relatedArticle)
                <div class="group bg-white/90 backdrop-blur-sm rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/50 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ $relatedArticle->featured_image }}" alt="{{ $relatedArticle->namaAcara }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" onerror="this.src='{{ asset('images/facilities/default-alat.jpg') }}'">
                        <div class="absolute top-4 left-4 bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            Artikel
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                            {{ $relatedArticle->namaAcara }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $relatedArticle->excerpt }}
                        </p>
                        <a href="{{ route('article.show', $relatedArticle->id) }}" class="text-emerald-600 font-semibold text-sm hover:text-emerald-700 transition-colors">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .prose {
        max-width: none;
    }
    
    .prose p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .prose strong {
        color: #1f2937;
        font-weight: 600;
    }
    
    .prose ul {
        margin: 1.5rem 0;
        padding-left: 1.5rem;
    }
    
    .prose li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection 
@extends('layouts.user-section')

@section('title', 'Artikel & Berita - Laboratorium Fisika Medis')

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Artikel</li>
@endsection

@section('page-title', 'Artikel & Berita')

@section('page-description', 'Temukan informasi terkini seputar penelitian, inovasi, dan perkembangan terbaru dari Laboratorium Fisika Medis dan Aplikasi Nuklir.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <!-- Featured Article Section -->
    <section class="py-16 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #10B981 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-20 right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-32 h-32 bg-emerald-600/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Featured Article -->
            @if($featuredArticle)
            <div class="max-w-6xl mx-auto mb-16" data-aos="fade-up">
                <div class="group relative bg-white/90 backdrop-blur-sm rounded-3xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 border border-gray-100/50">
                    <div class="md:flex">
                        <!-- Featured Image -->
                        <div class="md:w-1/2 relative overflow-hidden">
                            <img src="{{ $featuredArticle->featured_image }}" alt="{{ $featuredArticle->namaAcara }}" class="w-full h-64 md:h-full object-cover transition-transform duration-500 group-hover:scale-105" onerror="this.src='{{ asset('images/facilities/default-alat.jpg') }}'">
                            <div class="absolute top-6 left-6 bg-emerald-500 text-white px-4 py-2 rounded-full font-bold">
                                Featured
                            </div>
                            <div class="absolute top-6 right-6 bg-white/90 backdrop-blur-sm text-emerald-600 px-3 py-1 rounded-full text-sm font-bold">
                                Terbaru
                            </div>
                        </div>
                        
                        <!-- Featured Content -->
                        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                            <!-- Meta Information -->
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-calendar-alt text-emerald-500"></i>
                                    <span>{{ $featuredArticle->formatted_date }}</span>
                                </div>
                            </div>

                            <!-- Title -->
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 leading-tight group-hover:text-emerald-600 transition-colors duration-300">
                                {{ $featuredArticle->namaAcara }}
                            </h2>

                            <!-- Excerpt -->
                            <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                                {{ $featuredArticle->excerpt }}
                            </p>

                            <!-- Author & CTA -->
                            <div class="flex items-center justify-between">
                                @if($featuredArticle->penulis)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($featuredArticle->penulis, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $featuredArticle->penulis }}</p>
                                        <p class="text-sm text-gray-500">Penulis</p>
                                    </div>
                                </div>
                                @else
                                <div></div>
                                @endif
                                <a href="{{ route('article.show', $featuredArticle->id) }}" class="group/btn bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <span class="flex items-center gap-2">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right transform group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Articles Grid Section -->
    <section class="py-16 bg-white/50 backdrop-blur-sm">
        <div class="container mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Artikel Lainnya</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Jelajahi koleksi artikel dan berita terbaru dari dunia penelitian fisika medis dan aplikasi nuklir.
                </p>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($otherArticles as $index => $article)
                <div class="group bg-white/90 backdrop-blur-sm rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/50 hover:border-emerald-500/20 hover:-translate-y-3" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                    <!-- Article Image -->
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ $article->featured_image }}" alt="{{ $article->namaAcara }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" onerror="this.src='{{ asset('images/facilities/default-alat.jpg') }}'">
                        <div class="absolute top-4 left-4 bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                            Artikel
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Article Content -->
                    <div class="p-6">
                        <!-- Article Meta -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt text-emerald-500"></i>
                                <span>{{ $article->formatted_date }}</span>
                            </div>
                        </div>

                        <!-- Article Title -->
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-emerald-600 transition-colors duration-300">
                            {{ $article->namaAcara }}
                        </h3>

                        <!-- Article Excerpt -->
                        <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                            {{ $article->excerpt }}
                        </p>

                        <!-- Article Footer -->
                        <div class="flex items-center justify-between">
                            @if($article->penulis)
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="far fa-user text-emerald-500"></i>
                                <span>{{ $article->penulis }}</span>
                            </div>
                            @else
                            <div></div>
                            @endif
                            <a href="{{ route('article.show', $article->id) }}" class="group/btn bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 rounded-xl font-semibold text-sm hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-md hover:shadow-lg">
                                <span class="flex items-center gap-2">
                                    Baca
                                    <i class="fas fa-arrow-right transform group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Load More Button (Optional) -->
            <div class="text-center mt-12" data-aos="fade-up">
                <button class="group bg-white/80 backdrop-blur-sm border-2 border-emerald-500 text-emerald-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-emerald-500 hover:text-white transition-all duration-300 shadow-lg hover:shadow-xl">
                    <span class="flex items-center gap-3">
                        <i class="fas fa-plus"></i>
                        Muat Lebih Banyak
                        <i class="fas fa-chevron-down transform group-hover:translate-y-1 transition-transform duration-300"></i>
                    </span>
                </button>
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
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection 
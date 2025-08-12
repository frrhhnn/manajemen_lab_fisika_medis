@php
    // Ambil artikel dari database dengan relasi gambar
    $articles = \App\Models\Artikel::with(['gambar' => function($query) {
        $query->where('kategori', 'ACARA');
    }])
    ->published()
    ->latest()
    ->take(3)
    ->get();
@endphp

<section id="article" class="relative py-24 bg-gradient-to-br from-white via-gray-50 to-gray-100 overflow-hidden scroll-mt-20">
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #10B981 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    <div class="absolute top-20 right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-10 w-40 h-40 bg-emerald-600/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16" data-aos="fade-down">
            <h2 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-6 font-inter">
                <span class="bg-gradient-to-r from-emerald-500 to-emerald-600 bg-clip-text text-transparent">
                    Artikel
                </span>
                <span class="text-gray-800"> & Berita</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 mx-auto mb-8"></div>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Ikuti perkembangan terbaru penelitian, inovasi, dan kegiatan laboratorium melalui artikel dan berita terkini yang kami sajikan.
            </p>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($articles as $index => $article)
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
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right transform group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('article.index') }}" class="group inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm border-2 border-emerald-500 text-emerald-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-emerald-500 hover:text-white transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-newspaper"></i>
                <span>Lihat Semua Artikel</span>
                <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform duration-300"></i>
            </a>
        </div>
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
</section>

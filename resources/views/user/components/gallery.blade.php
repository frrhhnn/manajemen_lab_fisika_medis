@php
    use App\Models\Gambar;
    
    // Get real data from database - only visible images
    $gambarPengurus = Gambar::pengurus()->visible()->with('biodataPengurus')->latest()->get();
    $gambarAcara = Gambar::acara()->visible()->with('artikel')->latest()->get();
    $gambarFasilitas = Gambar::fasilitas()->visible()->latest()->get();
    
    // Convert database models to format expected by frontend
    $galleryImages = [];
    
    // Add pengurus images
    foreach($gambarPengurus as $gambar) {
        $galleryImages[] = [
            'src' => $gambar->fullUrl,
            'title' => $gambar->judul,
            'description' => $gambar->deskripsi,
            'category' => 'pengurus',
            'type' => 'pengurus',
            'biodataPengurus' => $gambar->biodataPengurus
        ];
    }
    
    // Add acara images with special handling for artikel cards
    foreach($gambarAcara as $gambar) {
        $galleryImages[] = [
            'src' => $gambar->fullUrl,
            'title' => $gambar->judul,
            'description' => $gambar->deskripsi,
            'category' => 'acara',
            'type' => 'acara',
            'artikel' => $gambar->artikel,
            'isArtikel' => true,
            'artikelId' => $gambar->artikel ? $gambar->artikel->id : null
        ];
    }

    // Convert fasilitas images to facilities format for the facilities section
    $facilities = [];
    foreach($gambarFasilitas as $gambar) {
        $facilities[] = [
            'name' => $gambar->judul,
            'desc' => $gambar->deskripsi,
            'image' => $gambar->fullUrl,
            'status' => 'Aktif', // Default status
            'color' => 'emerald', // Default color
            'category' => 'fasilitas' // Default category
        ];
    }
    
    // If no facilities in database, show empty array
    if (empty($facilities)) {
        $facilities = [];
    }
@endphp

<!-- Pass data as JSON script -->
<script type="application/json" id="gallery-data">
{
    "galleryImages": {!! json_encode($galleryImages, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},
    "facilities": {!! json_encode($facilities, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!},
    "galleryCategories": {
        "semua": "Semua Foto",
        "pengurus": "Galeri Pengurus",
        "acara": "Galeri Acara",
        "fasilitas": "Galeri Fasilitas"
    },
    "facilityCategories": {
        "semua": "Semua Fasilitas",
        "deteksi": "Alat Deteksi",
        "pengukuran": "Alat Ukur",
        "kalibrasi": "Kalibrasi",
        "ruangan": "Ruangan",
        "keselamatan": "Keselamatan"
    }
}
</script>

<section id="gallery" class="relative py-24 bg-gradient-to-br from-gray-50 via-white to-gray-100 overflow-hidden scroll-mt-20">
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #10B981 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-600/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 relative z-10" x-data="galleryData()">
        <!-- Header -->
        <div class="text-center mb-10" data-aos="fade-down">
            <h2 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-6 font-inter">
                <span class="bg-gradient-to-r from-emerald-500 to-emerald-600 bg-clip-text text-transparent">
                    Galeri
                </span>
                <span class="text-gray-800"> & Fasilitas</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 mx-auto mb-8"></div>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Jelajahi galeri foto kegiatan laboratorium dan fasilitas unggulan yang mendukung riset dan inovasi terdepan.
            </p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex justify-center mb-12" data-aos="fade-up" data-aos-delay="200">
            <div class="flex flex-wrap justify-center gap-3">
                <template x-for="(label, key) in allCategories" :key="key">
                    <button 
                        @click="setFilter(key)"
                        :class="{ 
                            'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-lg': currentFilter === key,
                            'bg-white/80 backdrop-blur-sm text-emerald-600 hover:bg-white': currentFilter !== key 
                        }"
                        class="px-4 py-2 rounded-full font-semibold border border-emerald-500 text-sm transition-all duration-300 shadow-md"
                        x-text="label">
                    </button>
                </template>
            </div>
        </div>

        <!-- Content Panes -->
        <div class="relative min-h-[500px]">
            <div x-transition:enter="transition-all ease-in-out duration-500" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <template x-for="(image, index) in filteredImages" :key="`image-${index}`">
                        <div 
                            @click="handleImageClick(image)" 
                            class="group relative bg-gray-200 rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-300 aspect-square hover:-translate-y-2" 
                            data-aos="zoom-in" 
                            :data-aos-delay="100 + (index * 50)"
                            :class="{ 'ring-4 ring-emerald-500': image.isArtikel }">
                            <img :src="image.src" :alt="image.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <h3 class="font-bold text-lg mb-1" x-text="image.title"></h3>
                                <p class="text-sm text-gray-200 opacity-90" x-text="image.description"></p>
                            </div>
                            <div class="absolute top-4 right-4 text-white px-2 py-1 rounded-full text-xs font-bold" 
                                 :class="image.isArtikel ? 'bg-emerald-500' : 'bg-blue-500'">
                                <i :class="image.isArtikel ? 'fas fa-newspaper' : 'fas fa-expand-alt'"></i>
                            </div>
                            <div x-show="image.isArtikel" class="absolute top-4 left-4 bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                Artikel
                            </div>
                            <div x-show="image.category === 'fasilitas'" class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                Fasilitas
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <div x-show="filteredImages.length === 0" class="text-center py-12">
                    <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada foto ditemukan</h3>
                    <p class="text-gray-500">Coba pilih kategori lain untuk melihat foto yang tersedia.</p>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div x-show="showModal" @keydown.escape.window="closeModal()" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.away="closeModal()" class="relative max-w-5xl max-h-[90vh] w-full mx-4">
                <!-- Image -->
                <img :src="modalImage.src" :alt="modalImage.title" class="w-full h-full max-h-[70vh] object-contain rounded-2xl shadow-2xl">
                
                <!-- Image Info -->
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 mt-4 shadow-xl">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2" x-text="modalImage.title"></h3>
                    <p class="text-gray-600 leading-relaxed" x-text="modalImage.description"></p>
                </div>
                
                <!-- Close Button -->
                <button @click="closeModal()" class="absolute top-4 right-4 text-white bg-black/50 hover:bg-black/70 rounded-full p-3 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<script>
function galleryData() {
    // Get data from JSON script tag
    const dataElement = document.getElementById('gallery-data');
    const data = JSON.parse(dataElement.textContent);
    
    return {
        // State
        currentFilter: 'semua',
        showModal: false,
        modalImage: { src: '', title: '', description: '' },
        
        // Data
        galleryImages: data.galleryImages,
        facilities: data.facilities,
        
        // Combined categories
        get allCategories() {
            return {
                'semua': 'Semua Foto',
                'pengurus': 'Galeri Pengurus',
                'acara': 'Galeri Acara',
                'fasilitas': 'Galeri Fasilitas'
            };
        },
        
        // Combined images
        get allImages() {
            return [...this.galleryImages, ...this.facilities.map(facility => ({
                src: facility.image,
                title: facility.name,
                description: facility.desc,
                category: facility.category,
                type: 'facility'
            }))];
        },

        // Computed properties
        get filteredImages() {
            if (this.currentFilter === 'semua') return this.allImages;
            return this.allImages.filter(image => image.category === this.currentFilter);
        },

        // Methods
        setFilter(filter) {
            this.currentFilter = filter;
        },
        
        handleImageClick(image) {
            if (image.isArtikel && image.artikelId) {
                // Redirect to article detail page
                window.location.href = `/artikel/${image.artikelId}`;
            } else {
                // Open modal for regular gallery images
                this.openModal(image);
            }
        },
        
        openModal(image) {
            this.modalImage = image;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = 'auto';
        }
    }
}
</script>

<style>
.aspect-square {
    aspect-ratio: 1 / 1;
}
</style>

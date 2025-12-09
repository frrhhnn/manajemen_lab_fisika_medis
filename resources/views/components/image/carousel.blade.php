@props([
    'images' => [],
    'alt' => 'Gallery Image',
    'autoplay' => false,
    'interval' => 5000,
    'indicators' => true,
    'controls' => true,
    'height' => '400px'
])

@php
    use App\Helpers\ImageHelper;
    
    // Process images to ensure URLs are optimized
    $processedImages = collect($images)->map(function($image) {
        if (is_string($image)) {
            return [
                'url' => ImageHelper::getImageUrl($image),
                'alt' => $this->alt,
                'caption' => null
            ];
        }
        
        return [
            'url' => ImageHelper::getImageUrl($image['url'] ?? $image['src'] ?? null),
            'alt' => $image['alt'] ?? $this->alt,
            'caption' => $image['caption'] ?? null
        ];
    })->toArray();
    
    $carouselId = 'carousel-' . uniqid();
@endphp

@if(count($processedImages) > 0)
<div 
    id="{{ $carouselId }}" 
    class="relative w-full"
    style="height: {{ $height }}"
    x-data="{ 
        currentSlide: 0, 
        totalSlides: {{ count($processedImages) }},
        autoplay: {{ $autoplay ? 'true' : 'false' }},
        interval: {{ $interval }},
        timer: null,
        
        init() {
            if (this.autoplay) {
                this.startAutoplay();
            }
        },
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        prevSlide() {
            this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        },
        
        goToSlide(index) {
            this.currentSlide = index;
        },
        
        startAutoplay() {
            this.timer = setInterval(() => {
                this.nextSlide();
            }, this.interval);
        },
        
        stopAutoplay() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        }
    }"
    @mouseenter="stopAutoplay()"
    @mouseleave="autoplay && startAutoplay()"
>
    <!-- Image Container -->
    <div class="relative h-full overflow-hidden rounded-lg bg-gray-200">
        @foreach($processedImages as $index => $image)
        <div 
            class="absolute inset-0 transition-transform duration-500 ease-in-out"
            x-show="currentSlide === {{ $index }}"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            <x-image.optimized
                :src="$image['url']"
                :alt="$image['alt']"
                class="w-full h-full object-cover"
                :shadow="false"
                :rounded="false"
            />
            
            @if($image['caption'])
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                <p class="text-white text-sm font-medium">{{ $image['caption'] }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @if($controls && count($processedImages) > 1)
    <!-- Previous Button -->
    <button 
        type="button" 
        class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" 
        @click="prevSlide()"
    >
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 transition-colors group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </span>
    </button>

    <!-- Next Button -->
    <button 
        type="button" 
        class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" 
        @click="nextSlide()"
    >
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50 transition-colors group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </span>
    </button>
    @endif

    @if($indicators && count($processedImages) > 1)
    <!-- Indicators -->
    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
        @foreach($processedImages as $index => $image)
        <button 
            type="button" 
            class="w-3 h-3 rounded-full transition-colors"
            :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white/50'"
            @click="goToSlide({{ $index }})"
        ></button>
        @endforeach
    </div>
    @endif
</div>
@else
<div class="w-full bg-gray-200 rounded-lg flex items-center justify-center" style="height: {{ $height }}">
    <div class="text-center text-gray-500">
        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <p class="text-sm">No images available</p>
    </div>
</div>
@endif

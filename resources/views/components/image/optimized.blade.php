@props([
    'src' => null,
    'alt' => 'Image',
    'class' => '',
    'width' => null,
    'height' => null,
    'loading' => 'lazy',
    'fallback' => 'images/default/placeholder.png',
    'aspectRatio' => null,
    'rounded' => false,
    'shadow' => false,
    'objectFit' => 'cover'
])

@php
    use App\Helpers\ImageHelper;
    
    // Get optimized image URL
    $imageUrl = ImageHelper::getImageUrl($src, $fallback);
    
    // Build CSS classes
    $classes = collect([
        'image-component',
        'transition-all duration-300',
        $class
    ]);
    
    if ($rounded) {
        $classes->push('rounded-lg');
    }
    
    if ($shadow) {
        $classes->push('shadow-lg hover:shadow-xl');
    }
    
    // Build inline styles
    $styles = collect();
    
    if ($width) {
        $styles->push("width: {$width}");
    }
    
    if ($height) {
        $styles->push("height: {$height}");
    }
    
    if ($aspectRatio) {
        $styles->push("aspect-ratio: {$aspectRatio}");
    }
    
    $styles->push("object-fit: {$objectFit}");
    
    $styleString = $styles->implode('; ');
@endphp

<img 
    src="{{ $imageUrl }}" 
    alt="{{ $alt }}"
    class="{{ $classes->implode(' ') }}"
    style="{{ $styleString }}"
    loading="{{ $loading }}"
    onerror="this.onerror=null; this.src='{{ ImageHelper::getImageUrl(null, $fallback) }}';"
    {{ $attributes }}
>

@pushOnce('styles')
<style>
.image-component {
    background-color: #f3f4f6;
    background-image: 
        linear-gradient(45deg, #e5e7eb 25%, transparent 25%), 
        linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), 
        linear-gradient(45deg, transparent 75%, #e5e7eb 75%), 
        linear-gradient(-45deg, transparent 75%, #e5e7eb 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
}

.image-component:hover {
    transform: scale(1.02);
}

/* Professional loading skeleton */
.image-component[src=""] {
    background: linear-gradient(90deg, #f0f0f0 25%, rgba(255,255,255,0.5) 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>
@endPushOnce

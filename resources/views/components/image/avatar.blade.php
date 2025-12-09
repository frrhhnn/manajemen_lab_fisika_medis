@props([
    'src' => null,
    'alt' => 'Avatar',
    'size' => 'md',
    'name' => null,
    'fallback' => 'images/staff/default-staff.png',
    'border' => true,
    'shadow' => true
])

@php
    use App\Helpers\ImageHelper;
    
    // Get optimized image URL
    $imageUrl = ImageHelper::getImageUrl($src, $fallback);
    
    // Size configurations
    $sizes = [
        'xs' => 'w-8 h-8 text-xs',
        'sm' => 'w-10 h-10 text-sm', 
        'md' => 'w-12 h-12 text-base',
        'lg' => 'w-16 h-16 text-lg',
        'xl' => 'w-20 h-20 text-xl',
        '2xl' => 'w-24 h-24 text-2xl'
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    // Build CSS classes
    $classes = collect([
        'avatar-component',
        'inline-flex items-center justify-center',
        'rounded-full overflow-hidden',
        'bg-gradient-to-r from-blue-500 to-purple-600',
        'transition-all duration-300',
        $sizeClass
    ]);
    
    if ($border) {
        $classes->push('ring-2 ring-white ring-offset-2');
    }
    
    if ($shadow) {
        $classes->push('shadow-lg hover:shadow-xl');
    }
    
    // Generate initials from name
    $initials = '';
    if ($name) {
        $words = explode(' ', trim($name));
        $initials = strtoupper(substr($words[0], 0, 1));
        if (count($words) > 1) {
            $initials .= strtoupper(substr($words[1], 0, 1));
        }
    }
@endphp

<div class="{{ $classes->implode(' ') }}" {{ $attributes }}>
    @if($src && $imageUrl !== ImageHelper::getImageUrl(null, $fallback))
        <img 
            src="{{ $imageUrl }}" 
            alt="{{ $alt }}"
            class="w-full h-full object-cover"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        >
        <div class="w-full h-full flex items-center justify-center text-white font-semibold" style="display: none;">
            {{ $initials ?: '?' }}
        </div>
    @else
        <div class="w-full h-full flex items-center justify-center text-white font-semibold">
            {{ $initials ?: '?' }}
        </div>
    @endif
</div>

@pushOnce('styles')
<style>
.avatar-component:hover {
    transform: scale(1.05);
}

.avatar-component img {
    transition: opacity 0.3s ease;
}

.avatar-component:hover img {
    opacity: 0.9;
}
</style>
@endPushOnce

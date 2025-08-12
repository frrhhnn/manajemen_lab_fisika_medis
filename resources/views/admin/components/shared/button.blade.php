<!-- Button Component -->
<button type="{{ $type ?? 'button' }}"
        @if(isset($disabled) && $disabled) disabled @endif
        @if(isset($onClick)) @click="{{ $onClick }}" @endif
        class="inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition-colors
        {{ $variant === 'primary' ? 'bg-green-500 text-white hover:bg-green-600 focus:ring-green-500' : '' }}
        {{ $variant === 'secondary' ? 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-green-500' : '' }}
        {{ $variant === 'success' ? 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500' : '' }}
        {{ $variant === 'danger' ? 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500' : '' }}
        {{ $variant === 'warning' ? 'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500' : '' }}
        {{ $variant === 'info' ? 'bg-green-500 text-white hover:bg-green-600 focus:ring-green-500' : '' }}
        {{ $variant === 'light' ? 'bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-500' : '' }}
        {{ $variant === 'dark' ? 'bg-gray-800 text-white hover:bg-gray-900 focus:ring-gray-500' : '' }}
        {{ $variant === 'link' ? 'text-green-600 hover:text-green-700 underline' : '' }}
        {{ isset($disabled) && $disabled ? 'opacity-50 cursor-not-allowed' : '' }}
        {{ isset($block) && $block ? 'w-full' : '' }}
        {{ isset($size) && $size === 'sm' ? 'px-3 py-1.5 text-xs' : '' }}
        {{ isset($size) && $size === 'lg' ? 'px-6 py-3 text-base' : '' }}
        {{ $class ?? '' }}
        focus:outline-none focus:ring-2 focus:ring-offset-2">
    
    @if(isset($icon))
    <i class="fas fa-{{ $icon }}"></i>
    @endif

    {{ $slot }}

    @if(isset($loading) && $loading)
    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    @endif
</button> 
<!-- Modal Component -->
<div x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

    <!-- Modal panel -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full {{ $size ?? 'sm:max-w-lg' }}">
            
            <!-- Modal header -->
            <div class="bg-white px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $title }}</h3>
                    <button @click="show = false" type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @if(isset($subtitle))
                <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
                @endif
            </div>

            <!-- Modal content -->
            <div class="px-4 py-5 sm:p-6 {{ isset($scrollable) && $scrollable ? 'max-h-[60vh] overflow-y-auto' : '' }}">
                {{ $slot }}
            </div>

            <!-- Modal footer -->
            @if(isset($footer))
            <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div> 
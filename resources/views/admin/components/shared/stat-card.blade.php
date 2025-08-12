<!-- Stat Card Component -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold {{ $textColor ?? 'text-gray-800' }}">{{ $value }}</p>
            @if(isset($trend))
            <p class="text-xs {{ $trendColor ?? 'text-emerald-600' }} mt-1">
                <i class="fas fa-{{ $trendIcon ?? 'arrow-up' }}"></i> {{ $trend }}
            </p>
            @endif
        </div>
        <div>
            <div class="w-12 h-12 {{ $bgColor ?? 'bg-emerald-100' }} rounded-full flex items-center justify-center">
                <i class="fas fa-{{ $icon ?? 'chart-bar' }} {{ $iconColor ?? 'text-emerald-600' }}"></i>
            </div>
        </div>
    </div>
</div> 
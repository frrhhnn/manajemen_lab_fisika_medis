<!-- Form Group Component -->
<div class="space-y-2">
    @if(isset($label))
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
        @if(isset($required) && $required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif

    @if(isset($description))
    <p class="text-sm text-gray-500">{{ $description }}</p>
    @endif

    @if($type === 'text' || $type === 'email' || $type === 'password' || $type === 'number' || $type === 'tel' || $type === 'url')
    <input type="{{ $type }}"
           id="{{ $id }}"
           name="{{ $name ?? $id }}"
           value="{{ $value ?? '' }}"
           placeholder="{{ $placeholder ?? '' }}"
           @if(isset($required) && $required) required @endif
           @if(isset($disabled) && $disabled) disabled @endif
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm {{ isset($error) ? 'border-red-300' : '' }} {{ $inputClass ?? '' }}">
    
    @elseif($type === 'textarea')
    <textarea id="{{ $id }}"
              name="{{ $name ?? $id }}"
              rows="{{ $rows ?? 3 }}"
              placeholder="{{ $placeholder ?? '' }}"
              @if(isset($required) && $required) required @endif
              @if(isset($disabled) && $disabled) disabled @endif
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm {{ isset($error) ? 'border-red-300' : '' }} {{ $inputClass ?? '' }}">{{ $value ?? '' }}</textarea>
    
    @elseif($type === 'select')
    <select id="{{ $id }}"
            name="{{ $name ?? $id }}"
            @if(isset($required) && $required) required @endif
            @if(isset($disabled) && $disabled) disabled @endif
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm {{ isset($error) ? 'border-red-300' : '' }} {{ $inputClass ?? '' }}">
        @if(isset($placeholder))
        <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" {{ isset($value) && $value == $optionValue ? 'selected' : '' }}>
            {{ $optionLabel }}
        </option>
        @endforeach
    </select>

    @elseif($type === 'checkbox')
    <div class="flex items-center">
        <input type="checkbox"
               id="{{ $id }}"
               name="{{ $name ?? $id }}"
               value="{{ $value ?? '1' }}"
               @if(isset($checked) && $checked) checked @endif
               @if(isset($required) && $required) required @endif
               @if(isset($disabled) && $disabled) disabled @endif
               class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500 {{ $inputClass ?? '' }}">
        @if(isset($checkboxLabel))
        <label for="{{ $id }}" class="ml-2 block text-sm text-gray-900">{{ $checkboxLabel }}</label>
        @endif
    </div>

    @elseif($type === 'radio')
    <div class="space-y-2">
        @foreach($options as $optionValue => $optionLabel)
        <div class="flex items-center">
            <input type="radio"
                   id="{{ $id }}_{{ $loop->index }}"
                   name="{{ $name ?? $id }}"
                   value="{{ $optionValue }}"
                   @if(isset($value) && $value == $optionValue) checked @endif
                   @if(isset($required) && $required) required @endif
                   @if(isset($disabled) && $disabled) disabled @endif
                   class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-500 {{ $inputClass ?? '' }}">
            <label for="{{ $id }}_{{ $loop->index }}" class="ml-2 block text-sm text-gray-900">
                {{ $optionLabel }}
            </label>
        </div>
        @endforeach
    </div>

    @elseif($type === 'file')
    <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
        <div class="space-y-1 text-center">
            <i class="fas fa-upload mx-auto h-12 w-12 text-gray-400"></i>
            <div class="flex text-sm text-gray-600">
                <label for="{{ $id }}" class="relative cursor-pointer rounded-md bg-white font-medium text-green-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2 hover:text-green-700">
                    <span>Upload a file</span>
                    <input id="{{ $id }}"
                           name="{{ $name ?? $id }}"
                           type="file"
                           @if(isset($accept)) accept="{{ $accept }}" @endif
                           @if(isset($required) && $required) required @endif
                           @if(isset($disabled) && $disabled) disabled @endif
                           class="sr-only {{ $inputClass ?? '' }}">
                </label>
                <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">
                {{ $fileTypes ?? 'PNG, JPG, GIF up to 10MB' }}
            </p>
        </div>
    </div>
    @endif

    @if(isset($error))
    <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if(isset($help))
    <p class="mt-2 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div> 
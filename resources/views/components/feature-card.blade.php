@props(['title', 'icon', 'color'])

<div class="p-6 bg-gray-50 rounded-lg shadow-lg hover:shadow-xl">
    <div class="flex justify-center">
        <x-icon name="{{ $icon }}" class="h-12 w-12 text-{{ $color }}-600" />
    </div>
    <h3 class="mt-6 text-xl font-semibold text-center">{{ $title }}</h3>
    <p class="mt-4 text-gray-600 text-center">
        {{ $slot }}
    </p>
</div>

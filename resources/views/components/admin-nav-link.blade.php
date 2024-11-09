@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center font-bold text-gray-700 hover:bg-gray-100 rounded-md transition ease-in-out duration-150'
            : 'flex items-center font-bold text-gray-700 hover:bg-gray-100 rounded-md transition ease-in-out duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

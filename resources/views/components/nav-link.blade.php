@props(['active', 'iconPath' => null])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-4 py-2  text-lg font-bold leading-7 text-blue-600 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2  b text-lg font-bold leading-7 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if ($iconPath && file_exists(public_path($iconPath)))
        <span class="mr-3">
            {!! file_get_contents(public_path($iconPath)) !!}
        </span>
    @endif
    {{ $slot }}
</a>

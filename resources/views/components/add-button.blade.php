@props(['href' => null])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center px-4 py-2 bg-dark border border-transparent
                                            rounded-md text-s text-button-white font-semibold uppercase tracking-widest
                                            hover:bg-dark-hover focus:outline-none focus:border-blue-700
                                            focus:ring focus:ring-blue-200 disabled:opacity-25 transition',
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge([
            'type' => 'submit',
            'class' => 'inline-flex items-center px-4 py-2 bg-dark border border-transparent
                                                rounded-md text-s text-button-white font-semibold uppercase tracking-widest
                                                hover:bg-dark-hover focus:outline-none focus:border-blue-700
                                                focus:ring focus:ring-blue-200 disabled:opacity-25 transition',
        ]) }}>
        {{ $slot }}
    </button>
@endif

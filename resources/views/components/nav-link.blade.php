@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-d1c2a5 text-sm font-medium leading-5 text-333333 focus:outline-none focus:border-b39c7e transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-333333 hover:text-333333 focus:outline-none focus:text-333333 focus:border-d1c2a5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

@props(['value', 'color' => null])

@if(is_null($color))
    <span {{ $attributes->merge(['class' => "bg-info text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"]) }}>
        {{ isset($value) ? strtoupper($value) : $slot }}
    </span>
@else
    <span {{ $attributes->merge(['class' => "bg-$color-100 text-$color-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"]) }}>
        {{ isset($value) ? strtoupper($value) : $slot }}
    </span>
@endif

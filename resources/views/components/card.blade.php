@props(['class' => ''])
<div {{ $attributes->merge(['class' => "bg-white shadow rounded-lg border border-gray-200 $class"]) }}>
    {{ $slot }}
</div>

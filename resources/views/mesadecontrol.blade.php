<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mesa de Control
        </h2>
    </x-slot>

    <div class="py-12">
        @livewire('Reportes')
    </div>
</x-app-layout>
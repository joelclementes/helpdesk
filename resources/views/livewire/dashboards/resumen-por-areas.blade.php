<div class="max-w-7xl mx-auto px-4 space-y-6">
    {{-- Filtros --}}
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="px-4 py-3 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Resumen por áreas</h2>
        </div>

        <div class="p-4 grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-3">
            <div>
                <x-label value="Fecha inicial" />
                <x-input type="date" wire:model.defer="fechainicial" class="w-full mt-1" />
                @error('fechainicial')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-label value="Fecha final" />
                <x-input type="date" wire:model.defer="fechafinal" class="w-full mt-1" />
                @error('fechafinal')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-1 flex items-end">
                <x-button wire:click="aceptar" class="w-full h-[42px] bg-vino-700 hover:bg-vino-800">Ok</x-button>
            </div>
        </div>
    </div>

    {{-- Grid principal: 2x2 de pies + tabla de técnicos a la derecha --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- Columna izquierda (las 4 pies en 2x2) --}}
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Redes y telecomunicaciones --}}
            <x-card>
                <div class="px-4 py-2 border-b">
                    <h3 class="font-semibold">Redes y telecomunicaciones</h3>
                </div>
                <div class="p-4">
                    @if ($aplicar && isset($areas['Redes y Telecomunicaciones']))
                        <livewire:stats.pie-por-area :area-id="$areas['Redes y Telecomunicaciones']" title="Redes y Telecomunicaciones"
                            :fechainicial="$fechainicial" :fechafinal="$fechafinal" :key="'pie-redes-' . $fechainicial . '-' . $fechafinal" />
                    @else
                        <div class="text-sm text-gray-500">Selecciona un rango y pulsa Ok.</div>
                    @endif
                </div>
            </x-card>

            {{-- Desarrollo de sistemas --}}
            <x-card>
                <div class="px-4 py-2 border-b">
                    <h3 class="font-semibold">Desarrollo de sistemas</h3>
                </div>
                <div class="p-4">
                    @if ($aplicar && isset($areas['Desarrollo de sistemas']))
                        <livewire:stats.pie-por-area :area-id="$areas['Desarrollo de sistemas']" title="Desarrollo de sistemas" :fechainicial="$fechainicial"
                            :fechafinal="$fechafinal" :key="'pie-dev-' . $fechainicial . '-' . $fechafinal" />
                    @else
                        <div class="text-sm text-gray-500">Selecciona un rango y pulsa Ok.</div>
                    @endif
                </div>
            </x-card>

            {{-- Diseño e identidad --}}
            <x-card>
                <div class="px-4 py-2 border-b">
                    <h3 class="font-semibold">Diseño e identidad</h3>
                </div>
                <div class="p-4">
                    @if ($aplicar && isset($areas['Diseño e Identidad']))
                        <livewire:stats.pie-por-area :area-id="$areas['Diseño e Identidad']" title="Diseño e Identidad" :fechainicial="$fechainicial"
                            :fechafinal="$fechafinal" :key="'pie-design-' . $fechainicial . '-' . $fechafinal" />
                    @else
                        <div class="text-sm text-gray-500">Selecciona un rango y pulsa Ok.</div>
                    @endif
                </div>
            </x-card>

            {{-- Operaciones y servicios --}}
            <x-card>
                <div class="px-4 py-2 border-b">
                    <h3 class="font-semibold">Operaciones y servicios</h3>
                </div>
                <div class="p-4">
                    @if ($aplicar && isset($areas['Operaciones y Servicios']))
                        <livewire:stats.pie-por-area :area-id="$areas['Operaciones y Servicios']" title="Operaciones y Servicios"
                            :fechainicial="$fechainicial" :fechafinal="$fechafinal" :key="'pie-ops-' . $fechainicial . '-' . $fechafinal" />
                    @else
                        <div class="text-sm text-gray-500">Selecciona un rango y pulsa Ok.</div>
                    @endif
                </div>
            </x-card>
        </div>

        {{-- Columna derecha: Tabla de técnicos --}}
        <x-card class="lg:row-span-2">
            <div class="px-4 py-2 border-b">
                <h3 class="font-semibold">Técnicos que atendieron servicio</h3>
            </div>
            <div class="p-4">
                @if ($aplicar)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="text-left px-3 py-2">Técnico</th>
                                    <th class="text-right px-3 py-2">Reportes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tecnicosResumen as $t)
                                    <tr class="border-b">
                                        <td class="px-3 py-2">{{ $t['name'] }}</td>
                                        <td class="px-3 py-2 text-right">
                                            <span @class([
                                                // base pill
                                                'inline-flex items-center justify-center rounded-full border px-2.5 py-0.5 text-xs font-semibold leading-5 min-w-[2.25rem]',
                                                // color según tenga o no reportes
                                                $t['total'] > 0
                                                    ? 'bg-vino-100 text-vino-800 border-vino-200'
                                                    : 'bg-gray-100 text-gray-700 border-gray-200',
                                            ])>
                                                {{ $t['total'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-3 py-6 text-center text-gray-500">Sin resultados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-sm text-gray-500">Selecciona un rango y pulsa Ok.</div>
                @endif
            </div>
        </x-card>
    </div>
</div>

{{-- Componente auxiliar de tarjeta (opcional) --}}
@once
    @push('components')
        @php
            // Si no usas un <x-card>, puedes pegar este blade simple en resources/views/components/card.blade.php
        @endphp
    @endpush
@endonce

<div class="max-w-7xl mx-auto px-4 space-y-6">
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="px-4 py-3 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Reportes Atendidos</h2>
        </div>

        <div class="p-4 grid grid-cols-1 sm:grid-cols-5 gap-2">
            {{-- <div class="p-4 flex flex-col sm:flex-row sm:items-end sm:space-x-2"> --}}
            {{-- Fecha inicial --}}
            <div>
                <x-label value="Fecha inicial" />
                <x-input type="date" wire:model.defer="fechainicial" class="w-full mt-1" />
                @error('fechainicial')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fecha final --}}
            <div>
                <x-label value="Fecha final" />
                <x-input type="date" wire:model.defer="fechafinal" class="w-full mt-1" />
                @error('fechafinal')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Técnico --}}
            <div>
                <x-label value="Técnico" />
                <select wire:model.live="tecnicoId" class="w-full mt-1 rounded-md border-gray-300 text-sm">
                    <option value="">Todos</option>
                    @foreach ($tecnicos as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
                @error('tecnicoId')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2 w-full">
                {{-- Botón Aceptar --}}
                <div class="flex items-end">
                    <x-button wire:click="aceptar"
                        class="flex items-center justify-center bg-vino-700 hover:bg-vino-800 w-full h-[42px]">
                        Filtrar
                    </x-button>
                </div>
    
                {{-- Exportar Excel --}}
                <div class="flex items-end">
                    <x-secondary-button wire:click="exportarExcel" class="flex items-center justify-center w-full h-[42px]"
                        :disabled="$reportes->isEmpty()">
                        <span class="mr-1 font-sans">XLS</span><i class="fa-solid fa-file-excel fa-xl text-green-600"></i>
                    </x-secondary-button>
                </div>
            </div>
        </div>

    </div>

    {{-- Grid de cards --}}
    <div class="bg-white shadow rounded-lg border border-gray-200 p-4">
        @if ($aplicar && $reportes instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="grid gap-4 sm:grid-cols-2 ">
                @forelse ($reportes as $r)
                    {{-- Reusar la card existente y ocultar acciones --}}
                    <livewire:reportes-item :reporte="$r" :mostrar-footer="false" :mostrar-estado="false" :key="'att-' . $r->id" />
                @empty
                    <div class="col-span-full text-center text-gray-500 py-6">
                        Sin resultados.
                    </div>
                @endforelse
            </div>

            <div class="px-4 py-3">
                {{ $reportes->links() }}
            </div>
        @else
            <div class="text-center text-gray-500 py-6">
                Selecciona un rango y pulsa <strong>Aceptar</strong>.
            </div>
        @endif
    </div>

</div>

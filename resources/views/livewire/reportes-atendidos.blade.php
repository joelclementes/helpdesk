<div class="max-w-7xl mx-auto px-4 space-y-6">
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="px-4 py-3 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Reportes Atendidos</h2>
        </div>

        <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
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

            {{-- Botón Aceptar --}}
            <div class="flex items-end">
                <x-button wire:click="aceptar"
                    class="flex items-center justify-center bg-vino-700 hover:bg-vino-800 w-full h-[42px]">
                    Aceptar
                </x-button>
            </div>

            {{-- Exportar Excel --}}
            <div class="flex items-end">
                <x-secondary-button wire:click="exportarExcel" class="flex items-center justify-center w-full h-[42px]"
                    :disabled="$reportes->isEmpty()">
                    <i class="fa-solid fa-file-excel fa-xl text-green-600"></i>
                </x-secondary-button>
            </div>
        </div>

        {{-- DataTable --}}

        <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto p-4" >
            <table id="tablaAtendidos" class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Departamento</th>
                        <th class="px-4 py-2 text-left">Área de informática</th>
                        <th class="px-4 py-2 text-left">Categoría</th>
                        <th class="px-4 py-2 text-left">Técnico(s)</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($reportes as $r)
                        <tr>
                            <td class="px-4 py-2 text-gray-800 text-xs font-medium">
                                {{ $r->created_at?->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 text-xs">
                                {{ $r->departamento->name ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 text-xs">
                                {{ $r->area->name ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 text-xs">
                                {{ $r->categoria->name ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-gray-700 text-xs">
                                {{ $r->tecnicos->pluck('name')->join(', ') ?: $r->tecnico->name ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        {{-- Si no hay filas, DataTables mostrará "No data available" --}}
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- <div class="bg-white shadow rounded-lg border border-gray-200 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Departamento</th>
                        <th class="px-4 py-2 text-left">Área de informática</th>
                        <th class="px-4 py-2 text-left">Categoría</th>
                        <th class="px-4 py-2 text-left">Técnico(s)</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($aplicar && $reportes instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        @forelse($reportes as $r)
                            <tr>
                                <td class="px-4 py-2 text-gray-800 text-xs font-medium">
                                    {{ $r->created_at?->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-2 text-gray-700 text-xs">
                                    {{ $r->departamento->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2 text-gray-700 text-xs">
                                    {{ $r->area->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2 text-gray-700 text-xs">
                                    {{ $r->categoria->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2 text-gray-700 text-xs">
                                    {{ $r->tecnicos->pluck('name')->join(', ') ?: $r->tecnico->name ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    Sin resultados.
                                </td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                Selecciona un rango y pulsa <strong>Aceptar</strong>.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{-- Paginación --}}
        {{--
            @if ($aplicar && $reportes instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="px-4 py-3">
                    {{ $reportes->links() }}
                </div>
            @endif
        </div> --}}
    </div>

</div>

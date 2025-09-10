<div class="max-w-7xl mx-auto px-4 space-y-6">
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="px-4 py-3 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Reportes Atendidos</h2>
        </div>

        <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Fecha inicial --}}
            <div>
                <x-label value="Fecha inicial" />
                <x-input type="date" wire:model.defer="fechainicial" class="w-full mt-1" />
                @error('fechainicial') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Fecha final --}}
            <div>
                <x-label value="Fecha final" />
                <x-input type="date" wire:model.defer="fechafinal" class="w-full mt-1" />
                @error('fechafinal') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Botón --}}
            <div class="flex items-end">
                <x-button wire:click="cargar" class="w-full bg-vino-700 hover:bg-vino-800">
                    Aceptar
                </x-button>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="bg-white shadow rounded-lg border border-gray-200 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">Fecha</th>
                    <th class="px-4 py-2 text-left">Departamento</th>
                    <th class="px-4 py-2 text-left">Área de informática</th>
                    <th class="px-4 py-2 text-left">Categoría</th>
                    <th class="px-4 py-2 text-left">Técnico</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($reportes as $r)
                    <tr>
                        <td class="px-4 py-2 text-gray-800">
                            {{ $r->created_at?->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2 text-gray-700">
                            {{ $r->departamento->name ?? '—' }}
                        </td>
                        <td class="px-4 py-2 text-gray-700">
                            {{ $r->areaInformatica->name ?? '—' }}
                        </td>
                        <td class="px-4 py-2 text-gray-700">
                            {{ $r->categoria->name ?? '—' }}
                        </td>
                        <td class="px-4 py-2 text-gray-700">
                            {{ $r->tecnico->name ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Sin resultados. Selecciona un rango y pulsa <strong>Aceptar</strong>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

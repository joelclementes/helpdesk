<div class="max-w-2xl mx-auto px-4 space-y-6">

    {{-- Feedback --}}
    @if (session('ok'))
        <div class="p-3 bg-green-50 text-green-700 rounded border border-green-200 text-sm">
            {{ session('ok') }}
        </div>
    @endif

    {{-- Card superior: botón para abrir modal --}}
    <div class="bg-white shadow rounded-lg overflow-hidden border border-vino-400">
        <div class="px-4 py-3 bg-gray-100 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 text-sm">Reportes</h3>
            <x-button wire:click="abrirModalCrear" class="bg-gray-600 hover:bg-gray-800">
                Nuevo reporte
            </x-button>
        </div>

        {{-- (opcional) filtros o resumen --}}
        <div class="px-4 py-4 text-sm text-gray-600">
            Crea un nuevo reporte.
        </div>
    </div>

    {{-- Listado de cards existentes --}}
    @foreach ($reportes as $reporte)
        <livewire:reportes-item :reporte="$reporte" :key="'reportes-item-' . $reporte->id" />
    @endforeach

    <div>
        {{ $reportes->links() }}
    </div>

    {{-- MODAL: Crear reporte --}}
    <x-dialog-modal wire:model="showCreateModal" wire:key="create-reporte-modal" wire:ignore.self>
        <x-slot name="title">
            Nuevo Reporte
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                {{-- Areas del Congreso --}}
                <div>
                    <x-label value="Área del Congreso" />
                    <select wire:model.defer="nuevoReporte.departamento_id"
                        class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm">
                        <option value="">Selecciona un área</option>
                        @foreach ($departamentos as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="nuevoReporte.departamento_id" class="mt-1" />
                </div>

                {{-- Solicitante --}}
                <div>
                    <x-label value="Solicitante" />
                    <x-input type="text" wire:model.defer="nuevoReporte.solicitante"
                        class="border-vino-300 w-full mt-1" placeholder="Nombre del solicitante" />
                    <x-input-error for="nuevoReporte.solicitante" class="mt-1" />
                </div>

                {{-- Descripción --}}
                <div>
                    <x-label value="Descripción" />
                    <textarea wire:model.defer="nuevoReporte.descripcion"
                        class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm" rows="4"
                        placeholder="Describe la solicitud..."></textarea>
                    <x-input-error for="nuevoReporte.descripcion" class="mt-1" />
                </div>

                {{-- Área de Informática --}}
                <div>
                    <x-label value="Área de Informática" />
                    <select wire:model.defer="nuevoReporte.area_informatica_id"
                        class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm">
                        <option value="">Selecciona un área</option>
                        @foreach ($areasInformatica as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="nuevoReporte.area_informatica_id" class="mt-1" />
                </div>

                {{-- Categoría --}}
                <div>
                    <x-label value="Categoría" />
                    <select wire:model.defer="nuevoReporte.categoria_id"
                        class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="nuevoReporte.categoria_id" class="mt-1" />
                </div>

                {{-- Técnico asignado --}}
                <div>
                    <x-label value="Técnico asignado" />
                    <select wire:model.defer="nuevoReporte.tecnico_id"
                        class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm">
                        <option value="">Selecciona un técnico</option>
                        @foreach ($tecnicos as $tec)
                            <option value="{{ $tec->id }}">{{ $tec->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="nuevoReporte.tecnico_id" class="mt-1" />
                </div>

                {{-- Número de copias/en su caso --}}
                <div>
                    <x-label value="Número de copias/en su caso" />
                    <x-input type="number" wire:model.defer="nuevoReporte.numero_copias"
                        class="border-vino-300 w-full mt-1" placeholder="Número de copias" />
                    <x-input-error for="nuevoReporte.numero_copias" class="mt-1" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cerrarModalCrear" class="me-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="guardarNuevoReporte" class="bg-vino-700 hover:bg-vino-800">
                Guardar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>

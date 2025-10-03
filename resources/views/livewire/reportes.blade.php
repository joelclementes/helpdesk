<div class="max-w-2xl mx-auto px-4 space-y-6">

    {{-- Feedback --}}
    @if (session('ok'))
        <div class="p-3 bg-green-50 text-green-700 rounded border border-green-200 text-sm">
            {{ session('ok') }}
        </div>
    @endif

    {{-- Card superior: botón para abrir modal --}}
    @can('NuevoReporte')
    <div class="bg-white shadow rounded-lg overflow-hidden border border-vino-400">
        <div class="px-4 py-3 bg-gray-100 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 text-sm">Reportes:</h3>
            <x-button wire:click="abrirModalCrear" class="bg-gray-600 hover:bg-gray-800">
                Nuevo reporte
            </x-button>
        </div>

        {{-- (opcional) filtros o resumen --}}
        <div class="px-4 py-4 text-sm text-gray-600">
            {{-- Totales --}}
            <div class="flex gap-4 items-center mb-1">
                <div>
                    <span class="mr-2 font-bold">Totales </span>Pendientes:
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ $totalPendientes }}
                    </span>
                </div>
                <div>
                    Atendidos (Pendientes de cerrar):
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ $totalAtendidos }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endcan

    {{-- Filtros --}}

    {{-- Listado de cards existentes --}}
<div class="space-y-3">
    @forelse ($reportes as $reporte)
        <livewire:reportes-item :reporte="$reporte" :key="'reportes-item-' . $reporte->id" />
    @empty
        {{-- Card: no hay reportes --}}
        <div class="bg-white shadow rounded-lg border border-gray-200 p-8 text-center">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                {{-- Si tienes heroicons --}}
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20 13V7a2 2 0 00-2-2h-3l-1-1h-4l-1 1H5a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4" />
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">No hay reportes para mostrar</h3>
            <p class="mt-1 text-sm text-gray-500">Cuando se capture el primero aparecerá aquí.</p>

            @can('NuevoReporte')
                <x-button wire:click="abrirModalCrear" class="mt-4 bg-vino-700 hover:bg-vino-800">
                    Crear primer reporte
                </x-button>
            @endcan
        </div>
    @endforelse
</div>

{{-- Paginación (solo si hay páginas) --}}
@if (method_exists($reportes, 'hasPages') && $reportes->hasPages())
    <div>
        {{ $reportes->links() }}
    </div>
@endif

    {{-- <div class="space-y-3">
        @foreach ($reportes as $reporte)
            <livewire:reportes-item :reporte="$reporte" :key="'reportes-item-' . $reporte->id" />
        @endforeach
    </div>

    <div>
        {{ $reportes->links() }}
    </div> --}}

    {{-- MODAL: Crear reporte --}}
    <x-dialog-modal wire:model="showCreateModal" wire:key="create-reporte-modal" maxWidth="2xl">
        <x-slot name="title">
            Nuevo Reporte
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Columna 1 --}}
                <div class="space-y-4">
                    {{-- Área del Congreso --}}
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

                    {{-- Evento (opcional) --}}
                    <div>
                        <x-label value="Evento (opcional)" />
                        <select wire:model.defer="nuevoReporte.evento_id"
                            class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm">
                            <option value="">Sin evento</option>
                            @foreach ($eventos as $ev)
                                <option value="{{ $ev->id }}">{{ $ev->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="nuevoReporte.evento_id" class="mt-1" />
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <x-label value="Descripción" />
                        <textarea wire:model.defer="nuevoReporte.descripcion"
                            class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm" rows="6"
                            placeholder="Describe la solicitud..."></textarea>
                        <x-input-error for="nuevoReporte.descripcion" class="mt-1" />
                    </div>
                </div>

                {{-- Columna 2 --}}
                <div class="space-y-4">
                    {{-- Área de Informática --}}
                    <div>
                        <x-label value="Área de Informática" />
                        <select wire:model.live="nuevoReporte.area_informatica_id"
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
                        <select wire:model="nuevoReporte.categoria_id"
                            class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm"
                            @disabled(!filled($nuevoReporte['area_informatica_id']))
                            >
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categoriasFiltradas as $cat)
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

                    {{-- Número de inventario/en su caso --}}
                    <div>
                        <x-label value="Número de inventario/en su caso" />
                        <x-input type="text" wire:model.defer="nuevoReporte.numero_inventario"
                            class="border-vino-300 w-full mt-1" placeholder="Número de inventario" />
                        <x-input-error for="nuevoReporte.numero_inventario" class="mt-1" />
                    </div>
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


    {{-- MODAL: Comentar --}}
    <x-dialog-modal wire:model="showComentarioModal" wire:key="comentario-modal" wire:ignore.self>
        <x-slot name="title">
            Agregar comentario
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                @if ($comentarioReporteId)
                    <p class="text-xs text-gray-500">
                        Reporte #{{ $comentarioReporteId }}
                    </p>
                @endif

                <div>
                    <x-label value="Comentario" />
                    <textarea wire:model.defer="comentarioTexto" rows="4"
                        class="w-full mt-1 rounded-md border-gray-300 focus:border-vino-500 focus:ring-vino-500 text-sm"
                        placeholder="Escribe tu comentario..."></textarea>
                    <x-input-error for="comentarioTexto" class="mt-1" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cerrarModalComentario" class="me-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="guardarComentario" class="bg-vino-700 hover:bg-vino-800">
                Publicar
            </x-button>
        </x-slot>
    </x-dialog-modal>


    {{-- MODAL: Atendido --}}
    <x-dialog-modal wire:model="showAtendidoModal" wire:key="atendido-modal" wire:ignore.self>
        <x-slot name="title">
            Marcar reporte como Atendido
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-600">
                    Reasigna categoría y/o técnicos para el reporte.
                </p>

                {{-- Categoría --}}
                <div>
                    <x-label value="Reasignar categoría" />
                    <select wire:model.defer="atendidoCategoriaId"
                        class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($todasCategorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="atendidoCategoriaId" class="mt-1" />
                </div>

                {{-- Técnicos (checklist múltiple) --}}
                <div>
                    <x-label value="Técnicos asignados (puede seleccionar varios)" />
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach ($tecnicos as $tec)
                            <label
                                class="flex items-center gap-2 px-3 py-2 rounded-md border border-vino-200 hover:bg-vino-50">
                                <input type="checkbox" value="{{ $tec->id }}"
                                    wire:model.defer="atendidoTecnicoIds"
                                    class="rounded border-vino-300 text-vino-600 focus:ring-vino-500">
                                <span class="text-sm text-gray-800">{{ $tec->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error for="atendidoTecnicoIds" class="mt-1" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cerrarModalAtendido" class="me-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="guardarAtendido" class="bg-vino-700 hover:bg-vino-800">
                Guardar
            </x-button>
        </x-slot>
    </x-dialog-modal>



    {{-- MODAL: Confirmar cierre --}}
    <x-dialog-modal wire:model="showCerrarModal" wire:key="cerrar-modal" wire:ignore.self>
        <x-slot name="title">
            Confirmar cierre
        </x-slot>

        <x-slot name="content">
            <p class="text-sm text-gray-700">
                ¿Seguro que deseas <strong>cerrar</strong> este reporte?
            </p>
            @if ($cerrarReporteId)
                <p class="text-xs text-gray-500 mt-2">
                    ID del reporte: #{{ $cerrarReporteId }}
                </p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cerrarModalCerrar" class="me-2">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="confirmarCierre" class="bg-vino-700 hover:bg-vino-800">
                Sí, cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- MODAL: Confirmar cancelación --}}
    <x-dialog-modal wire:model="showCancelarModal" wire:key="cancelar-modal" wire:ignore.self>
        <x-slot name="title">
            Confirmar cancelación
        </x-slot>

        <x-slot name="content">
            <p class="text-sm text-gray-700">
                ¿Seguro que deseas <strong>cancelar</strong> este reporte?
            </p>
            @if ($cancelarReporteId)
                <p class="text-xs text-gray-500 mt-2">
                    ID del reporte: #{{ $cancelarReporteId }}
                </p>
            @endif
            {{-- Campo para comentario --}}
            <div class="mt-4">
                <x-label for="cancelarComentario" value="Motivo de la cancelación" />
                <textarea id="cancelarComentario" wire:model.defer="cancelarComentario"
                    class="w-full mt-1 rounded-md border-vino-300 focus:border-vino-500 focus:ring-vino-500 text-sm" rows="3"
                    placeholder="Escribe el motivo de la cancelación..."></textarea>
                <x-input-error for="cancelarComentario" class="mt-1" />
            </div>
        </x-slot>


        <x-slot name="footer">
            <x-secondary-button wire:click="cerrarModalCancelar" class="me-2">
                No, regresar
            </x-secondary-button>

            <x-button wire:click="confirmarCancelar" class="bg-vino-700 hover:bg-vino-800">
                Sí, cancelar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>

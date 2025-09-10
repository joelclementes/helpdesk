<div class="max-w-4xl mx-auto px-4 space-y-6">

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
    <x-dialog-modal wire:model="showCreateModal" wire:key="create-reporte-modal" wire:ignore.self maxWidth="2xl">
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
                        @foreach ($categorias as $cat)
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

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Reporte, Comentario, DepartamentoCongreso, AreasInformatica, Categoria, User, Evento};
use Illuminate\Support\Facades\DB;

use Livewire\Attributes\On;

class Reportes extends Component
{

    use WithPagination;

    // Modal
    public bool $showCreateModal = false;

    public int $totalPendientes = 0;
    public int $totalAtendidos = 0;

    // Modal Atendido
    public ?int $atendidoReporteId = null;
    public ?int $atendidoCategoriaId = null;

    public bool $showAtendidoModal = false;
    public ?int $atendidoTecnicoId = null;

    public array $atendidoTecnicoIds = [];

    // --- estado del modal Cerrar ---
    public bool $showCerrarModal = false;
    public ?int $cerrarReporteId = null;

    // 🆕 Modal comentar
    public bool $showComentarioModal = false;
    public ?int $comentarioReporteId = null;
    public string $comentarioTexto = '';

    // Modal Cancelar
    public bool $showCancelarModal = false;
    public ?int $cancelarReporteId = null;
    public string $cancelarComentario = '';

    // Formulario
    public array $nuevoReporte = [
        'departamento_id'   => '',
        'solicitante'   => '',
        'descripcion'   => '',
        'area_informatica_id' => '',
        'categoria_id'  => '',
        'tecnico_id'    => '',
        'numero_copias'  => '',
        'evento_id'  => '',
    ];

    public function rules()
    {
        return [
            'nuevoReporte.departamento_id'      => 'required|exists:departamento_congreso,id',
            'nuevoReporte.solicitante'          => 'required|string|max:255',
            'nuevoReporte.descripcion'          => 'required|string|min:3',
            'nuevoReporte.area_informatica_id'  => 'required|exists:area_informatica,id',
            'nuevoReporte.categoria_id'         => 'required|exists:categorias,id',
            'nuevoReporte.tecnico_id'           => 'required|exists:users,id',
            'nuevoReporte.numero_copias'        => 'nullable|integer|min:1',
            'nuevoReporte.evento_id'            => 'nullable|exists:eventos,id',
        ];
    }


    protected $listeners = ['abrirModalAtendido', 'cerrarModalAtendido', 'guardarAtendido', 'abrirModalComentario', 'refrescarComentarios', 'abrirModalCerrar', 'abrirModalCancelar'];

    public function abrirModalAtendido(int $id)
    {
        // $reporte = Reporte::findOrFail($id);
        $reporte = Reporte::with('tecnicos')->findOrFail($id);

        $this->atendidoReporteId   = $id;
        $this->atendidoCategoriaId = $reporte->categoria_id;     // preselecciona la actual
        $this->atendidoTecnicoId   = $reporte->tecnico_user_id;  // preselecciona el actual

        $this->atendidoTecnicoIds = $reporte->tecnicos->pluck('id')->toArray();

        $this->resetValidation();
        $this->showAtendidoModal = true;
    }

    public function cerrarModalAtendido()
    {
        $this->showAtendidoModal = false;
        $this->atendidoReporteId = null;
        $this->atendidoCategoriaId = null;
        $this->atendidoTecnicoId = null;
    }

    public function guardarAtendido()
    {

        $this->validate([
            'atendidoCategoriaId' => 'required|exists:categorias,id',
            'atendidoTecnicoIds'  => 'required|array|min:1',
            'atendidoTecnicoIds.*' => 'exists:users,id',
        ], [
            'atendidoTecnicoIds.required'  => 'Debes seleccionar al menos un técnico.',
            'atendidoTecnicoIds.min'       => 'Debes seleccionar al menos un técnico.',
            'atendidoTecnicoIds.*.exists'  => 'Uno de los técnicos seleccionados no es válido.',
        ]);

        $reporte = Reporte::findOrFail($this->atendidoReporteId);

        // Estado + categoría
        $reporte->estado_id    = 2; // Atendido
        $reporte->categoria_id = $this->atendidoCategoriaId;

        // (opcional) setear técnico principal al primero del checklist, si hay alguno
        $reporte->tecnico_user_id = !empty($this->atendidoTecnicoIds)
            ? $this->atendidoTecnicoIds[0]
            : $reporte->tecnico_user_id; // o null si quieres limpiarlo

        $reporte->save();

        // Sincronizar pivote con los técnicos seleccionados
        $reporte->tecnicos()->sync($this->atendidoTecnicoIds ?? []);

        // refrescar la card del hijo
        $this->dispatch('refrescarComentarios', id: $reporte->id);

        $this->cerrarModalAtendido();
        session()->flash('ok', 'Reporte marcado como Atendido. Categoría y técnicos actualizados.');
    }

    public function abrirModalCrear()
    {
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function cerrarModalCrear()
    {
        $this->showCreateModal = false;
    }

    public function guardarNuevoReporte()
    {

        $this->validate();

        DB::transaction(function () {
            // 1) Crear el reporte
            $reporte = Reporte::create([
                'departamento_congreso_id' => $this->nuevoReporte['departamento_id'],
                'solicitante'              => $this->nuevoReporte['solicitante'],
                'descripcion'              => $this->nuevoReporte['descripcion'],
                'area_informatica_id'      => $this->nuevoReporte['area_informatica_id'],
                'categoria_id'             => $this->nuevoReporte['categoria_id'],
                'tecnico_user_id'          => $this->nuevoReporte['tecnico_id'] ?: null, // principal
                'capturo_user_id'          => auth()->id(),
                'estado_id'                => 1,
                'numero_copias'            => $this->nuevoReporte['numero_copias'] ?: null,
                'evento_id'                => $this->nuevoReporte['evento_id'] ?: null,
            ]);

            // 2) Guardar también en la pivote (si viene técnico)
            if (!empty($this->nuevoReporte['tecnico_id'])) {
                // evita duplicados si existe unique(reporte_id,user_id)
                $reporte->tecnicos()->syncWithoutDetaching([
                    $this->nuevoReporte['tecnico_id'],
                ]);
            }

            // (Opcional) si capturas múltiples técnicos en el form:
            // $reporte->tecnicos()->sync($this->nuevoReporte['tecnico_ids'] ?? []);
        });

        $this->reset('nuevoReporte');
        $this->cerrarModalCrear();
        session()->flash('ok', 'Reporte creado con éxito.');
        $this->resetPage();
    }


    public function abrirModalComentario(int $id)
    {
        $this->comentarioReporteId = $id;
        $this->comentarioTexto = '';
        $this->resetValidation();
        $this->showComentarioModal = true;
    }

    public function cerrarModalComentario()
    {
        $this->showComentarioModal = false;
        $this->comentarioReporteId = null;
        $this->comentarioTexto = '';
    }

    public function guardarComentario()
    {
        $this->validate([
            'comentarioTexto' => 'required|string|min:2|max:2000',
            'comentarioReporteId' => 'required|exists:reportes,id',
        ], [
            'comentarioTexto.required' => 'Escribe tu comentario.',
            'comentarioTexto.min'      => 'El comentario es muy corto.',
        ]);

        Comentario::create([
            'reporte_id' => $this->comentarioReporteId,
            'user_id'    => auth()->id(),
            'comentario' => $this->comentarioTexto,
        ]);

        // Notificar al hijo para refrescar su lista de comentarios
        $this->dispatch('refrescarComentarios', id: $this->comentarioReporteId);

        $this->cerrarModalComentario();
        session()->flash('ok', 'Comentario agregado.');
    }

    public function abrirModalCerrar(int $id)
    {
        $this->cerrarReporteId = $id;
        $this->showCerrarModal = true;
    }

    public function cerrarModalCerrar()
    {
        $this->showCerrarModal = false;
        $this->cerrarReporteId = null;
    }

    public function confirmarCierre()
    {
        $reporte = Reporte::findOrFail($this->cerrarReporteId);

        // si ya está cerrado, no hagas doble cierre
        if ($reporte->estado_id !== 3) {
            $reporte->estado_id = 3;         // Cerrado
            $reporte->closed_at = now();
            $reporte->save();
        }

        // refresca la card que corresponde
        $this->dispatch('refrescarComentarios', id: $reporte->id);

        $this->cerrarModalCerrar();
        session()->flash('ok', 'Reporte cerrado correctamente.');
    }


    public function abrirModalCancelar(int $id)
    {
        $this->cancelarReporteId = $id;
        $this->showCancelarModal = true;
    }

    public function cerrarModalCancelar()
    {
        $this->showCancelarModal = false;
        $this->cancelarReporteId = null;
    }

    public function confirmarCancelar()
    {
        $reporte = Reporte::findOrFail($this->cancelarReporteId);

        if ($reporte->estado_id !== 4) { // 4 = Cancelado
            $reporte->estado_id = 4;
            $reporte->save();
        }

        // Guardar comentario ligado al reporte
        Comentario::create([
            'reporte_id' => $reporte->id,
            'user_id'    => auth()->id(),
            'comentario' => '[Cancelación] ' . $this->cancelarComentario,
        ]);

        // refrescar la card del hijo
        $this->dispatch('refrescarComentarios', id: $reporte->id);

        $this->cerrarModalCancelar();
        session()->flash('ok', 'Reporte cancelado correctamente.');
    }

    public function render()
    {
        $departamentos = DepartamentoCongreso::orderBy('name')->get();
        $areasInformatica = AreasInformatica::orderBy('name')->get();
        $categorias = Categoria::orderBy('name')->get();
        $tecnicos = User::orderBy('name')->get();
        $eventos = Evento::orderBy('date', 'desc')->activos()->get();


        // El scope `abiertos` se utiliza para filtrar los reportes que no están cerrados ni cancelados.
        // está establecido en el modelo Reporte.php
        $reportes = Reporte::with(['categoria', 'tecnico', 'estado', 'comentarios.user'])
            ->abiertos()
            ->latest()
            ->paginate(5);

        $this->totalPendientes = Reporte::whereHas('estado', fn($q) => $q->where('name', 'Pendiente'))->count();
        $this->totalAtendidos  = Reporte::whereHas('estado', fn($q) => $q->where('name', 'Atendido'))->count();

        return view('livewire.reportes', compact('reportes', 'departamentos', 'areasInformatica', 'categorias', 'tecnicos', 'eventos'));
    }

    public function messages()
    {
        return [
            'nuevoReporte.departamento_id.required'      => 'El área del Congreso es obligatoria.',
            'nuevoReporte.departamento_id.exists'        => 'El área seleccionada no es válida.',

            'nuevoReporte.solicitante.required'          => 'El campo solicitante es obligatorio.',
            'nuevoReporte.solicitante.max'               => 'El solicitante no puede tener más de 255 caracteres.',

            'nuevoReporte.descripcion.required'          => 'La descripción es obligatoria.',
            'nuevoReporte.descripcion.min'               => 'La descripción debe tener al menos 3 caracteres.',

            'nuevoReporte.area_informatica_id.required'  => 'El área de informática es obligatoria.',
            'nuevoReporte.area_informatica_id.exists'    => 'El área de informática seleccionada no es válida.',

            'nuevoReporte.categoria_id.required'         => 'La categoría es obligatoria.',
            'nuevoReporte.categoria_id.exists'           => 'La categoría seleccionada no es válida.',

            'nuevoReporte.tecnico_id.required'           => 'El técnico es obligatorio.',
            'nuevoReporte.tecnico_id.exists'             => 'El técnico seleccionado no es válido.',

            'nuevoReporte.numero_copias.integer'         => 'El número de copias debe ser un número entero.',
            'nuevoReporte.numero_copias.min'             => 'El número de copias debe ser al menos 1.',
        ];
    }
}

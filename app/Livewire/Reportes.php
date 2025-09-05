<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Reporte, Comentario, DepartamentoCongreso, AreasInformatica, Categoria, User, Evento};

use Livewire\Attributes\On;

class Reportes extends Component
{

    use WithPagination;

    // Modal
    public bool $showCreateModal = false;



    // Modal Atendido
    public bool $showAtendidoModal = false;
    public ?int $atendidoReporteId = null;
    public ?int $atendidoCategoriaId = null;
    public ?int $atendidoTecnicoId = null;

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
        $reporte = Reporte::findOrFail($id);
        $reporte = Reporte::findOrFail($id);

        $this->atendidoReporteId   = $id;
        $this->atendidoCategoriaId = $reporte->categoria_id;     // preselecciona la actual
        $this->atendidoTecnicoId   = $reporte->tecnico_user_id;  // preselecciona el actual

        $this->resetValidation();
        $this->showAtendidoModal = true;


        // $this->atendidoReporteId = $id;

        // // carga la categoría actual del reporte
        // $this->atendidoCategoriaId = Reporte::find($id)?->categoria_id;

        // $this->resetValidation();
        // $this->showAtendidoModal = true;
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
            'atendidoTecnicoId'   => 'required|exists:users,id',
        ], [
            'atendidoCategoriaId.required' => 'Debes seleccionar una categoría.',
            'atendidoCategoriaId.exists'   => 'La categoría seleccionada no es válida.',
            'atendidoTecnicoId.required'   => 'Debes seleccionar un técnico.',
            'atendidoTecnicoId.exists'     => 'El técnico seleccionado no es válido.',
        ]);

        $reporte = Reporte::findOrFail($this->atendidoReporteId);

        $reporte->estado_id       = 2; // Atendido
        $reporte->categoria_id    = $this->atendidoCategoriaId;
        $reporte->tecnico_user_id = $this->atendidoTecnicoId;
        $reporte->save();

        // refrescar la card del hijo
        $this->dispatch('refrescarComentarios', id: $reporte->id);

        $this->cerrarModalAtendido();
        session()->flash('ok', 'Reporte marcado como Atendido. Categoría y técnico actualizados.');
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

        // dd($this->nuevoReporte);

        Reporte::create([
            'departamento_congreso_id' => $this->nuevoReporte['departamento_id'],
            'solicitante'              => $this->nuevoReporte['solicitante'],
            'descripcion'              => $this->nuevoReporte['descripcion'],
            'area_informatica_id'      => $this->nuevoReporte['area_informatica_id'],
            'categoria_id'             => $this->nuevoReporte['categoria_id'],
            'tecnico_user_id'          => $this->nuevoReporte['tecnico_id'] ?: null,
            'capturo_user_id'          => auth()->id(),
            'estado_id'                => 1,
            'numero_copias'            => $this->nuevoReporte['numero_copias'] ?: null,
            'evento_id'                => $this->nuevoReporte['evento_id'] ?: null,
        ]);

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
        $eventos = Evento::orderBy('fecha', 'desc')->activos()->get();


        // El scope `abiertos` se utiliza para filtrar los reportes que no están cerrados ni cancelados.
        // está establecido en el modelo Reporte.php
        $reportes = Reporte::with(['categoria', 'tecnico', 'estado', 'comentarios.user'])
            ->abiertos()
            ->latest()
            ->paginate(5);


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

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Reporte, DepartamentoCongreso, AreasInformatica, Categoria, User};


class Reportes extends Component
{

    use WithPagination;

    // Modal
    public bool $showCreateModal = false;

    // Formulario
    public array $nuevoReporte = [
        'departamento_id'   => '',
        'solicitante'   => '',
        'descripcion'   => '',
        'area_informatica_id' => '',
        'categoria_id'  => '',
        'tecnico_id'    => '',
        'numero_copias'  => '',
    ];

    public function rules()
    {
        return [
            'nuevoReporte.departamento_id'      => 'required|exists:departamento_congreso,id',
            'nuevoReporte.solicitante'          => 'required|string|max:255',
            'nuevoReporte.descripcion'          => 'required|string|min:3',
            'nuevoReporte.area_informatica_id'  => 'required|exists:area_informatica,id',
            'nuevoReporte.categoria_id'         => 'required|exists:categorias,id',
            'nuevoReporte.tecnico_id'           => 'nullable|exists:users,id',
            'nuevoReporte.numero_copias'        => 'nullable|integer|min:1',
        ];
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
        ]);

        $this->reset('nuevoReporte');
        $this->cerrarModalCrear();
        session()->flash('ok', 'Reporte creado con éxito.');
        $this->resetPage();
    }

    public function render()
    {
        $departamentos = DepartamentoCongreso::orderBy('name')->get();
        $areasInformatica = AreasInformatica::orderBy('name')->get();
        $categorias = Categoria::orderBy('name')->get();
        $tecnicos = User::orderBy('name')->get();

        $reportes = Reporte::with(['categoria', 'tecnico', 'comentarios.user'])
            ->latest()
            ->paginate(10);

        return view('livewire.reportes', compact('reportes', 'departamentos', 'areasInformatica', 'categorias', 'tecnicos'));
    }
}

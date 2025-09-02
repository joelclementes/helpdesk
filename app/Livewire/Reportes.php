<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Reporte,DepartamentoCongreso,AreasInformatica,Categoria,User};


class Reportes extends Component
{

    use WithPagination;

    // Modal
    public bool $showCreateModal = false;

    // Formulario
    public array $nuevoReporte = [
        'solicitante'   => '',
        'descripcion'   => '',
        'categoria_id'  => '',
        // agrega otros campos si los necesitas
    ];

    public function rules()
    {
        return [
            'nuevoReporte.solicitante'  => 'required|string|max:255',
            'nuevoReporte.descripcion'  => 'required|string|min:3',
            'nuevoReporte.categoria_id' => 'required|exists:categorias,id',
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

        Reporte::create([
            'solicitante'     => $this->nuevoReporte['solicitante'],
            'descripcion'     => $this->nuevoReporte['descripcion'],
            'categoria_id'    => $this->nuevoReporte['categoria_id'],
            'capturo_user_id' => auth()->id(),
            'estado_id'       => 1, // ajusta al estado inicial que uses
        ]);

        $this->reset('nuevoReporte');
        $this->cerrarModalCrear();
        session()->flash('ok', 'Reporte creado con éxito.');
        $this->resetPage(); // vuelve a la primera página para ver el nuevo
    }

    public function render()
    {
        $departamentos = DepartamentoCongreso::orderBy('name')->get();
        $areasInformatica = AreasInformatica::orderBy('name')->get();
        $categorias = Categoria::orderBy('name')->get();
        $tecnicos = User::orderBy('name')->get();

        $reportes = Reporte::with(['categoria','tecnico','comentarios.user'])
            ->latest()
            ->paginate(10);

        return view('livewire.reportes', compact('reportes','departamentos','areasInformatica','categorias','tecnicos'));
    }


    // use WithPagination;

    // public $reportes;

    // public $nuevoReporte = [
    //     'solicitante' => '',
    //     'descripcion' => '',
    //     'categoria_id' => '',
    // ];

    // public function mount()
    // {
    //     $this->reportes = Reporte::all();
    // }

    // public function render()
    // {
    //     $reportes = Reporte::with(['categoria', 'tecnico', 'comentarios.user'])
    //         ->latest()
    //         ->paginate(10);
    //         $categorias = Categoria::all();
    //     return view('livewire.reportes', compact('reportes','categorias'));
    // }

    // public function guardarNuevoReporte(){
    //     $this->validate([
    //         'nuevoReporte.solicitante' => 'required|string|max:255',
    //         'nuevoReporte.descripcion' => 'required|string',
    //         'nuevoReporte.categoria_id' => 'required|exists:categorias,id',
    //     ]);

    //     Reporte::create([
    //         'solicitante' => $this->nuevoReporte['solicitante'],
    //         'descripcion' => $this->nuevoReporte['descripcion'],
    //         'categoria_id' => $this->nuevoReporte['categoria_id'],
    //         'estado_id' => 1, // Estado "Abierto"
    //     ]);

    //     $this->reset('nuevoReporte');
    //     session()->flash('mensaje', 'Reporte creado exitosamente.');
    // }


}

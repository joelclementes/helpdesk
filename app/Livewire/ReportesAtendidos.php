<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class ReportesAtendidos extends Component
{
    public ?string $fechainicial = null;
    public ?string $fechafinal   = null;

    /** @var \Illuminate\Support\Collection */
    public $reportes;

    public function mount()
    {
        $this->reportes = collect();
    }

    public function rules()
    {
        return [
            'fechainicial' => 'nullable|date',
            'fechafinal'   => 'nullable|date|after_or_equal:fechainicial',
        ];
    }

    public function cargar()
    {
        $this->validate();

        $this->reportes = Reporte::with([
                'estado',
                'categoria',
                'tecnico',                  // técnico principal
                'departamento',             // belongsTo DepartamentoCongreso por departamento_congreso_id
                'areaInformatica',          // belongsTo AreasInformatica por area_informatica_id
            ])
            ->whereHas('estado', fn ($q) => $q->where('name', 'Atendido'))
            ->when($this->fechainicial, fn ($q) => $q->whereDate('created_at', '>=', $this->fechainicial))
            ->when($this->fechafinal,   fn ($q) => $q->whereDate('created_at', '<=', $this->fechafinal))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.reportes-atendidos');
    }
}

<?php

namespace App\Livewire\Stats;

use Livewire\Component;
use App\Models\Reporte;
use Illuminate\Support\Facades\DB;

class PiePorArea extends Component
{
    public int $areaId;
    public string $title = '';
    public ?string $fechainicial = null;
    public ?string $fechafinal   = null;

    public array $labels = [];
    public array $values = [];

    public string $chartId;


    public function mount(): void
    {
        // id único y estable por instancia
        $this->chartId = 'pie-' . uniqid();
    }

    public function loadData(): void
    {
        $rows = Reporte::query()
            ->join('categorias', 'categorias.id', '=', 'reportes.categoria_id')
            ->where('reportes.area_informatica_id', $this->areaId)
            ->when($this->fechainicial, fn($q) => $q->whereDate('reportes.created_at', '>=', $this->fechainicial))
            ->when($this->fechafinal,   fn($q) => $q->whereDate('reportes.created_at', '<=', $this->fechafinal))
            ->groupBy('categorias.name')
            ->orderBy('categorias.name')
            ->select('categorias.name as categoria', DB::raw('COUNT(reportes.id) as total'))
            ->get();

        $this->labels = $rows->pluck('categoria')->toArray();
        $this->values = $rows->pluck('total')->toArray();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.stats.pie-por-area');
    }
}

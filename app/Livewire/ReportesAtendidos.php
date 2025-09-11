<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reporte;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportesAtendidosExport;
use Carbon\Carbon;

class ReportesAtendidos extends Component
{
    use WithPagination;

    public ?string $fechainicial = null;
    public ?string $fechafinal   = null;
    public bool $aplicar = false; // solo carga al pulsar Aceptar

    protected $queryString = [
        'fechainicial' => ['except' => ''],
        'fechafinal'   => ['except' => ''],
        'aplicar'      => ['except' => false],
        'page'         => ['except' => 1],
    ];

    public function rules()
    {
        return [
            'fechainicial' => 'nullable|date',
            'fechafinal'   => 'nullable|date|after_or_equal:fechainicial',
        ];
    }

    public function updatingFechainicial()
    {
        $this->resetPage();
    }
    public function updatingFechafinal()
    {
        $this->resetPage();
    }

    public function aceptar()
    {
        $this->validate();
        $this->aplicar = true;
        $this->resetPage();
    }

    protected function baseQuery()
    {
        return Reporte::with([
            'estado',
            'categoria',
            'tecnico',
            'departamento',
            'area',
            'tecnicos'
        ])
            ->whereHas('estado', fn($q) => $q->where('name', 'Atendido'))
            ->when($this->fechainicial, fn($q) => $q->whereDate('created_at', '>=', $this->fechainicial))
            ->when($this->fechafinal,   fn($q) => $q->whereDate('created_at', '<=', $this->fechafinal))
            ->orderByDesc('created_at');
    }

    public function exportarExcel()
    {
        // Validar antes de exportar
        $this->validate();

        // nombre de archivo
        // $file = 'reportes_atendidos_' . now()->format('Ymd_His') . '.xlsx';
        $file = 'reportes_atendidos_' . $this->fechainicial . '_' . $this->fechafinal . '.xlsx';

        // Livewire v3 permite retornar respuestas (descarga)
        return Excel::download(
            new ReportesAtendidosExport($this->fechainicial, $this->fechafinal),
            $file
        );
    }

    public function mount()
    {
        // Formato que acepta <input type="date">
        $hoy = now()->format('Y-m-d');

        // Si no vienen en la URL ni fueron seteadas, usa hoy
        if (empty($this->fechainicial)) {
            $this->fechainicial = $hoy;
        }

        if (empty($this->fechafinal)) {
            $this->fechafinal = $hoy;
        }
    }


    public function render()
    {
        $reportes = $this->aplicar
            ? $this->baseQuery()->paginate(10)
            : collect(); // vacío hasta que se pulse Aceptar

        return view('livewire.reportes-atendidos', compact('reportes'));
    }
}

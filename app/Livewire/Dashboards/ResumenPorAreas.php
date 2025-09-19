<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Reporte, AreasInformatica, User};
use Illuminate\Support\Facades\DB;

class ResumenPorAreas extends Component
{
    use WithPagination;

    public ?string $fechainicial = null;
    public ?string $fechafinal   = null;
    public bool $aplicar = false;

    /** Mapeo nombre->id para ubicar las 4 áreas del boceto */
    public array $areas = []; // ['Redes y telecomunicaciones' => 1, ...]

    protected $queryString = [
        'fechainicial' => ['except' => ''],
        'fechafinal'   => ['except' => ''],
        'aplicar'      => ['except' => false],
    ];

    public function rules()
    {
        return [
            'fechainicial' => 'required|date',
            'fechafinal'   => 'required|date|after_or_equal:fechainicial',
        ];
    }

    public function mount()
    {
        $hoy = now()->format('Y-m-d');
        $this->fechainicial ??= $hoy;
        $this->fechafinal   ??= $hoy;

        // Cargamos todas las áreas disponibles: name => id
        $this->areas = AreasInformatica::pluck('id', 'name')->toArray();

        // Si quieres fijar nombres exactos del boceto, asegúrate de que existan en BD
        // y corrige si los tuyos varían:
        // - Redes y telecomunicaciones
        // - Desarrollo de sistemas
        // - Diseño e identidad
        // - Operaciones y servicios
    }

    public function aceptar()
    {
        $this->validate();
        $this->aplicar = true;
        $this->resetPage();
    }

    /** Resumen de técnicos (conteo único por técnico: principal o en pivote) */
    protected function tecnicosResumen(): array
    {
        if (!$this->aplicar) return [];

        // Subquery: (user_id, reporte_id) de principal
        $principal = DB::table('reportes')
            ->select([
                'reportes.tecnico_user_id as user_id',
                'reportes.id as reporte_id',
            ])
            ->whereNotNull('reportes.tecnico_user_id')
            ->where('reportes.estado_id', 3) // solo Cerrado
            ->when($this->fechainicial, fn($q) => $q->whereDate('reportes.created_at', '>=', $this->fechainicial))
            ->when($this->fechafinal,   fn($q) => $q->whereDate('reportes.created_at', '<=', $this->fechafinal));

        // Subquery: (user_id, reporte_id) desde pivote
        // Ajusta el nombre de la tabla pivote si es distinto
        $colaboradores = DB::table('reporte_user')
            ->join('reportes', 'reportes.id', '=', 'reporte_user.reporte_id')
            ->select([
                'reporte_user.user_id as user_id',
                'reportes.id as reporte_id',
            ])
            ->where('reportes.estado_id', 3) // solo Cerrado
            ->when($this->fechainicial, fn($q) => $q->whereDate('reportes.created_at', '>=', $this->fechainicial))
            ->when($this->fechafinal,   fn($q) => $q->whereDate('reportes.created_at', '<=', $this->fechafinal));

        // UNION de ambas fuentes y conteo DISTINCT por usuario
        $totales = DB::query()
            ->fromSub(
                $principal->unionAll($colaboradores),
                'asig'
            )
            ->select('user_id', DB::raw('COUNT(DISTINCT reporte_id) as total'))
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        // Lista final ordenada por nombre (muestra 0 si no tiene)
        $tecnicos = \App\Models\User::orderBy('name')->get(['id', 'name']);

        return $tecnicos->map(fn($u) => [
            'id'    => $u->id,
            'name'  => $u->name,
            'total' => (int) ($totales[$u->id] ?? 0),
        ])->toArray();
    }


    public function render()
    {
        $tecnicosResumen = $this->tecnicosResumen();

        return view('livewire.dashboards.resumen-por-areas', [
            'tecnicosResumen' => $tecnicosResumen,
        ]);
    }
}

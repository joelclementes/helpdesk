<?php

namespace App\Exports;

use App\Models\Reporte;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportesAtendidosExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(
        protected ?string $fechainicial = null,
        protected ?string $fechafinal = null,
        public ?int $tecnicoId = null
    ) {}

    public function query()
    {
        return Reporte::with(['estado', 'categoria', 'tecnico', 'departamento', 'area', 'tecnicos'])
            ->whereHas('estado', fn($q) => $q->where('name', 'Cerrado'))
            ->when($this->fechainicial, fn($q) => $q->whereDate('created_at', '>=', $this->fechainicial))
            ->when($this->fechafinal,   fn($q) => $q->whereDate('created_at', '<=', $this->fechafinal))
            ->when($this->tecnicoId, function ($q, $id) {
                $q->where(function ($qq) use ($id) {
                    $qq->where('tecnico_user_id', $id)
                        ->orWhereHas('tecnicos', fn($t) => $t->where('users.id', $id));
                });
            })
            ->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return ['ID','Fecha','Estado','Departamento','Área','Categoría','Técnico principal','Descripción'];
    }

      public function map($reporte): array
    {
        return [
            $reporte->id,
            optional($reporte->created_at)->format('Y-m-d H:i'),
            optional($reporte->estado)->name,
            optional($reporte->departamento)->name,
            optional($reporte->area)->name,
            optional($reporte->categoria)->name,
            optional($reporte->tecnico)->name,
            $reporte->descripcion,
        ];
    }
}

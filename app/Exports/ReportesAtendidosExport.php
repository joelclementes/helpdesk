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
        protected ?string $fechafinal = null
    ) {}

    public function query()
    {
        return Reporte::with(['estado','categoria','tecnico','departamento','area','tecnicos'])
            ->whereHas('estado', fn($q) => $q->where('name','Atendido'))
            ->when($this->fechainicial, fn($q) => $q->whereDate('created_at','>=',$this->fechainicial))
            ->when($this->fechafinal,   fn($q) => $q->whereDate('created_at','<=',$this->fechafinal))
            ->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return ['Fecha', 'Departamento', 'Área de informática', 'Categoría', 'Técnicos'];
    }

    public function map($reporte): array
    {
        // Técnicos: usar pivote (si no hay, caer al principal)
        $tecnicos = $reporte->tecnicos?->pluck('name')->join(', ');
        if (!$tecnicos) {
            $tecnicos = $reporte->tecnico?->name ?? '';
        }

        return [
            optional($reporte->created_at)->format('d/m/Y'),
            $reporte->departamento->name    ?? '',
            $reporte->area->name ?? '',
            $reporte->categoria->name       ?? '',
            $tecnicos,
        ];
    }
}

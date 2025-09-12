<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reporte;

class ReportesFactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $totPendientes = 5;
        $totAtendidos  = 5;
        $totCerrados   = 20;
        $totCancelados = 0;

        Reporte::factory()
            ->count($totPendientes)
            ->pendiente()
            ->create();

        Reporte::factory()
            ->count($totAtendidos)
            ->atendido()
            ->create();

        Reporte::factory()
            ->count($totCerrados)
            ->cerrado()
            ->conDiasAtras(12)
            ->create();

        Reporte::factory()
            ->count($totCancelados)
            ->cancelado()
            ->create();


        $this->command->info('✅ Se crearon '. $totPendientes + $totAtendidos + $totCerrados + $totCancelados .' reportes exitosamente con el factory');
        $this->command->info('📊 Distribución:');
        $this->command->info('   - ' . $totPendientes . ' Pendientes');
        $this->command->info('   - ' . $totAtendidos . ' Atendidos');
        $this->command->info('   - ' . $totCerrados . ' Cerrados');
        $this->command->info('   - ' . $totCancelados . ' Cancelados');
    }
}

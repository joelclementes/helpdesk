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
        // 60 reportes pendientes (30%)
        Reporte::factory()
            ->count(2)
            ->pendiente()
            ->create();

        // 50 reportes atendidos (25%)
        Reporte::factory()
            ->count(20)
            ->atendido()
            ->create();

        // 70 reportes cerrados (35%)
        Reporte::factory()
            ->count(150)
            ->cerrado()
            ->create();

        // 20 reportes cancelados (10%)
        Reporte::factory()
            ->count(2)
            ->cancelado()
            ->create();

        // Crear algunos reportes específicos para pruebas
        
        // 10 reportes recientes pendientes
        Reporte::factory()
            ->count(5)
            ->reciente()
            ->pendiente()
            ->create();

        // 5 reportes antiguos cerrados
        Reporte::factory()
            ->count(200)
            ->antiguo()
            ->cerrado()
            ->create();

        $this->command->info('✅ Se crearon 200 reportes exitosamente con el factory');
        $this->command->info('📊 Distribución:');
        $this->command->info('   - 70 Pendientes (60 + 10 recientes)');
        $this->command->info('   - 50 Atendidos');
        $this->command->info('   - 75 Cerrados (70 + 5 antiguos)');
        $this->command->info('   - 20 Cancelados');
    }
}

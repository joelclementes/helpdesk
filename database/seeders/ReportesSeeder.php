<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reporte;

class ReportesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reportes = [
            [
                'reporte_data' => [
                    'id' => 1,
                    'departamento_congreso_id' => 1,
                    'solicitante' => 'Juan Pérez',
                    'descripcion' => 'Recibí un correo sospechoso. Lo abrí y ahora cuando entro al navegador me abre páginas que no he visto.',
                    'area_informatica_id' => 5,
                    'categoria_id' => 5,
                    'capturo_user_id' => 2,
                    'tecnico_user_id' => 21,
                    'estado_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
            [
                'reporte_data' => [
                    'id' => 2,
                    'departamento_congreso_id' => 1,
                    'solicitante' => 'María López',
                    'descripcion' => 'El sistema está lento. Estaba trabajando bien hasta antes que le instalaran la última actualización de windows',
                    'area_informatica_id' => 5,
                    'categoria_id' => 10,
                    'capturo_user_id' => 2,
                    'tecnico_user_id' => 19,
                    'estado_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
            [
                'reporte_data' => [
                    'id' => 3,
                    'departamento_congreso_id' => 1,
                    'solicitante' => 'Pedro González',
                    'descripcion' => 'No puedo acceder a la aplicación.',
                    'area_informatica_id' => 5,
                    'categoria_id' => 9,
                    'capturo_user_id' => 2,
                    'tecnico_user_id' => 23,
                    'estado_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
        ];

        foreach ($reportes as $reporte) {
            Reporte::create($reporte['reporte_data']);
        }
    }
}

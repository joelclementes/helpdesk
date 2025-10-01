<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['name' => 'Servicio', 'area_informatica_id' => 1],
            ['name' => 'Actualización de página web', 'area_informatica_id' => 3],
            ['name' => 'Actualización de sistemas web','area_informatica_id' => 3],
            ['name' => 'Actualización de software','area_informatica_id' => 3],
            ['name' => 'Ajuste de documentos para fotocopiado','area_informatica_id' => 4],
            ['name' => 'Ajuste de documentos para impresión','area_informatica_id' => 4],
            ['name' => 'Antivirus','area_informatica_id' => 5],
            ['name' => 'Archivo para impresión de cartel','area_informatica_id' => 4],
            ['name' => 'Archivo para impresión de lona','area_informatica_id' => 4],
            ['name' => 'Archivos para proveedores'],
            ['name' => 'Asesoria diseño','area_informatica_id' => 4],
            ['name' => 'Asesoría en manejo de software','area_informatica_id' => 5],
            ['name' => 'Asesoría en Operación de Software y Hardware','area_informatica_id' => 5],
            ['name' => 'Atención equipo de cómputo','area_informatica_id' => 5],
            ['name' => 'Atn. fallas fotocopiado','area_informatica_id' => 5],
            ['name' => 'Atn. fallas impresoras','area_informatica_id' => 5],
            ['name' => 'Atn. Fallas periféricos','area_informatica_id' => 5],
            ['name' => 'Atn. fallas, software o aplicación','area_informatica_id' => 5],
            ['name' => 'Cambio de toner','area_informatica_id' => 5],
            ['name' => 'Capacitación a comisiones','area_informatica_id' => 3],
            ['name' => 'Copia de CD/DVD','area_informatica_id' => 5],
            ['name' => 'Correo electrónico','area_informatica_id' => 2],
            ['name' => 'Correo electrónico institucional','area_informatica_id' => 2],
            ['name' => 'Diseño de carteles','area_informatica_id' => 4],
            ['name' => 'Diseño de identidad','area_informatica_id' => 4],
            ['name' => 'Diseño y creación de sistemas','area_informatica_id' => 3],
            ['name' => 'Edición de documentos','area_informatica_id' => 4],
            ['name' => 'Edición de fotos','area_informatica_id' => 4],
            ['name' => 'Escaneo','area_informatica_id' => 4],
            ['name' => 'Grabación y transmisión de comparecencias','area_informatica_id' => 2],
            ['name' => 'Grabación y transmisión de entrevistas','area_informatica_id' => 2],
            ['name' => 'Grabación y transmisión de eventos generales','area_informatica_id' => 2],
            ['name' => 'Grabación y transmisión de juntas de comisiones','area_informatica_id' => 2],
            ['name' => 'Grabación y transmisión de sesiones ordinarias','area_informatica_id' => 2],
            ['name' => 'Grabación y transmisión de sesiones permanentes','area_informatica_id' => 2],
            ['name' => 'Impresión de documentos','area_informatica_id' => 4],
            ['name' => 'Impresión de papelería de diputados y/o áreas administrativas','area_informatica_id' => 4],
            ['name' => 'Impresión de personificadores','area_informatica_id' => 4],
            ['name' => 'Impresión de ploteo','area_informatica_id' => 4],
            ['name' => 'Impresión de recetas de servicio médico','area_informatica_id' => 4],
            ['name' => 'Impresión documentos (Impresora recepción)','area_informatica_id' => 4],
            ['name' => 'Instalación de software','area_informatica_id' => 5],
            ['name' => 'Instalación y configuración de PC','area_informatica_id' => 5],
            ['name' => 'Internet','area_informatica_id' => 2],
            ['name' => 'Mantenimiento preventivo Impresoras','area_informatica_id' => 5],
            ['name' => 'Mantenimiento preventivo PC','area_informatica_id' => 5],
            ['name' => 'Red','area_informatica_id' => 2],
            ['name' => 'Req. Configuración de sw y hw','area_informatica_id' => 5],
            ['name' => 'Req. Proceso y respaldo de datos','area_informatica_id' => 5],
            ['name' => 'Requerimiento, Actualización de Software','area_informatica_id' => 3],
            ['name' => 'Requerimiento, Instalación de equipo','area_informatica_id' => 5],
            ['name' => 'Respaldo de datos','area_informatica_id' => 5],
            ['name' => 'Servicios de fotocopiado','area_informatica_id' => 5],
            ['name' => 'Soporte de aplicaciones realizadas al área administrativa','area_informatica_id' => 3],
            ['name' => 'Telefonía','area_informatica_id' => 2],
            ['name' => 'Video','area_informatica_id' => 2],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
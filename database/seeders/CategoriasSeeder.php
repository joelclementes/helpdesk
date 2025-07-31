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
            ['name' => 'Actualización de página web'],
            ['name' => 'Actualización de sistemas web'],
            ['name' => 'Actualización de software'],
            ['name' => 'Ajuste de documentos para impresión'],
            ['name' => 'Antivirus'],
            ['name' => 'Archivo para impresión de lona'],
            ['name' => 'Archivos para proveedores'],
            ['name' => 'Asesoria diseño'],
            ['name' => 'Asesoría en manejo de software'],
            ['name' => 'Asesoría en Operación de Software y Hardware'],
            ['name' => 'Atención equipo de cómputo'],
            ['name' => 'Atn. fallas fotocopiado'],
            ['name' => 'Atn. fallas impresoras'],
            ['name' => 'Atn. Fallas periféricos'],
            ['name' => 'Atn. fallas, software o aplicación'],
            ['name' => 'Cambio de toner'],
            ['name' => 'Capacitación a comisiones'],
            ['name' => 'Copia de CD/DVD'],
            ['name' => 'Correo electrónico'],
            ['name' => 'Correo electrónico institucional'],
            ['name' => 'Diseño de carteles'],
            ['name' => 'Diseño de identidad'],
            ['name' => 'Diseño y creación de sistemas'],
            ['name' => 'Edición de documentos'],
            ['name' => 'Edición de fotos'],
            ['name' => 'Escaneo'],
            ['name' => 'Grabación y transmisión de comparecencias'],
            ['name' => 'Grabación y transmisión de entrevistas'],
            ['name' => 'Grabación y transmisión de eventos generales'],
            ['name' => 'Grabación y transmisión de juntas de comisiones'],
            ['name' => 'Grabación y transmisión de sesiones ordinarias'],
            ['name' => 'Grabación y transmisión de sesiones permanentes'],
            ['name' => 'Impresión de documentos'],
            ['name' => 'Impresión de papelería de diputados y/o áreas administrativas'],
            ['name' => 'Impresión de personificadores'],
            ['name' => 'Impresión de ploteo'],
            ['name' => 'Impresión de recetas de servicio médico'],
            ['name' => 'Impresión documentos (Impresora recepción)'],
            ['name' => 'Instalación de software'],
            ['name' => 'Instalación y configuración de PC'],
            ['name' => 'Internet'],
            ['name' => 'Mantenimiento preventivo Impresoras'],
            ['name' => 'Mantenimiento preventivo PC'],
            ['name' => 'Red'],
            ['name' => 'Req. Configuración de sw y hw'],
            ['name' => 'Req. Proceso y respaldo de datos'],
            ['name' => 'Requerimiento, Actualización de Software'],
            ['name' => 'Requerimiento, Instalación de equipo'],
            ['name' => 'Respaldo de datos'],
            ['name' => 'Servicios de fotocopiado'],
            ['name' => 'Soporte de aplicaciones realizadas al área administrativa'],
            ['name' => 'Telefonía'],
            ['name' => 'Video'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
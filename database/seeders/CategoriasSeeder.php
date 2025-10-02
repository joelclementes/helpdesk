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
            ['name' => 'Telefonía','area_informatica_id' => 2],
            ['name' => 'Red','area_informatica_id' => 2],
            ['name' => 'Internet','area_informatica_id' => 2],
            ['name' => 'Correo electrónico institucional','area_informatica_id' => 2],
            ['name' => 'Copia de archivo de video / audio.','area_informatica_id' => 2],
            ['name' => 'Actualización de software','area_informatica_id' => 5],
            ['name' => 'Antivirus','area_informatica_id' => 5],
            ['name' => 'Apoyo con Cronometro','area_informatica_id' => 5],
            ['name' => 'Asesoría en manejo de software','area_informatica_id' => 5],
            ['name' => 'Asesoría en Operación de Software y Hardware','area_informatica_id' => 5],
            ['name' => 'Asesoria paginas Web','area_informatica_id' => 5],
            ['name' => 'Asistencia a Videoconferencias','area_informatica_id' => 5],
            ['name' => 'Atención equipo de cómputo','area_informatica_id' => 5],
            ['name' => 'Atn. fallas fotocopiado e Impresoras','area_informatica_id' => 5],
            ['name' => 'Atn. Fallas periféricos','area_informatica_id' => 5],
            ['name' => 'Atn. fallas, software o aplicación','area_informatica_id' => 5],
            ['name' => 'Cambio de toner','area_informatica_id' => 5],
            ['name' => 'Capacitación a comisiones','area_informatica_id' => 5],
            ['name' => 'Configuracion Carpeta Compartida','area_informatica_id' => 5],
            ['name' => 'Configuracion de Impresoras','area_informatica_id' => 5],
            ['name' => 'Formateo de equipo','area_informatica_id' => 5],
            ['name' => 'Instalación de equipo','area_informatica_id' => 5],
            ['name' => 'Instalacion de Impresoras','area_informatica_id' => 5],
            ['name' => 'Instalación de software','area_informatica_id' => 5],
            ['name' => 'Instalacion y Asistencia de Proyector','area_informatica_id' => 5],
            ['name' => 'Instalación y configuración de PC','area_informatica_id' => 5],
            ['name' => 'Kiosco de Impresoras','area_informatica_id' => 5],
            ['name' => 'Mantenimiento preventivo Impresoras','area_informatica_id' => 5],
            ['name' => 'Mantenimiento preventivo PC','area_informatica_id' => 5],
            ['name' => 'Req. Configuración de sw y hw','area_informatica_id' => 5],
            ['name' => 'Req. Proceso y respaldo de datos','area_informatica_id' => 5],
            ['name' => 'Servicio de fotocopiado y escaner','area_informatica_id' => 5],
            ['name' => 'Diseño e impresión de Invitaciones de Eventos','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Invitaciones ','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Personificadores','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Invitaciones de gafetes','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Invitaciones de Trípticos o volantes','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Invitaciones de convocatorias','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Invitaciones de carteles','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Invitaciones de etiquetas','area_informatica_id' => 4],
            ['name' => 'Diseño de banner para página web del congreso','area_informatica_id' => 4],
            ['name' => 'Edición e impresión de papelería oficial','area_informatica_id' => 4],
            ['name' => 'Edición e impresión de documento JUCOPO (ficha foleada)','area_informatica_id' => 4],
            ['name' => 'Edición de documentos para impresión','area_informatica_id' => 4],
            ['name' => 'Impresión de papelería oficial','area_informatica_id' => 4],
            ['name' => 'Impresión de documento oficial de servicio médico','area_informatica_id' => 4],
            ['name' => 'Diseño e impresión de Tarjetas de felicitación de Diputados','area_informatica_id' => 4],
            ['name' => 'Impresión de documentos','area_informatica_id' => 4],
            ['name' => 'Edición de fotografías','area_informatica_id' => 4],
            ['name' => 'Diseño de archivo para impresión de lona','area_informatica_id' => 4],
            ['name' => 'Archivos para proveedores','area_informatica_id' => 4],
            ['name' => 'Asesoría en diseños','area_informatica_id' => 4],
            ['name' => 'Actualización de página institucional','area_informatica_id' => 3],
            ['name' => 'Capacitación a usuarios','area_informatica_id' => 3],
            ['name' => 'Diseño y desarrollo de aplicaciones','area_informatica_id' => 3],
            ['name' => 'Mantenimiento de aplicaciones','area_informatica_id' => 3],
            ['name' => 'Mantenimiento de pagina institucional','area_informatica_id' => 3],
            ['name' => 'Transmisión de Video y Audio','area_informatica_id' => 2],
            ['name' => 'Apoyo a sesiones','area_informatica_id' => 1],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
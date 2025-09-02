<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class ReportesItem extends Component
{
    public Reporte $reporte;

    public function atender() { $this->reporte->estado_id = 2; $this->reporte->save(); }
    public function cerrar()  { $this->reporte->estado_id = 3; $this->reporte->closed_at = now(); $this->reporte->save(); }
    public function cancelar(){ $this->reporte->estado_id = 4; $this->reporte->save(); }
    public function comentar(){ $this->dispatch('abrirModalComentario', id: $this->reporte->id); }

    public function render()
    {
        return view('livewire.reportes-item');
    }
}

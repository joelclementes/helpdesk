<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'eventos';

    protected $fillable = [
        'id',
        'name',
        'date',
        'activo',
    ];

    public function reportes(){
        return $this->hasMany(Reporte::class, 'evento_id');
    }

    public function scopeActivos($q){
        return $q->where('activo', 1); // ajusta IDs
    }
}

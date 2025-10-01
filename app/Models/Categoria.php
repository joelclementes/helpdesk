<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';

    protected $fillable = ['name', 'area_informatica_id'];

    public function area()
    {
        // tu modelo es App\Models\AreasInformatica
        return $this->belongsTo(AreasInformatica::class, 'area_informatica_id');
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'categoria_id');
    }
}

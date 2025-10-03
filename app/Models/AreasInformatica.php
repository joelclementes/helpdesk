<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasInformatica extends Model
{
    use HasFactory;
    protected $table = 'area_informatica';

    protected $fillable = [
        'id',
        'name'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'area_id');
    }
}

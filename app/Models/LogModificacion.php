<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogModificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario',
        'material',
        'orden_previsional',
        'fecha',
        'campos_anteriores',
        'campos_nuevos'
    ];
}

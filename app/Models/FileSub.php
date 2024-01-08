<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FileSub extends Model
{
    public $table = 'subfiles';
    public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public $casts = [
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
    ];

    public $fillable = [
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'idfile',
        'Route',
        'Nombre',
    ];
}

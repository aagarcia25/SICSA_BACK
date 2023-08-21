<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 *
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $idowner
 * @property string|null $Route
 * @property string|null $Nombre
 *
 * @package App\Models
 */
class File extends Model
{
    public $table = 'files';
    protected $_keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $_casts = [
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
    ];

    protected $_fillable = [
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'idowner',
        'Route',
        'Nombre',
        'Estatus',
    ];
}

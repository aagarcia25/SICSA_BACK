<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Municipio
 *
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string $Nombre
 * @property int $ClaveEstado
 * @property string $NombreCorto
 * @property int|null $ClaveINEGI
 *
 * @package App\Models
 */
class Municipio extends Model
{
    public $table = 'Municipios';
    public $incrementing = false;
    public $timestamps = false;

    protected $_casts = [
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
        'ClaveEstado' => 'int',
        'ClaveINEGI' => 'int',
    ];

    protected $_fillable = [
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'Nombre',
        'ClaveEstado',
        'ClaveINEGI',
    ];
}

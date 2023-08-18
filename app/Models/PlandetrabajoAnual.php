<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlandetrabajoAnual
 *
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property Carbon|null $start
 * @property Carbon|null $end
 * @property string|null $name
 * @property string|null $type
 * @property int|null $progress
 * @property int|null $anio
 * @property int|null $orden
 *
 * @package App\Models
 */
class PlandetrabajoAnual extends Model
{
    protected $_table = 'plandetrabajoAnual';
    public $incrementing = false;
    public $timestamps = false;
    protected $_keyType = 'string';
    protected $_primaryKey = 'id';

    protected $_casts = [
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
        'start' => 'datetime',
        'end' => 'datetime',
        'progress' => 'int',
        'anio' => 'int',
        'orden' => 'int',
    ];

    protected $_fillable = [
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'start',
        'end',
        'name',
        'type',
        'progress',
        'anio',
        'orden',
    ];
}

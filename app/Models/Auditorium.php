<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Auditorium
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property int $Consecutivo
 * @property string|null $Encargado
 * @property int|null $NAUDITORIA
 * @property string|null $NombreAudoria
 * @property string|null $ActaInicio
 * @property string|null $OFinicio
 * @property Carbon|null $Fecha_Recibido
 * @property Carbon|null $Fecha_Vencimiento
 *
 * @package App\Models
 */
class Auditorium extends Model
{
	protected $table = 'Auditoria';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'deleted' => 'binary',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'Consecutivo' => 'int',
		'NAUDITORIA' => 'int',
		'Fecha_Recibido' => 'datetime',
		'Fecha_Vencimiento' => 'datetime'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Consecutivo',
		'Encargado',
		'NAUDITORIA',
		'NombreAudoria',
		'ActaInicio',
		'OFinicio',
		'Fecha_Recibido',
		'Fecha_Vencimiento'
	];
}

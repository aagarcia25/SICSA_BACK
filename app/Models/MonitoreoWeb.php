<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MonitoreoWeb
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $Url
 * @property string|null $Correos
 * @property string|null $Alias
 * @property int|null $Tiempo
 *
 * @package App\Models
 */
class MonitoreoWeb extends Model
{
	protected $table = 'MonitoreoWeb';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UltimaEjecucion' => 'datetime',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'Tiempo' => 'int'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Url',
		'Correos',
		'Alias',
		'Tiempo',
		'UltimaEjecucion'
	];
}

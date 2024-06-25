<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatDependencia
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string $Descripcion
 *
 * @package App\Models
 */
class CatDependencia extends Model
{
	protected $table = 'Cat_Dependencias';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'id',
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Descripcion',
		'Siglas'
	];
}

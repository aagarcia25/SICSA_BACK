<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatTiposAccion
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $Descripcion
 *
 * @package App\Models
 */
class CatTiposAccion extends Model
{
	public $table = 'Cat_Tipos_Accion';
	public $primaryKey = 'id';
	public $keyType ='string';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Descripcion',
		'Abreviatura'
	];
}

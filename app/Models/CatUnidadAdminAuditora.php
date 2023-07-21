<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatUnidadAdminAuditora
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
class CatUnidadAdminAuditora extends Model
{
	protected $table = 'Cat_Unidad_Admin_Auditora';
	protected $keyType ='string';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'deleted' => 'binary',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Descripcion'
	];
}

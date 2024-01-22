<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatDestinatariosOficio
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string $Titular
 * @property string $Cargo
 * @property string $Area
 * @property string $CorreoElectronico
 * @property string $Telefono
 * @property string $Extension
 *
 * @package App\Models
 */
class CatDestinatariosOficio extends Model
{
	public $table = 'Cat_Destinatarios_Oficios';
	public $incrementing = false;
	public $timestamps = false;

	protected $_casts = [
		'deleted' => 'binary',
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
		'Titular',
		'Cargo',
		'Area',
		'CorreoElectronico',
		'Telefono',
		'Extension'
	];
}

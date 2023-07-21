<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CContestacionArea
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $Dependencia
 * @property Carbon|null $Prorroga
 * @property string|null $idNotificacion
 * @property string|null $Oficio
 * @property string|null $SIGAOficio
 * 
 * @property CNotificacionArea|null $c_notificacion_area
 *
 * @package App\Models
 */
class CContestacionArea extends Model
{
	protected $table = 'C_Contestacion_area';
	protected $keyType ='string';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'deleted' => 'binary',
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'Prorroga' => 'datetime'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Dependencia',
		'Prorroga',
		'idNotificacion',
		'Oficio',
		'SIGAOficio'
	];

	public function c_notificacion_area()
	{
		return $this->belongsTo(CNotificacionArea::class, 'idNotificacion');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficiosA
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string $idAuditoria
 * @property Carbon|null $FechaRecibido
 * @property Carbon|null $FechaVencimiento
 * 
 * @property Auditorium $auditorium
 *
 * @package App\Models
 */
class OficiosA extends Model
{
	public $table = 'OficiosA';
	public $incrementing = false;
	public $timestamps = false;
	public $keyType ='string';
	public $primaryKey = 'id';

	protected $casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'FechaRecibido' => 'datetime',
		'FechaVencimiento' => 'datetime'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'idAuditoria',
		'Oficio',
		'FechaRecibido',
		'FechaVencimiento'
	];

	public function auditorium()
	{
		return $this->belongsTo(Auditorium::class, 'idAuditoria');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Accione
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property int|null $anio
 * @property string|null $idTipoAccion
 * @property string|null $idAuditoria
 * @property string|null $idEstatusAccion
 * @property string|null $ClaveAccion
 * @property string|null $TextoAccion
 * @property float|null $Valor
 * 
 * @property Auditorium|null $auditorium
 * @property CatTiposAccion|null $cat_tipos_accion
 * @property CatEstatusAccione|null $cat_estatus_accione
 *
 * @package App\Models
 */
class Accione extends Model
{
	protected $table = 'Acciones';
	public $incrementing = false;
	public $timestamps = false;
	protected $keyType ='string';
	protected $primaryKey = 'id';
	
	protected $casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'anio' => 'int',
		'Valor' => 'float'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'anio',
		'idTipoAccion',
		'idAuditoria',
		'idEstatusAccion',
		'ClaveAccion',
		'TextoAccion',
		'Valor'
	];

	public function auditorium()
	{
		return $this->belongsTo(Auditorium::class, 'idAuditoria');
	}

	public function cat_tipos_accion()
	{
		return $this->belongsTo(CatTiposAccion::class, 'idTipoAccion');
	}

	public function cat_estatus_accione()
	{
		return $this->belongsTo(CatEstatusAccione::class, 'idEstatusAccion');
	}
}

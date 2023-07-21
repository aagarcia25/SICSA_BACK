<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
 * @property string|null $FolioSIGA
 * @property string|null $Encargado
 * @property string|null $PersonalEncargado
 * @property int|null $NAUDITORIA
 * @property string|null $NombreAudoria
 * @property string|null $ActaInicio
 * @property string|null $OFinicio
 * @property Carbon|null $Fecha_Recibido
 * @property Carbon|null $Fecha_Vencimiento
 * @property string|null $idCatInforme
 * @property string|null $idTipoAuditoria
 * @property string|null $idCatSector
 * @property string|null $idCatEntidadFiscalizada
 * 
 * @property CatInforme|null $cat_informe
 * @property CatTiposAuditorium|null $cat_tipos_auditorium
 * @property CatSector|null $cat_sector
 * @property CatEntidadFiscalizada|null $cat_entidad_fiscalizada
 * @property Collection|CNotificacionArea[] $c_notificacion_areas
 *
 * @package App\Models
 */
class Auditorium extends Model
{
	protected $table = 'Auditoria';
	public $incrementing = false;
	public $timestamps = false;
	protected $keyType ='string';
	protected $casts = [
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
		'FolioSIGA',
		'Encargado',
		'PersonalEncargado',
		'NAUDITORIA',
		'NombreAudoria',
		'ActaInicio',
		'OFinicio',
		'Fecha_Recibido',
		'Fecha_Vencimiento',
		'idCatInforme',
		'idTipoAuditoria',
		'idCatSector',
		'idCatEntidadFiscalizada'
	];

	public function cat_informe()
	{
		return $this->belongsTo(CatInforme::class, 'idCatInforme');
	}

	public function cat_tipos_auditorium()
	{
		return $this->belongsTo(CatTiposAuditorium::class, 'idTipoAuditoria');
	}

	public function cat_sector()
	{
		return $this->belongsTo(CatSector::class, 'idCatSector');
	}

	public function cat_entidad_fiscalizada()
	{
		return $this->belongsTo(CatEntidadFiscalizada::class, 'idCatEntidadFiscalizada');
	}

	public function c_notificacion_areas()
	{
		return $this->hasMany(CNotificacionArea::class, 'idAuditoria');
	}
}

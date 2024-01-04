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
 * @property int|null $anio
 * @property int|null $NAUDITORIA
 * @property string|null $FolioSIGA
 * @property string|null $Modalidad
 * @property int $Consecutivo
 * @property string|null $ActaInicio
 * @property string|null $NombreAudoria
 * @property string|null $Encargado
 * @property string|null $PersonalEncargado
 * @property string|null $idClasificacion
 * @property string|null $idcatorigenaud
 * @property string|null $idCatGrupoFuncional
 * @property string|null $idCatSector
 * @property string|null $idCatEntidadFiscalizada
 * @property string|null $idTipoAuditoria
 * @property string|null $idCatInforme
 * @property string|null $idUnidadAdm
 * @property string|null $idAreaAdm
 * @property string|null $idRamo
 * @property float|null $universopesos
 * @property float|null $muestrapesos
 *
 * @property string|null $idInicioauditoria
 * @property string|null $idmunicipio
 * @property string|null $idEstatus
 *
 * @property CatRamo|null $cat_ramo
 * @property CatInicioAuditorium|null $cat_inicio_auditorium
 * @property Municipio|null $municipio
 * @property CatEstatusAuditorium|null $cat_estatus_auditorium
 * @property CatTipo|null $cat_tipo
 * @property CatOrigenAuditorium|null $cat_origen_auditorium
 * @property CatGrupoFuncional|null $cat_grupo_funcional
 * @property CatSector|null $cat_sector
 * @property CatEntidadFiscalizada|null $cat_entidad_fiscalizada
 * @property CatTiposAuditorium|null $cat_tipos_auditorium
 * @property CatInforme|null $cat_informe
 * @property CatUnidadAdminAuditora|null $cat_unidad_admin_auditora
 * @property CatAreaAuditora|null $cat_area_auditora
 * @property Collection|CNotificacionArea[] $c_notificacion_areas
 * @property Collection|OficiosA[] $oficios_as
 * @property Collection|Accione[] $acciones
 *
 * @package App\Models
 */
class Auditorium extends Model
{
    public $table = 'auditoria';
    public $incrementing = false;
    public $timestamps = false;
    public $keyType = 'string';
    public $primaryKey = 'id';

    public $_casts = [
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
        'anio' => 'int',
        'NAUDITORIA' => 'int',
        'Consecutivo' => 'int',
        'universopesos' => 'float',
        'muestrapesos' => 'float',
        'montoauditado' => 'float',
    ];

    protected $fillable = [
        //'ModificadoPor',
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'anio',
        
        'FolioSIGA',
        'idModalidad',
        'Consecutivo',
        'ActaInicio',
        'NombreAudoria',
        'Encargado',
        'PersonalEncargado','NAUDITORIA',
        'idClasificacion',
        'idcatorigenaud',
        'idCatGrupoFuncional',
        'idCatSector',
        'idCatEntidadFiscalizada',
        'idTipoAuditoria',
        'idCatInforme',
        'idUnidadAdm',
        'idAreaAdm',
        'idRamo',
        'universopesos',
        'muestrapesos',
        'idInicioauditoria',
        'idmunicipio',
        'idEstatus',
        'montoauditado',
        'entregado'
    ];

    public function cat_ramo()
    {
        return $this->belongsTo(CatRamo::class, 'idRamo');
    }

    public function cat_inicio_auditorium()
    {
        return $this->belongsTo(CatInicioAuditorium::class, 'idInicioauditoria');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'idmunicipio');
    }

    public function Cat_Modalidad()
    {
        return $this->belongsTo(CatModalidad::class, 'idmodalidad');
    }

    public function cat_estatus_auditorium()
    {
        return $this->belongsTo(CatEstatusAuditorium::class, 'idEstatus');
    }

    public function cat_tipo()
    {
        return $this->belongsTo(CatTipo::class, 'idClasificacion');
    }

    public function cat_origen_auditorium()
    {
        return $this->belongsTo(CatOrigenAuditorium::class, 'idcatorigenaud');
    }

    public function cat_grupo_funcional()
    {
        return $this->belongsTo(CatGrupoFuncional::class, 'idCatGrupoFuncional');
    }

    public function cat_sector()
    {
        return $this->belongsTo(CatSector::class, 'idCatSector');
    }

    public function cat_entidad_fiscalizada()
    {
        return $this->belongsTo(CatEntidadFiscalizada::class, 'idCatEntidadFiscalizada');
    }

    public function cat_tipos_auditorium()
    {
        return $this->belongsTo(CatTiposAuditorium::class, 'idTipoAuditoria');
    }

    public function cat_informe()
    {
        return $this->belongsTo(CatInforme::class, 'idCatInforme');
    }

    public function cat_unidad_admin_auditora()
    {
        return $this->belongsTo(CatUnidadAdminAuditora::class, 'idUnidadAdm');
    }

    public function cat_area_auditora()
    {
        return $this->belongsTo(CatAreaAuditora::class, 'idAreaAdm');
    }

    public function c_notificacion_areas()
    {
        return $this->hasMany(CNotificacionArea::class, 'idAuditoria');
    }

    public function oficios_as()
    {
        return $this->hasMany(OficiosA::class, 'idAuditoria');
    }

    public function acciones()
    {
        return $this->hasMany(Accione::class, 'idAuditoria');
    }
}

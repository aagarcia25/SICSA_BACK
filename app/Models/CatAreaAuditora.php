<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatAreaAuditora
 *
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string $Clave
 * @property string $Descripcion
 * @property string $idCatUnidadAdmin
 *
 * @property CatUnidadAdminAuditora $cat_unidad_admin_auditora
 *
 * @package App\Models
 */
class CatAreaAuditora extends Model
{
    public $table = 'cat_area_auditoras';
    public $incrementing = false;
    public $timestamps = false;
    protected $_primaryKey = 'id';
    protected $_keyType = 'string';

    protected $_casts = [
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
    ];

    protected $_fillable = [
        'deleted',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'Clave',
        'Descripcion',
        'idCatUnidadAdmin',
    ];

    public function cat_unidad_admin_auditora()
    {
        return $this->belongsTo(CatUnidadAdminAuditora::class, 'idCatUnidadAdmin');
    }
}

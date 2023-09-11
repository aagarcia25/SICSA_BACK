<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CNotificacionArea
 *
 * @property string $id
 * @property string $deleted
 * @property string $idAuditoria
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $Dependencia
 * @property Carbon|null $Prorroga
 * @property string|null $Oficio
 * @property string|null $SIGAOficio
 *
 * @property Auditorium $auditorium
 * @property Collection|CContestacionArea[] $c_contestacion_areas
 *
 * @package App\Models
 */
class CNotificacionArea extends Model
{
    protected $table = 'C_Notificacion_area';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [

        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
        'Prorroga' => 'datetime',
        'FOficio' => 'datetime',
        'FRecibido' => 'datetime',
        'FVencimiento' => 'datetime'
    ];

    protected $_fillable = [
        'deleted',
        'idAuditoria',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'Prorroga',
        'Oficio',
        'SIGAOficio',
        'FOficio',
        'FRecibido',
        'FVencimiento',
        'idsecretaria',
        'idunidad'
    ];

    public function auditorium()
    {
        return $this->belongsTo(Auditorium::class, 'idAuditoria');
    }

    public function c_contestacion_areas()
    {
        return $this->hasMany(CContestacionArea::class, 'idNotificacion');
    }
}

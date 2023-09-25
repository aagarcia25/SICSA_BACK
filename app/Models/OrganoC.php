<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganoC
 *
 * @property string $id
 * @property string $deleted
 * @property string $idAuditoria
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $Oficio
 * @property string|null $SIGAOficio
 * @property Carbon|null $FOficio
 * @property Carbon|null $FRecibido
 * @property Carbon|null $FVencimiento
 * @property string $idOrganoAuditorOrigen
 * @property string|null $idOrganoAuditorDestino
 *
 * @property Auditorium $auditorium
 * @property CatOrigenAuditorium|null $cat_origen_auditorium
 * @property Collection|OrganoR[] $organo_rs
 *
 * @package App\Models
 */
class OrganoC extends Model
{
    public $table = 'Organo_C';
    public $incrementing = false;
    public $timestamps = false;

    public $casts = [
        'UltimaActualizacion' => 'datetime',
        'FechaCreacion' => 'datetime',
        'FOficio' => 'datetime',
        'FRecibido' => 'datetime',
        'FVencimiento' => 'datetime',
    ];

    public $fillable = [
        'deleted',
        'idAuditoria',
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'Oficio',
        'SIGAOficio',
        'FOficio',
        'FRecibido',
        'FVencimiento',
        'idOrganoAuditorOrigen',
    ];

    public function auditorium()
    {
        return $this->belongsTo(Auditorium::class, 'idAuditoria');
    }

    public function cat_origen_auditorium()
    {
        return $this->belongsTo(CatOrigenAuditorium::class, 'idOrganoAuditorDestino');
    }

    public function organo_rs()
    {
        return $this->hasMany(OrganoR::class, 'idOrganoC');
    }
}

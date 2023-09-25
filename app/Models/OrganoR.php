<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganoR
 *
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $idOrganoC
 * @property string|null $Oficio
 * @property string|null $SIGAOficio
 * @property Carbon|null $FOficio
 * @property Carbon|null $FRecibido
 * @property Carbon|null $FVencimiento
 * @property string|null $idOrganoAuditorOrigen
 * @property string|null $idOrganoAuditorDestino
 *
 * @property OrganoC|null $organo_c
 * @property CatOrigenAuditorium|null $cat_origen_auditorium
 *
 * @package App\Models
 */
class OrganoR extends Model
{
    public $table = 'Organo_R';
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
        'UltimaActualizacion',
        'FechaCreacion',
        'ModificadoPor',
        'CreadoPor',
        'idOrganoC',
        'Oficio',
        'SIGAOficio',
        'FOficio',
        'FRecibido',
        'FVencimiento',
        'idOrganoAuditorOrigen',
        'idOrganoAuditorDestino',
    ];

    public function organo_c()
    {
        return $this->belongsTo(OrganoC::class, 'idOrganoC');
    }

    public function cat_origen_auditorium()
    {
        return $this->belongsTo(CatOrigenAuditorium::class, 'idOrganoAuditorDestino');
    }
}

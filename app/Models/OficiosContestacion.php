<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficiosContestacion
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property Carbon|null $Prorroga
 * @property string|null $idOficio
 * @property string|null $Oficio
 * @property string|null $SIGAOficio
 * @property Carbon|null $FOficio
 * @property Carbon|null $FRecibido
 * @property Carbon|null $FVencimiento
 * @property string|null $idsecretaria
 * @property string|null $idunidad
 * 
 * @property OficiosA|null $oficios_a
 * @property CatSecretaria|null $cat_secretaria
 * @property CatUnidade|null $cat_unidade
 *
 * @package App\Models
 */
class OficiosContestacion extends Model
{
	protected $table = 'Oficios_Contestacion';
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

	protected $hidden = [
		'idsecretaria'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Prorroga',
		'idOficio',
		'Oficio',
		'SIGAOficio',
		'FOficio',
		'FRecibido',
		'FVencimiento',
		'idsecretaria',
		'idunidad'
	];

	public function oficios_a()
	{
		return $this->belongsTo(OficiosA::class, 'idOficio');
	}

	public function cat_secretaria()
	{
		return $this->belongsTo(CatSecretaria::class, 'idsecretaria');
	}

	public function cat_unidade()
	{
		return $this->belongsTo(CatUnidade::class, 'idunidad');
	}
}

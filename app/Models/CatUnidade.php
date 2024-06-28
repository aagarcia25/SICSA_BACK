<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatUnidade
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string $idSecretaria
 * @property string|null $Descripcion
 * 
 * @property CatSecretaria $cat_secretaria
 * @property Collection|OficiosContestacion[] $oficios_contestacions
 *
 * @package App\Models
 */
class CatUnidade extends Model
{
	protected $table = 'cat_unidades';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	protected $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'idSecretaria',
		'Descripcion'
	];

	public function cat_secretaria()
	{
		return $this->belongsTo(CatSecretaria::class, 'idSecretaria');
	}

	public function oficios_contestacions()
	{
		return $this->hasMany(OficiosContestacion::class, 'idunidad');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cfoliosfile
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $idfolio
 * @property string|null $Route
 * @property string|null $Nombre
 * 
 * @property Cfolio|null $cfolio
 *
 * @package App\Models
 */
class Cfoliosfile extends Model
{
	protected $table = 'cfoliosfiles';
	public $incrementing = false;
	public $timestamps = false;

	public $casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime'
	];

	public $fillable = [
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'idfolio',
		'Route',
		'Nombre'
	];

	public function cfolio()
	{
		return $this->belongsTo(Cfolio::class, 'idfolio');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocsExtra
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string|null $Oficio
 * @property Carbon|null $Prorroga
 * @property Carbon|null $FVencimiento
 * @property string|null $idRelacion
 *
 * @package App\Models
 */
class DocsExtra extends Model
{
	protected $table = 'Docs_extras';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'Prorroga' => 'datetime',
		'FVencimiento' => 'datetime'
	];

	protected $fillable = [
		'id',
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Oficio',
		'Prorroga',
		'FVencimiento',
		'idRelacion'
	];
}

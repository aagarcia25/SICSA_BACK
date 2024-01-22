<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatPersonal
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property string $Empleado
 * @property string $Nombre
 * @property string $Puesto
 * @property string $RFC
 * @property string $CURP
 * @property string $CorreoElectronico
 * @property string $Telefono
 *
 * @package App\Models
 */
class CatPersonal extends Model
{
	public $table = 'Cat_Personal';
	public $incrementing = false;
	public $timestamps = false;
    public $_keyType = 'string';
    public $_primaryKey = 'id';

	protected $_casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
	];

	protected $fillable = [
		'id',
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Empleado',
		'Nombre',
		'Puesto',
		'RFC',
		'CURP',
		'CorreoElectronico',
		'Telefono'
	];
}

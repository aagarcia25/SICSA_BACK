<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Cfolio
 * 
 * @property string $id
 * @property string $deleted
 * @property Carbon $UltimaActualizacion
 * @property Carbon $FechaCreacion
 * @property string $ModificadoPor
 * @property string $CreadoPor
 * @property int|null $Cancelado
 * @property Carbon|null $Fecha
 * @property string|null $Oficio
 * @property string|null $Solicita
 * @property Carbon|null $FechaEntrega
 * @property Carbon|null $FechaRecibido
 * @property string|null $Destinatario
 * @property string|null $Asunto
 * @property string|null $Tema
 * @property string|null $Observaciones
 * @property int|null $Nauditoria
 * @property int|null $Tipo
 * 
 * @property Collection|Cfoliosfile[] $cfoliosfiles
 *
 * @package App\Models
 */
class Cfolio extends Model
{
	protected $table = 'cfolios';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'UltimaActualizacion' => 'datetime',
		'FechaCreacion' => 'datetime',
		'Cancelado' => 'int',
		'Fecha' => 'datetime',
		'FechaEntrega' => 'datetime',
		'FechaRecibido' => 'datetime',
		//'Tipo' => 'int'
	];

	protected $fillable = [
		'id',
		'deleted',
		'UltimaActualizacion',
		'FechaCreacion',
		'ModificadoPor',
		'CreadoPor',
		'Cancelado',
		'Fecha',
		'Oficio',
		'Solicita',
		'FechaEntrega',
		'FechaRecibido',
		'Destinatario',
		'Asunto',
		'Tema',
		'Observaciones',
		'Nauditoria',
		'Tipo',
		'Cargo'
	];

	public function cfoliosfiles()
	{
		return $this->hasMany(Cfoliosfile::class, 'idfolio');
	}

	public function Cat_Destinatarios_Oficios()
	{
		return $this->belongsTo(CatDestinatariosOficio::class, 'Destinatario');
	}

	public function Cat_Personal()
	{
		return $this->belongsTo(CatPersonal::class, 'Solicita');
	}


	public function getDestinataria($searchTerm)
	{
		$response = DB::select(
			"SELECT id FROM SICSA.Cat_Destinatarios_Oficios cdf
        WHERE LOWER(TRIM(cdf.Titular)) LIKE LOWER(TRIM(:searchTerm))
        LIMIT 1",
			['searchTerm' => '%' . $searchTerm . '%']
		);

		return isset($response[0]) ? $response[0]->id : null;
	}

	public function getsolicitante($searchTerm)
	{
		$response = DB::select(
			"SELECT id FROM SICSA.Cat_Personal cdf
        WHERE LOWER(TRIM(cdf.Nombre)) LIKE LOWER(TRIM(:searchTerm))
        LIMIT 1",
			['searchTerm' => '%' . $searchTerm . '%']
		);

		return isset($response[0]) ? $response[0]->id : null;
	}
}

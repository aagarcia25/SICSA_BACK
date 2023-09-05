<?php

namespace App\Imports;

use App\Models\Accione;
use App\Models\Auditorium;
use App\Models\CatEstatusAccione;
use App\Models\CatTiposAccion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccioneImport extends Accione implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{

    public $userid;

    public function __construct($userid)
    {

        $this->userid = $userid;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['numero'] != null) {
            $OBJ1 = Auditorium::where('NAUDITORIA', intval($row['numero']))->first();
            $OBJ2 = CatEstatusAccione::where('Descripcion', $row['estatus_de_las_acciones'])->first();
            $OBJ3 = CatTiposAccion::where('Descripcion', $row['tipo_accion'])->first();
            return new Accione([
                'ModificadoPor' => $this->userid,
                'CreadoPor' => $this->userid,
                'anio' => $row['ano_cuenta_publica'],
                'idAuditoria' => $OBJ1->id,
                'idTipoAccion' => $OBJ3->id,
                'idEstatusAccion' => $OBJ2->id,
                'ClaveAccion' => $row['clave_accion'],
                'TextoAccion' => $row['texto_accion'],
                'accionSuperviviente' => $row['accion_superveniente'],
            ]);
        }

    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

}

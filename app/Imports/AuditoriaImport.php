<?php

namespace App\Imports;

use App\Models\Auditorium;
use App\Models\Accione;
use App\Models\CatModalidad;
use App\Models\CatEstatusAccione;
use App\Models\CatTiposAccion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AuditoriaImport extends Auditorium implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
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

        if(isset($row['id_modalidad'])){

             $idModalidadFromExcel = $row['id_modalidad'];

        $OBJ1 = CatModalidad::find($idModalidadFromExcel);

        if($OBJ1){
            return new Auditorium([
                'ModificadoPor' =>$this->userid,
                'CreadoPor' => $this->userid,
                

               
                'NAUDITORIA' => $row['numero_auditoria'],
                'Consecutivo' => $row['consecutivo'],
                'ActaInicio' => $row['acta_inicio'],
                'NombreAudoria' => $row['nombre_auditoria'],
                'Encargado' => $row['encargado'],
                'PersonalEncargado' => $row['personal_encargado'],
                'montoauditado' => $row['monto_auditado'],
                'universopesos' => $row['universo_pesos'],
                'muestrapesos' => $row['muestra_pesos'],
                'idModalidad' => $idModalidadFromExcel,

                // 'anio' => $row['ano_cuenta_publica'],
                // 'NombreAudoria' => $row['clave_accion'],
                // 'Encargado' => $row['texto_accion'],
                // 'PersonalEncargado' => $row['accion_superveniente'],

            ]);
        }

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

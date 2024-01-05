<?php

namespace App\Imports;

use App\Models\Auditorium;
use App\Models\Accione;
use App\Models\CatModalidad;
use App\Models\CatOrigenAuditorium;
use App\Models\CatAnio;
use App\Models\CatEstatusAuditorium;
use App\Models\CatTipo;
use App\Models\CatInicioAuditorium;
use App\Models\CatGrupoFuncional;
use App\Models\CatSector;
use App\Models\CatTiposAccion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class AuditoriaImport extends Auditorium implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, WithCalculatedFormulas
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
             $id_origen_auditoriaFromExcel = $row['id_origen_auditoria'];
             $id_estatusFromExcel = $row['id_estatus'];
             //$anioFromExcel = $row['id_anio'];
             $id_tipoFromExcel = $row['id_tipo'];
             $id_inicio_auditoriaFromExcel = $row['id_inicio_auditoria'];
             $id_grupo_funcionalFromExcel = $row['id_grupo_funcional'];
             $id_sectorFromExcel = $row['id_sector'];


        $OBJ1 = CatModalidad::find($idModalidadFromExcel);
        $OBJ2 = CatOrigenAuditorium::find($id_origen_auditoriaFromExcel);
        $OBJ3 = CatEstatusAuditorium::find($id_estatusFromExcel);
        //$OBJ4 = CatAnio::find($anioFromExcel);
        $OBJ3 = CatTipo::find($id_tipoFromExcel);
        $OBJ3 = CatInicioAuditorium::find($id_inicio_auditoriaFromExcel);
        $OBJ3 = CatGrupoFuncional::find($id_inicio_auditoriaFromExcel);
        $OBJ3 = CatSector::find($id_sectorFromExcel);



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
                'idcatorigenaud' => $id_origen_auditoriaFromExcel,
                'idEstatus' => $id_estatusFromExcel,
                //'anio' => $anioFromExcel,
                'idClasificacion' => $id_tipoFromExcel,
                'idInicioauditoria' => $id_inicio_auditoriaFromExcel,
                'idCatGrupoFuncional' => $id_grupo_funcionalFromExcel,
                'idCatSector' => $id_sectorFromExcel,



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

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
use App\Models\CatEntidadFiscalizada;
use App\Models\CatTiposAuditorium;
use App\Models\CatInforme;
use App\Models\CatUnidadAdminAuditora;
use App\Models\CatAreaAuditora;
use App\Models\CatRamo;
use App\Models\Municipio;
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
             $id_anioFromExcel = $row['anio'];

             $id_estatusFromExcel = $row['id_estatus'];
             $id_tipoFromExcel = $row['id_tipo'];
             $id_inicio_auditoriaFromExcel = $row['id_inicio_auditoria'];
             $id_grupo_funcionalFromExcel = $row['id_grupo_funcional'];
             $id_sectorFromExcel = $row['id_sector'];
             $id_entidad_fiscalizadaFromExcel = $row['id_entidad_fiscalizada'];
             $id_tipo_auditoriaFromExcel = $row['id_tipo_auditoria'];
             $id_entregaFromExcel = $row['id_entrega'];
             $id_unidad_administrativa_auditoraFromExcel = $row['id_unidad_administrativa_auditora'];
             $id_area_auditoraFromExcel = $row['id_area_auditora'];
             $id_ramosFromExcel = $row['id_ramos'];
             $id_municipioFromExcel = $row['id_municipio'];



        $OBJ1 = CatModalidad::find($idModalidadFromExcel);
        $OBJ2 = CatOrigenAuditorium::find($id_origen_auditoriaFromExcel);
        $OBJ3 = CatEstatusAuditorium::find($id_estatusFromExcel);
        $OBJ3 = CatTipo::find($id_tipoFromExcel);
        $OBJ3 = CatInicioAuditorium::find($id_inicio_auditoriaFromExcel);
        $OBJ3 = CatAnio::find($id_anioFromExcel);

        $OBJ3 = CatGrupoFuncional::find($id_inicio_auditoriaFromExcel);
        $OBJ3 = CatSector::find($id_sectorFromExcel);
        $OBJ3 = CatEntidadFiscalizada::find($id_entidad_fiscalizadaFromExcel);
        $OBJ3 = CatTiposAuditorium::find($id_tipo_auditoriaFromExcel);
        $OBJ3 = CatInforme::find($id_entregaFromExcel);
        $OBJ3 = CatUnidadAdminAuditora::find($id_unidad_administrativa_auditoraFromExcel);
        $OBJ3 = CatAreaAuditora::find($id_area_auditoraFromExcel);
        $OBJ3 = CatRamo::find($id_ramosFromExcel);
        $OBJ3 = Municipio::find($id_municipioFromExcel);




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
                'anio' => $id_anioFromExcel,

                'idEstatus' => $id_estatusFromExcel,
                'idClasificacion' => $id_tipoFromExcel,
                'idInicioauditoria' => $id_inicio_auditoriaFromExcel,
                'idCatGrupoFuncional' => $id_grupo_funcionalFromExcel,
                'idCatSector' => $id_sectorFromExcel,
                'idCatEntidadFiscalizada' => $id_entidad_fiscalizadaFromExcel,
                'idTipoAuditoria' => $id_tipo_auditoriaFromExcel,
                'idCatInforme' => $id_entregaFromExcel,
                'idUnidadAdm' => $id_unidad_administrativa_auditoraFromExcel,
                'idAreaAdm' => $id_area_auditoraFromExcel,
                'idRamo' => $id_ramosFromExcel,
                'idmunicipio' => $id_municipioFromExcel,
                'FolioSIGA' => $row['folio_siga'],





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

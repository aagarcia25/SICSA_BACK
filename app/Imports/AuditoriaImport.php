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

        if(isset($row['id_entidad_fiscalizada'])){


             
            $idModalidadFromExcel = isset($row['id_modalidad']) ? $row['id_modalidad'] : null;
            $id_origen_auditoriaFromExcel = isset($row['id_origen_auditoria']) ? $row['id_origen_auditoria'] : null;
            $id_anioFromExcel = isset($row['anio']) ? $row['anio'] : null;
            $id_estatusFromExcel = isset($row['id_estatus']) ? $row['id_estatus'] : null;
            $id_tipoFromExcel = isset($row['id_tipo']) ? $row['id_tipo'] : null;
            
            $id_inicio_auditoriaFromExcel = isset($row['id_inicio_auditoria']) ? $row['id_inicio_auditoria'] : null;
            $id_grupo_funcionalFromExcel = isset($row['id_grupo_funcional']) ? $row['id_grupo_funcional'] : null;
            $id_sectorFromExcel = isset($row['id_sector']) ? $row['id_sector'] : null;
            $id_entidad_fiscalizadaFromExcel = isset($row['id_entidad_fiscalizada']) ? $row['id_entidad_fiscalizada'] : null;
            
            $id_tipo_auditoriaFromExcel = isset($row['id_tipo_auditoria']) ? $row['id_tipo_auditoria'] : null;
            $id_entregaFromExcel = isset($row['id_entrega']) ? $row['id_entrega'] : null;
            $id_unidad_administrativa_auditoraFromExcel = isset($row['id_unidad_administrativa_auditora']) ? $row['id_unidad_administrativa_auditora'] : null;
            
            $id_area_auditoraFromExcel = isset($row['id_area_auditora']) ? $row['id_area_auditora'] : null;
            $id_ramosFromExcel = isset($row['id_ramos']) ? $row['id_ramos'] : null;
            $id_municipioFromExcel = isset($row['id_municipio']) ? $row['id_municipio'] : null;
            



        $OBJ1 = CatModalidad::find($idModalidadFromExcel); 
        $OBJ2 = CatOrigenAuditorium::find($id_origen_auditoriaFromExcel);
        $OBJ3 = CatEstatusAuditorium::find($id_estatusFromExcel);
        $OBJ4 = CatTipo::find($id_tipoFromExcel);
        $OBJ5 = CatInicioAuditorium::find($id_inicio_auditoriaFromExcel);
        $OBJ6 = CatAnio::find($id_anioFromExcel);

        $OBJ7 = CatGrupoFuncional::find($id_inicio_auditoriaFromExcel);
        $OBJ8 = CatSector::find($id_sectorFromExcel);
        $OBJ9 = CatEntidadFiscalizada::find($id_entidad_fiscalizadaFromExcel);
        $OBJ10 = CatTiposAuditorium::find($id_tipo_auditoriaFromExcel);
        $OBJ11 = CatInforme::find($id_entregaFromExcel);
        $OBJ12 = CatUnidadAdminAuditora::find($id_unidad_administrativa_auditoraFromExcel);
        $OBJ13 = CatAreaAuditora::find($id_area_auditoraFromExcel);
        $OBJ14 = CatRamo::find($id_ramosFromExcel);
        $OBJ15 = Municipio::find($id_municipioFromExcel);




        if($OBJ9){

            
            return new Auditorium([
                
                'ModificadoPor' =>$this->userid,
                'CreadoPor' => $this->userid,
                

               
                'NAUDITORIA' => $row['numero_auditoria'] ?? null ,
                'Consecutivo' => $row['consecutivo'] ?? null ,
                'ActaInicio' => $row['acta_inicio'] ?? null ,
                'NombreAudoria' => $row['nombre_auditoria'] ?? null ,
                'Encargado' => $row['encargado'] ?? null ,
                'PersonalEncargado' => $row['personal_encargado'] ?? null ,
                'montoauditado' => $row['monto_auditado'] ?? null ,
                'universopesos' => $row['universo_pesos'] ?? null ,
                'muestrapesos' => $row['muestra_pesos'] ?? null ,
                'FolioSIGA' => $row['folio_siga'] ?? null ,

                'idModalidad' => $idModalidadFromExcel == "#N/A" ? null: $idModalidadFromExcel,
                'idcatorigenaud' => $id_origen_auditoriaFromExcel == "#N/A" ? null: $id_origen_auditoriaFromExcel,
                'anio' =>  $id_anioFromExcel == "#N/A" ? null: $id_anioFromExcel,
                //is_numeric($id_anioFromExcel) ? intval($id_anioFromExcel) : null,

              
                'idEstatus' => $id_estatusFromExcel == "#N/A" ? null: $id_estatusFromExcel,
                'idClasificacion' => $id_tipoFromExcel == "#N/A" ? null: $id_tipoFromExcel,
                'idInicioauditoria' => $id_inicio_auditoriaFromExcel == "#N/A" ? null: $id_inicio_auditoriaFromExcel,
                'idCatGrupoFuncional' => $id_grupo_funcionalFromExcel == "#N/A" ? null: $id_grupo_funcionalFromExcel,
                'idCatSector' => $id_sectorFromExcel == "#N/A" ? null: $id_sectorFromExcel,
                'idCatEntidadFiscalizada' => $id_entidad_fiscalizadaFromExcel == "#N/A" ? null: $id_entidad_fiscalizadaFromExcel,
                'idTipoAuditoria' => $id_tipo_auditoriaFromExcel == "#N/A" ? null: $id_tipo_auditoriaFromExcel,
                'idCatInforme' => $id_entregaFromExcel == "#N/A" ? null: $id_entregaFromExcel,
                'idUnidadAdm' => $id_unidad_administrativa_auditoraFromExcel == "#N/A" ? null: $id_unidad_administrativa_auditoraFromExcel,
                'idAreaAdm' => $id_area_auditoraFromExcel == "#N/A" ? null: $id_area_auditoraFromExcel,
                'idRamo' => $id_ramosFromExcel == "#N/A" ? null: $id_ramosFromExcel,
                'idmunicipio' => $id_municipioFromExcel == "#N/A" ? null: $id_municipioFromExcel,
                

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

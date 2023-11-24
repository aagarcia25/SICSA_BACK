<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectController extends Controller
{
    public function SelectIndex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        try {

            $type = $request->NUMOPERACION;
            $query = "";

            if ($type == 1) {
                $query = "SELECT CONVERT(anio, CHAR) value , anio label FROM SICSA.Cat_Anios";
            } elseif ($type == 2) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Entidad_Fiscalizada WHERE DELETED=0";
            } elseif ($type == 3) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Estatus_Acciones WHERE DELETED=0";
            } elseif ($type == 4) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Grupo_Funcional WHERE DELETED=0";
            } elseif ($type == 5) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Informes WHERE DELETED=0";
            } elseif ($type == 6) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Origen_Auditoria WHERE DELETED=0";
            } elseif ($type == 7) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Sector WHERE DELETED=0";
            } elseif ($type == 8) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Tipos_Accion WHERE DELETED=0";
            } elseif ($type == 9) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Tipos_Auditoria WHERE DELETED=0";
            } elseif ($type == 10) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Unidad_Admin_Auditora WHERE DELETED=0";
            } elseif ($type == 11) {
                $query = "   SELECT 'DAF'       value ,'Dirección de Administración Financiera' label FROM DUAL
                             UNION ALL
                             SELECT 'DAMOP'     value ,'Dirección de Atención a Municipios y Organismos Paraestatales' label FROM DUAL
                             UNION ALL
                             SELECT 'DPCP'	    value ,'Dirección de Presupuesto y Control Presupuestal'  label FROM DUAL
                             UNION ALL
                             SELECT 'DCCP'	    value ,'Dirección de Contabilidad y Cuenta Pública' label FROM DUAL
                             UNION ALL
                             SELECT 'CPH'	    value ,'Coordinación de Planeación Hacendaria' label FROM DUAL
                             UNION ALL
                             SELECT 'PF'	       value ,'Procuraduría Fiscal' label FROM DUAL
                             UNION ALL
                             SELECT 'DDPYPF' value ,'Dirección de Deuda Pública y Planeación Financiera' label FROM DUAL
                             UNION ALL
                             SELECT 'CGA'       value ,'Coordinación General Administrativa' label FROM DUAL";
            } elseif ($type == 12) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Modalidad WHERE DELETED=0";

            } elseif ($type == 13) {
                $query = "   SELECT
                    caa.id value,
                    CONCAT(caa.Clave,' ',caa.Descripcion) label
                    FROM SICSA.cat_area_auditoras caa
                    where caa.deleted =0
                   ";
                $query = $query . " and caa.idCatUnidadAdmin='" . $request->P_ID . "'";
                $query = $query . "  order by caa.FechaCreacion desc";

            } elseif ($type == 14) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.cat_tipo WHERE DELETED=0";
            } elseif ($type == 15) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.cat_ramo WHERE DELETED=0";
            } elseif ($type == 16) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.cat_inicio_auditoria WHERE DELETED=0";
            } elseif ($type == 17) {
                $query = "SELECT id  value , Nombre label FROM SICSA.Municipios WHERE DELETED=0";
            } elseif ($type == 18) {
                $query = "SELECT id  value , descripcion label FROM SICSA.cat_estatus_auditoria WHERE DELETED=0";
            } elseif ($type == 19) {
                $query = "  SELECT id  value , descripcion label FROM SICSA.cat_secretarias WHERE DELETED=0";
            } elseif ($type == 20) {
                $query = "  SELECT id  value , descripcion label FROM SICSA.cat_unidades WHERE DELETED=0";
                $query = $query . " and idSecretaria='" . $request->P_ID . "'";

            } elseif ($type == 21) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Origen_Auditoria WHERE DELETED=0";
                $query = $query . " and idOrigenAuditoria='" . $request->P_ID . "'";
            } elseif ($type == 42) {
                // //PROCESOS
                //DESAROLLO
                // $query="SELECT Id value, Menu label FROM TiCentral.Menus WHERE DELETED=0 AND IdApp ='8f515fb3-1f77-11ee-ac66-3cd92b4d9bf4'";
                //PRODUCCION
                $query = "SELECT Id value, Menu label FROM TiCentral.Menus WHERE DELETED=0 AND IdApp ='161206bc-405b-11ee-8002-d89d6776f970'";

            }elseif ($type == 23) {
                $query = "SELECT id  value , Nombre label FROM SICSA.Reportes";
            }elseif ($type == 24) {
                $id = $request->NUMOPERACION;

                $query = "SELECT id, Nombre, Auxiliar, Reporte  FROM SICSA.Reportes";
            }


            $response = DB::select($query);
        } catch (QueryException $e) {
            $SUCCESS = false;
            $NUMCODE = 1;
            $STRMESSAGE = $this->buscamsg($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            $SUCCESS = false;
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }
}

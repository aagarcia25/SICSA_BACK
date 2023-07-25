<?php

namespace App\Http\Controllers;

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
                $query = "SELECT anio value , anio label FROM SICSA.Cat_Anios";
            } else if ($type == 2) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Entidad_Fiscalizada WHERE DELETED=0";
            } else if ($type == 3) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Estatus_Acciones WHERE DELETED=0";
            } else if ($type == 4) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Grupo_Funcional WHERE DELETED=0";
            } else if ($type == 5) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Informes WHERE DELETED=0";
            } else if ($type == 6) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Origen_Auditoria WHERE DELETED=0";
            } else if ($type == 7) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Sector WHERE DELETED=0";
            } else if ($type == 8) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Tipos_Accion WHERE DELETED=0";
            } else if ($type == 9) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Tipos_Auditoria WHERE DELETED=0";
            } else if ($type == 10) {
                $query = "SELECT id  value , Descripcion label FROM SICSA.Cat_Unidad_Admin_Auditora WHERE DELETED=0";
            } else if ($type == 11) {
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
            }


            $response = DB::select($query);
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS
            ]
        );
    }
}

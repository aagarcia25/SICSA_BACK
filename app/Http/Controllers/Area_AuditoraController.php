<?php

namespace App\Http\Controllers;

use App\Models\CatAreaAuditora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Area_AuditoraController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function areaindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new CatAreaAuditora();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Clave = $request->Clave;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->idCatUnidadAdmin = $request->idCatUnidadAdmin;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = CatAreaAuditora::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Clave = $request->Clave;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->idCatUnidadAdmin = $request->idCatUnidadAdmin;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = CatAreaAuditora::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                      SELECT
                    caa.id,
                    caa.deleted,
                    caa.UltimaActualizacion,
                    caa.FechaCreacion,
                    getUserName(caa.ModificadoPor) ModificadoPor,
                    getUserName(caa.CreadoPor) CreadoPor,
                    caa.Clave,
                    caa.Descripcion,
                    cuaa.id AS iduaa,
                    cuaa.Descripcion cuaadesc
                    FROM SICSA.cat_area_auditoras caa
                    JOIN SICSA.Cat_Unidad_Admin_Auditora cuaa ON cuaa.id =caa.idCatUnidadAdmin
                    where caa.deleted =0
                    order by caa.FechaCreacion desc
                    ";
                $response = DB::select($query);
            }
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
            ]);

    }
}

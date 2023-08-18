<?php

namespace App\Http\Controllers;

use App\Models\Plandetrabajo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlandetrabajoController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function planindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Plandetrabajo();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Clave = $request->Clave;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->idCatUnidadAdmin = $request->idCatUnidadAdmin;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = Plandetrabajo::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Clave = $request->Clave;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->idCatUnidadAdmin = $request->idCatUnidadAdmin;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = Plandetrabajo::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                      SELECT
                        pt.id,
                        pt.UltimaActualizacion,
                        pt.FechaCreacion,
                        getUserName(pt.ModificadoPor) ModificadoPor,
                        getUserName(pt.CreadoPor) CreadoPor,
                        pt.start,
                        pt.end,
                        pt.name,
                        pt.type,
                        pt.progress,
                        pt.idauditoria
                       FROM SICSA.plandetrabajo pt
                       WHERE pt.deleted =0

                    ";

                $query = $query . " and pt.idauditoria='" . $request->P_IDAUDITORIA . "'";
                $query = $query . "  ORDER BY pt.FechaCreacion DESC";

                $response = DB::select($query);
            }
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
            ]);

    }
}

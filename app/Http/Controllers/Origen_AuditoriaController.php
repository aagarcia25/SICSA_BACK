<?php

namespace App\Http\Controllers;

use App\Models\CatOrigenAuditorium;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Origen_AuditoriaController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Origen_Auditoria_index(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new CatOrigenAuditorium();

                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Descripcion = $request->DESCRIPCION;
                $OBJ->idOrigenAuditoria = $request->IDORIGEN;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = CatOrigenAuditorium::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Descripcion = $request->DESCRIPCION;
                $OBJ->idOrigenAuditoria = $request->IDORIGEN;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = CatOrigenAuditorium::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                    SELECT
                    COA.id,
                    COA.deleted,
                    COA.UltimaActualizacion,
                    COA.FechaCreacion,
                    getUserName(COA.ModificadoPor) ModificadoPor,
                    getUserName(COA.CreadoPor) CreadoPor,
                    COA.Descripcion,
                    CT.id idtipo,
                    CT.Descripcion tipodescripcion
                    FROM SICSA.Cat_Origen_Auditoria   COA
                    INNER JOIN SICSA.cat_tipo CT ON COA.idOrigenAuditoria = CT.Id
                    where COA.deleted =0
                    order by COA.FechaCreacion desc
                    ";
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

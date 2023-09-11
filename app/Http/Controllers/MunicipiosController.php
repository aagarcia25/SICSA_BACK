<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipiosController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Municipios_index(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Municipio();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Nombre = $request->NOMBRE;
                $OBJ->ClaveEstado = $request->ClaveEstado;
                $OBJ->ClaveINEGI = $request->ClaveINEGI;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = Municipio::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Nombre = $request->NOMBRE;
                $OBJ->ClaveEstado = $request->ClaveEstado;
                $OBJ->ClaveINEGI = $request->ClaveINEGI;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = Municipio::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                SELECT
                    id,
                    deleted,
                    UltimaActualizacion,
                    FechaCreacion,
                    getUserName(ModificadoPor) modi,
                    getUserName(CreadoPor) creado,
                    Nombre,
                    ClaveEstado,
                    ClaveINEGI
                    FROM SICSA.Municipios
                    where deleted =0
                    order by FechaCreacion desc
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

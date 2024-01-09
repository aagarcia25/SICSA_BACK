<?php

namespace App\Http\Controllers;

use App\Models\CatModalidad;
use App\Models\Cfolio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FoliosController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */


    public function Foliosindex(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Cfolio();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 2) {

                $OBJ = Cfolio::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 3) {
                $OBJ = Cfolio::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 4) {

                $query = "
                           SELECT
                             cf.*,
                             Case 
                             when cf.Tipo ='CAF' then 'COORDINACION DE AUDITORIAS FEDERALES'
                             when cf.Tipo ='CAE' then 'COORDINACION DE AUDITORIAS ESTATALES'
                             END tipoau
                             FROM SICSA.cfolios cf
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
            ]
        );
    }
}

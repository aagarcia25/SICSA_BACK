<?php

namespace App\Http\Controllers;

use App\Models\Cfoliosfile;
use App\Traits\ApiDocTrait;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoliosFilesController extends Controller
{
    use ApiDocTrait;
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function FoliosFilesindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;
            $FOLIO = "";

            if ($type == 1) {

                $file = request()->file('FILE');
                $nombre = $file->getClientOriginalName();

                $data = $this->UploadFile($request->TOKEN, env('APP_DOC_ROUTE') . $FOLIO, $nombre, $file, 'TRUE');
                if ($data->SUCCESS) {
                    $OBJ = new Cfoliosfile();
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->idfile = $request->ID;
                    $OBJ->Route = strval($data->RESPONSE->RUTA);
                    $OBJ->Nombre = $nombre;
                    $OBJ->save();
                    $response = $OBJ;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } elseif ($type == 2) {

                $OBJ = Cfoliosfile::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Nombre = $request->NOMBRE;
                $OBJ->Descripcion = $request->DESCRIPCION;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 3) {

                $data = $this->DeleteFileByRoute($request->TOKEN, $request->P_ROUTE);
                if ($data->SUCCESS) {
                    $OBJ = Cfoliosfile::find($request->CHID);
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response = $OBJ;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } elseif ($type == 4) {

                $query = "SELECT
                    id,
                    deleted,
                    UltimaActualizacion,
                    FechaCreacion,
                    getUserName(ModificadoPor) modi,
                    getUserName(CreadoPor) creado,
                    idfolio,
                    Route,
                    Nombre
                    FROM cfoliosfiles
                    where deleted =0
                    ";
                $query = $query . " and    idfolio='" . $request->P_ID . "'";
                $response = DB::select($query);
            } elseif ($type == 5) {
                $data = $this->GetByRoute($request->TOKEN, $request->P_ROUTE, $request->P_NOMBRE);
                $response = $data->RESPONSE;
            } elseif ($type == 6) {
                $OBJ = Cfoliosfile::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Estatus = 1;
                $OBJ->save();
                $response = $OBJ;
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
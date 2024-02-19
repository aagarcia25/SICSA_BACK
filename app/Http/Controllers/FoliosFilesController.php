<?php

namespace App\Http\Controllers;

use App\Models\Cfoliosfile;
use App\Traits\ApiDocTrait;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

class FoliosFilesController extends Controller
{
    use ApiDocTrait;
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
    11._ ELIMINA REGISTROS SELECCIONADOS
     */

    public function FoliosFilesindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;
            $FOLIO = $request->FOLIO;

            if ($type == 1) {






                $file = request()->file('FILE');
                $nombre = $file->getClientOriginalName();

                $data = $this->UploadFile($request->TOKEN, env('APP_DOC_ROUTE') . $FOLIO, $nombre, $file, 'TRUE');
                if ($data->SUCCESS) {
                    $OBJ = new Cfoliosfile();
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->idfolio = $request->ID;
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

                /* $query = "SELECT
                    id,
                    deleted,
                    UltimaActualizacion,
                    FechaCreacion,
                    getUserName(ModificadoPor) modi,
                    getUserName(CreadoPor) creado,
                    idfolio,
                    Route,
                    Nombre,
                    Tipo
                    FROM cfoliosfiles
                    where deleted =0
                    ";
                $query = $query . " and    idfolio='" . $request->P_ID . "'";
                $response = DB::select($query);*/
            } elseif ($type == 5) {
                $data = $this->GetByRoute($request->TOKEN, $request->P_ROUTE, $request->P_NOMBRE);
                $response = $data->RESPONSE;
            } elseif ($type == 6) {
                $OBJ = Cfoliosfile::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Estatus = 1;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 9) {

                $data = $this->CreateDirectorio($request->TOKEN, env('APP_DOC_ROUTE') . $request->FOLIO . '/' . $request->ROUTE);
                if ($data->SUCCESS) {
                    $response = $data->RESPONSE;
                    // $OBJ = new Cfoliosfile();
                    // $OBJ->ModificadoPor = $request->CHUSER;
                    // $OBJ->CreadoPor = $request->CHUSER;
                    // $OBJ->idfolio = $request->ID;
                    // $OBJ->Route = strval(str_replace('/mnt/HD/HD_a2/', '', $response));
                    // $OBJ->Nombre = $request->ROUTE;
                    // $OBJ->Tipo = 2;
                    // $OBJ->save();
                    //$response = $OBJ;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } elseif ($type == 10) {
                Log::info("Ruta: " . trim(env('APP_DOC_ROUTE') . $request->FOLIO));
                $data = $this->ListFileSimple($request->TOKEN, trim(env('APP_DOC_ROUTE') . $request->FOLIO));
                if ($data->SUCCESS) {
                    $response = $data->RESPONSE;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } else if ($type == 11) {
                $CHIDs = $request->input('CHIDs');
                $response = [];

                foreach ($CHIDs as $CHID) {
                    $OBJ = FileSub::find($CHID);

                    if ($OBJ) {
                        $OBJ->deleted = 1;
                        $OBJ->ModificadoPor = $request->CHUSER;
                        $OBJ->save();
                        $response[] = $OBJ;
                    }
                }
            } else if ($type == 12) {
                $data = $this->DeleteFileSimple($request->TOKEN, $request->FOLIO);
                if ($data->SUCCESS) {
                    $response = $data->RESPONSE;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } else if ($type == 13) {
                $data = $this->DeleteDirectorio($request->TOKEN,  $request->FOLIO);
                if ($data->SUCCESS) {
                    $response = $data->RESPONSE;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
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

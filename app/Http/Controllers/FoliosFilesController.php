<?php

namespace App\Http\Controllers;

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
            } elseif ($type == 2) {
            } elseif ($type == 3) {
                $data = $this->DeleteFileByRoute($request->TOKEN, $request->P_ROUTE);
                if ($data->SUCCESS) {
                    $response = $data;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } elseif ($type == 4) {
            } elseif ($type == 5) {
                $data = $this->GetByRoute($request->TOKEN, $request->P_ROUTE);
                $response = $data->RESPONSE;
            } elseif ($type == 6) {
            } elseif ($type == 9) {
                $data = $this->CreateDirectorio($request->TOKEN, env('APP_DOC_ROUTE') . $request->FOLIO . '/' . $request->ROUTE);
                if ($data->SUCCESS) {
                    $response = $data->RESPONSE;
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
            } else if ($type == 12) {
                Log::info("Ruta: " . trim($request->FOLIO));
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
            } else if ($type == 14) {
                Log::info("Ruta Origen: " . trim(env('APP_DOC_ROUTE') . $request->ORIGEN));
                Log::info("Ruta Destino: " . trim(env('APP_DOC_ROUTE') . $request->DESTINO));
                $data = $this->moverArchivos($request->TOKEN, trim(env('APP_DOC_ROUTE') . $request->ORIGEN), trim(env('APP_DOC_ROUTE') . $request->DESTINO));
                if ($data->SUCCESS) {
                    $response = $data->RESPONSE;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } else if ($type == 15) {
                Log::info("Ruta Origen: " . trim(env('APP_DOC_ROUTE') . $request->ORIGEN));
                Log::info("Ruta Destino: " . trim(env('APP_DOC_ROUTE') . $request->DESTINO));
                $data = $this->VerificaMueveArchivos($request->TOKEN, trim(env('APP_DOC_ROUTE') . $request->ORIGEN), trim(env('APP_DOC_ROUTE') . $request->DESTINO));
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

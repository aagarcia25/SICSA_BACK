<?php

namespace App\Http\Controllers;

use App\Models\Accione;
use Illuminate\Database\QueryException;
use App\Models\Auditorium;
use App\Models\CContestacionArea;
use App\Models\CNotificacionArea;
use App\Models\File;
use App\Models\OficiosA;
use App\Traits\ApiDocTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{
    use ApiDocTrait;
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Filesindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;
            $FOLIO = "";

            if ($request->TIPO == 1) {
                //   ES AUDITORIA
                $OBJ = Auditorium::find($request->ID);
                $FOLIO = $OBJ->NAUDITORIA;
            } elseif ($request->TIPO == 2) {
                //  ES NOTIFICACION
                $OBJ = CNotificacionArea::find($request->ID);
                $FOLIO = $OBJ->auditorium->NAUDITORIA . "/" . $OBJ->Oficio;
            } elseif ($request->TIPO == 3) {
                // ES CONTESTACION
                $OBJ = CContestacionArea::find($request->ID);
                $NOTIFICACION = $OBJ->c_notificacion_area;
                $FOLIO = $NOTIFICACION->auditorium->NAUDITORIA . "/" . $NOTIFICACION->Oficio . "/" . $OBJ->Oficio;
            } elseif ($request->TIPO == 4) {
                $OBJ = OficiosA::find($request->ID);
                $FOLIO = $OBJ->auditorium->NAUDITORIA . "/" . $OBJ->Oficio;
            } elseif ($request->TIPO == 5) {
                $OBJ = Accione::find($request->ID);
                $FOLIO = $OBJ->auditorium->NAUDITORIA . "/" . $OBJ->ClaveAccion;
            }

            if ($type == 1) {

                $file = request()->file('FILE');
                $nombre = $file->getClientOriginalName();
                $data = $this->UploadFile($request->TOKEN, env('APP_DOC_ROUTE') . $FOLIO, $nombre, $file, 'TRUE');
                if ($data->SUCCESS) {
                    $OBJ = new File();
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->idowner = $request->ID;
                    $OBJ->Route = strval($data->RESPONSE->RUTA);
                    $OBJ->Nombre = $nombre;
                    $OBJ->save();
                    $response = $OBJ;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }

            } elseif ($type == 2) {

                $OBJ = File::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Nombre = $request->NOMBRE;
                $OBJ->Descripcion = $request->DESCRIPCION;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {

                $data = $this->DeleteFileByRoute($request->TOKEN, $request->P_ROUTE);
                if ($data->SUCCESS) {
                    $OBJ = File::find($request->CHID);
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
                    idowner,
                    Route,
                    Nombre,
                    CASE
                    WHEN estatus =0 then 'Pendiente de Verificación'
                    when estatus =1 then 'Verificado'
						  ELSE 'Buscando Estatus....'
						  END  estatus
                    FROM files
                    where deleted =0
                    ";
                $query = $query . " and    idowner='" . $request->P_IDAUDITORIA . "'";
                $response = DB::select($query);

            } elseif ($type == 5) {
                $data = $this->GetByRoute($request->TOKEN, $request->P_ROUTE, $request->P_NOMBRE);
                $response = $data->RESPONSE;
            } elseif ($type == 6) {
                $OBJ = File::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Estatus = 1;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 7) {
                $query = "SELECT
                         fl.id,
                         fl.FechaCreacion,
                         getUserName(fl.ModificadoPor) Nombre,
                        CASE
                          WHEN estatus =0 then 'Pendiente de Verificación'
                          when estatus =1 then 'Verificado'
						  ELSE 'Buscando Estatus....'
						  END  estatus
                        FROM SICSA.filesLog fl
                        where 1=1
                    ";
                $query = $query . " and    fl.idfile='" . $request->P_IDFILE . "'";
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

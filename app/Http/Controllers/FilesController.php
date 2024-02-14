<?php

namespace App\Http\Controllers;

use App\Models\Accione;
use App\Models\Auditorium;
use App\Models\CContestacionArea;
use App\Models\CNotificacionArea;
use App\Models\File;
use App\Models\OficiosA;
use App\Models\OrganoC;
use App\Models\OrganoR;
use App\Traits\ApiDocTrait;
use Exception;
use Illuminate\Database\QueryException;
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
        $cat = "";

        try {
            $type = $request->NUMOPERACION;
            $FOLIO = "";
            $cat = $request->CAT;

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
            } elseif ($request->TIPO == 6) {
                $OBJ = OrganoC::find($request->ID);
                $FOLIO = $OBJ->auditorium->NAUDITORIA . "/" . $OBJ->Oficio;
            } elseif ($request->TIPO == 7) {
                $OBJ = OrganoR::find($request->ID);
                $FOLIO = $OBJ->auditorium->NAUDITORIA . "/" . $OBJ->Oficio;
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


                if ($cat == "Folios") {
                    //         $queryFolioFiles = " 
                    //     SELECT 
                    //     cff.id,
                    //     cff.deleted,
                    //     cff.UltimaActualizacion,
                    //     cff.FechaCreacion,
                    //     getUserName(cff.ModificadoPor) modi,
                    //     getUserName(cff.CreadoPor) creado,
                    //     oa.idAuditoria AS idowner,
                    //     cff.Route,
                    //     cff.Nombre,
                    //     'Buscando Estatus....'as estatus
                    //    FROM SICSA.cfoliosfiles cff
                    //    left JOIN SICSA.cfolios cf ON cff.idfolio=cf.id
                    //    left JOIN SICSA.OficiosA oa ON cf.Oficio=oa.Oficio
                    //    WHERE oa.id='". $request->P_IDAUDITORIA ."'";

                    //    $query = "(" . $query . ") UNION (" . $queryFolioFiles . ")";
                } elseif ($cat == "Notificacion") {
                    //         $queryFolioFiles = " 
                    //         SELECT 
                    //         cff.id,
                    //         cff.deleted,
                    //         cff.UltimaActualizacion,
                    //         cff.FechaCreacion,
                    //         getUserName(cff.ModificadoPor) modi,
                    //         getUserName(cff.CreadoPor) creado,
                    //         na.idAuditoria AS idowner,
                    //         cff.Route,
                    //         cff.Nombre,
                    //         'Buscando Estatus....'as estatus
                    //        FROM SICSA.cfoliosfiles cff
                    //        left JOIN SICSA.cfolios cf ON cff.idfolio=cf.id
                    //        left JOIN SICSA.C_Notificacion_area na ON cf.Oficio=na.Oficio
                    //    WHERE na.id='". $request->P_IDAUDITORIA ."'";

                    //    $query = "(" . $query . ") UNION (" . $queryFolioFiles . ")";
                } elseif ($cat == "Contestacion") {
                    //         $queryFolioFiles = " 
                    //         SELECT 
                    //         cff.id,
                    //         cff.deleted,
                    //         cff.UltimaActualizacion,
                    //         cff.FechaCreacion,
                    //         getUserName(cff.ModificadoPor) modi,
                    //         getUserName(cff.CreadoPor) creado,
                    //         na.idAuditoria AS idowner,
                    //         cff.Route,
                    //         cff.Nombre,
                    //         'Buscando Estatus....'as estatus
                    //        FROM SICSA.cfoliosfiles cff
                    //        left JOIN SICSA.cfolios cf ON cff.idfolio=cf.id
                    //        left JOIN SICSA.C_Notificacion_area na ON cf.Oficio=na.Oficio
                    //        left JOIN SICSA.C_Contestacion_area ca ON cf.Oficio=ca.Oficio
                    //    WHERE ca.id='". $request->P_IDAUDITORIA ."'";

                    //    $query = "(" . $query . ") UNION (" . $queryFolioFiles . ")";
                } elseif ($cat == "OrganoC") {
                    //         $queryFolioFiles = " 
                    //         SELECT 
                    //         cff.id,
                    //         cff.deleted,
                    //         cff.UltimaActualizacion,
                    //         cff.FechaCreacion,
                    //         getUserName(cff.ModificadoPor) modi,
                    //         getUserName(cff.CreadoPor) creado,
                    //         oc.idAuditoria AS idowner,
                    //         cff.Route,
                    //         cff.Nombre,
                    //         'Buscando Estatus....'as estatus
                    //        FROM SICSA.cfoliosfiles cff
                    //        left JOIN SICSA.cfolios cf ON cff.idfolio=cf.id
                    //        left JOIN SICSA.Organo_C oc ON cf.Oficio=oc.Oficio
                    //    WHERE oc.id='". $request->P_IDAUDITORIA ."'";

                    //    $query = "(" . $query . ") UNION (" . $queryFolioFiles . ")";
                } elseif ($cat == "OrganoR") {
                    //         $queryFolioFiles = " 
                    //         SELECT 
                    //         cff.id,
                    //         cff.deleted,
                    //         cff.UltimaActualizacion,
                    //         cff.FechaCreacion,
                    //         getUserName(cff.ModificadoPor) modi,
                    //         getUserName(cff.CreadoPor) creado, 
                    //         oc.idAuditoria AS idowner,
                    //         cff.Route,
                    //         cff.Nombre,
                    //         'Buscando Estatus....'as estatus
                    //        FROM SICSA.cfoliosfiles cff
                    //        left JOIN SICSA.cfolios cf ON cff.idfolio=cf.id
                    //        left JOIN SICSA.Organo_C oc ON cf.Oficio=oc.Oficio
                    //        left JOIN SICSA.Organo_R cor ON cf.Oficio=cor.Oficio
                    //    WHERE cor.id='". $request->P_IDAUDITORIA ."'";

                    //    $query = "(" . $query . ") UNION (" . $queryFolioFiles . ")";
                }

                $response = DB::select($query);
                //  DB::select($combinedQuery);

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
            } elseif ($type == 8) {
                $OBJ = File::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Estatus = 0;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 9) {

                $data = $this->CreateDirectorio($request->TOKEN, env('APP_DOC_ROUTE') . $request->FOLIO . '/' . $request->ROUTE);
                if ($data->SUCCESS) {
                    $response = $data->RESPONSE;
                } else {
                    throw new Exception($data->STRMESSAGE);
                }
            } elseif ($type == 10) {
                $data = $this->ListFileSimple($request->TOKEN, env('APP_DOC_ROUTE') . $request->FOLIO);
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

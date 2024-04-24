<?php

namespace App\Http\Controllers;

use App\Models\OficiosContestacion;
use App\Models\OficiosA;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\File;



class OficiosContestacionController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
         9._ ELIMINA REGISTROS SELECCIONADOS

        */

        public function OficiosContestacon_index(Request $request)
        {

            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";
            $id = $this->uuidretrun();

            try{
                $type = $request->NUMOPERACION;

                if ($type == 1){
                    $OBJ = new OficiosContestacion();
                    $OBJ->id = $id;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->Prorroga = $request->Prorroga;
                    $OBJ->idOficio = $request->idOficio;
                    $OBJ->Oficio = $request->Oficio;
                    $OBJ->SIGAOficio = $request->SIGAOficio;
                    $OBJ->FOficio = $request->FOficio;
                    $OBJ->FRecibido = $request->FRecibido;
                    $OBJ->FVencimiento = $request->FVencimiento;
                    $OBJ->idsecretaria = $request->idsecretaria;
                    $OBJ->idunidad = $request->idunidad;
                    $OBJ->save();
                    $response = $OBJ;
                }elseif ($type == 2){
                    $OBJ = OficiosContestacion::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->Prorroga = $request->Prorroga;
                    $OBJ->idOficio = $request->idOficio;
                    $OBJ->Oficio = $request->Oficio;
                    $OBJ->SIGAOficio = $request->SIGAOficio;
                    $OBJ->FOficio = $request->FOficio;
                    $OBJ->FRecibido = $request->FRecibido;
                    $OBJ->FVencimiento = $request->FVencimiento;
                    $OBJ->idsecretaria = $request->idsecretaria;
                    $OBJ->idunidad = $request->idunidad;
                    $OBJ->save();
                    $response = $OBJ;
                }elseif ($type == 3) {
                    $OBJ = OficiosContestacion::find($request->CHID);
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response = $OBJ;
                }elseif ($type == 4) {

                    $query = "
                    SELECT 
ofc.id,
ofc.deleted,
ofc.UltimaActualizacion,
ofc.FechaCreacion,
getUserName(ofc.ModificadoPor) modi,
getUserName(ofc.CreadoPor) creado,
ofc.idOficio,
aud.NAUDITORIA,
ofc.SIGAOficio,
TO_CHAR(ofc.Prorroga, 'DD/MM/YYYY') as Prorroga,
TO_CHAR(ofc.FOficio, 'DD/MM/YYYY') as FOficio,
TO_CHAR(ofc.FRecibido, 'DD/MM/YYYY') as FRecibido,
TO_CHAR(ofc.FVencimiento, 'DD/MM/YYYY') as FVencimiento,
sec.Descripcion secDescripcion,
sec.id secid,
cu.Descripcion cuDescripcion,
cu.id cuid,
ofc.Oficio

FROM SICSA.Oficios_Contestacion ofc
INNER JOIN SICSA.OficiosA oa ON ofc.idOficio = oa.id
INNER JOIN SICSA.auditoria aud ON oa.idAuditoria = aud.id
INNER JOIN SICSA.cat_secretarias sec ON ofc.idsecretaria = sec.id
INNER JOIN SICSA.cat_unidades cu ON ofc.idunidad = cu.id

WHERE ofc.deleted=0
                        ";
                    $query = $query . " and    idOficio='" . $request->P_IDNOTIFICACION . "'
                    order by Oficio asc";
                    $response = DB::select($query);
                }else if ($type == 9) {
                    $CHIDs = $request->input('CHIDs');
                    $response = [];
    
                    foreach ($CHIDs as $CHID) {
                        $OBJ = OficiosContestacion::find($CHID);
    
                        if ($OBJ) {
                            $OBJ->deleted = 1;
                            $OBJ->ModificadoPor = $request->CHUSER;
                            $OBJ->save();
                            $response[] = $OBJ;
                        }
                    }
                }

            }catch (QueryException $e) {
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

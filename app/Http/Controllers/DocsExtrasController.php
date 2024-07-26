<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\File;
use App\Models\OficiosContestacion;
use App\Models\DocsExtra;
use Illuminate\Database\QueryException;

class DocsExtrasController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
         9._ ELIMINA REGISTROS SELECCIONADOS

        */

        public function DocsExtras_index(Request $request)
        {

            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";
            $id = $this->uuidretrun();

            try{
                $type = $request->NUMOPERACION;

                if ($type == 1){
                    $OBJ = new DocsExtra();
                    $OBJ->id = $id;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->Oficio = $request->Oficio;
                    $OBJ->Prorroga = $request->Prorroga;
                    $OBJ->FVencimiento = $request->FVencimiento;
                    $OBJ->idRelacion = $request->idRelacion;
                    $OBJ->TipoDoc = $request->TipoDoc;
                    $OBJ->save();
                    $response = $OBJ;
                }elseif ($type == 2){
                    $OBJ = DocsExtra::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->Oficio = $request->Oficio;
                    $OBJ->Prorroga = $request->Prorroga;
                    $OBJ->FVencimiento = $request->FVencimiento;
                    $OBJ->idRelacion = $request->idRelacion;
                    $OBJ->TipoDoc = $request->TipoDoc;

                    $OBJ->save(); 
                    $response = $OBJ;
                }elseif ($type == 3) {
                    $OBJ = DocsExtra::find($request->CHID);
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response = $OBJ;
                }elseif ($type == 4) {

                    $query = "
                 SELECT 
                    doc.id,
                    doc.deleted,
                    doc.UltimaActualizacion,
                    doc.FechaCreacion,
                    doc.Oficio,
                    doc.idRelacion,
                    doc.TipoDoc,
                    getUserName(doc.ModificadoPor) modi,
                    getUserName(doc.CreadoPor) creado,
                    TO_CHAR(doc.Prorroga, 'DD/MM/YYYY') as Prorroga,
                    TO_CHAR(doc.FVencimiento, 'DD/MM/YYYY') as FVencimiento
                  
                    
                    FROM SICSA.Docs_extras doc

                    WHERE doc.deleted=0
                        ";
                    $query = $query . " and    doc.idRelacion='" . $request->P_IDNOTIFICACION . "'
                    order by Oficio asc";
                    $response = DB::select($query);
                }else if ($type == 9) {
                    $CHIDs = $request->input('CHIDs');
                    $response = [];
    
                    foreach ($CHIDs as $CHID) {
                        $OBJ = DocsExtra::find($CHID);
    
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

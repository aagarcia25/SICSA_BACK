<?php

namespace App\Http\Controllers;

use App\Models\Accione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccionesController extends Controller
{
     /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
        */

        public function Acciones_index(Request $request)  {
        
            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";


            try {
                $type = $request->NUMOPERACION;
    
                if ($type == 1) {
                    $OBJ = new Accione();
                 
                    $OBJ->ModificadoPor= $request->CHUSER;
                    $OBJ->CreadoPor= $request->CHUSER;
                    $OBJ->anio= $request->anio;
                    $OBJ->idTipoAccion= $request->idTipoAccion;
                    $OBJ->idAuditoria= $request->idAuditoria;
                    $OBJ->idEstatusAccion= $request->idEstatusAccion;
                    $OBJ->ClaveAccion= $request->ClaveAccion;
                    $OBJ->TextoAccion= $request->TextoAccion;
                    // $OBJ->NAUDITORIA= $request->NAUDITORIA;
                    $OBJ->Valor= $request->Valor;
                
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 2) {
    
                    $OBJ = Accione::find($request->CHID);
                    $OBJ->ModificadoPor= $request->CHUSER;
                    $OBJ->CreadoPor= $request->CHUSER;
                    $OBJ->anio= $request->anio;
                    $OBJ->idTipoAccion= $request->idTipoAccion;
                    $OBJ->idAuditoria= $request->idAuditoria;
                    $OBJ->idEstatusAccion= $request->idEstatusAccion;
                    $OBJ->ClaveAccion= $request->ClaveAccion;
                    $OBJ->TextoAccion= $request->TextoAccion;
                    $OBJ->Valor= $request->Valor;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 3) {
                    $OBJ = Accione::find($request->CHID);
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 4) {


                    $query = "
                    SELECT
                      accion.id,
                      accion.deleted,
                      accion.UltimaActualizacion,
                      accion.FechaCreacion,
                      getUserName(accion.ModificadoPor) modi,
                      getUserName(accion.CreadoPor) creado,
                      accion.anio,
                      accion.idTipoAccion,
                      accion.idAuditoria,
                      accion.idEstatusAccion,
                      accion.ClaveAccion,
                      accion.TextoAccion,
                      accion.Valor ,
                      aud.NAUDITORIA,
                      cta.Descripcion AS DescripcionTipoDeAccion,
                      cea.Descripcion AS DescripcionEstatusAccion

                      FROM SICSA.Acciones accion
                      LEFT JOIN SICSA.Auditoria aud ON accion.idAuditoria = aud.id
                      LEFT JOIN SICSA.Cat_Tipos_Accion cta ON accion.idTipoAccion = cta.id
                      LEFT JOIN SICSA.Cat_Estatus_Acciones cea ON accion.idEstatusAccion = cea.id  
                    where accion.deleted =0 
                      ";

                    $query =  $query . " and accion.idAuditoria='" . $request->P_IDAUDITORIA  . "'";  
                    $response = DB::select($query);

                }
            } catch (\Exception $e) {
                $SUCCESS = false;
                $NUMCODE = 1;
                $STRMESSAGE = $e->getMessage();
            }
           
    
    
    
            return response()->json(
                [
                 'NUMCODE' =>$NUMCODE,
                 'STRMESSAGE' =>$STRMESSAGE,
                 'RESPONSE' => $response,
                 'SUCCESS' => $SUCCESS,
                 ] );
    
     }
}

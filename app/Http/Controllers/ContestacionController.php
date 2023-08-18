<?php

namespace App\Http\Controllers;

use App\Models\CContestacionArea;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContestacionController extends Controller
{
      /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
        */

        public function Contestacionindex(Request $request)  {
        
            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";


            try {
                $type = $request->NUMOPERACION;
    
                if ($type == 1) {
                    $OBJ = new CContestacionArea();

                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->idNotificacion= $request->idNotificacion;
                    $OBJ->Dependencia= $request->Dependencia;
                    $OBJ->Prorroga= $request->Prorroga;
                    $OBJ->Oficio= $request->Oficio;
                    $OBJ->SIGAOficio= $request->SIGAOficio;     
                    $OBJ->FOficio= $request->FOficio; 
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 2) {
    
                    $OBJ = CContestacionArea::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->idNotificacion= $request->idNotificacion;
                    $OBJ->Dependencia= $request->Dependencia;
                    $OBJ->Prorroga= $request->Prorroga;
                    $OBJ->Oficio= $request->Oficio;
                    $OBJ->SIGAOficio= $request->SIGAOficio;     
                    $OBJ->FOficio= $request->FOficio; 
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 3) {
                    $OBJ = CContestacionArea::find($request->CHID);
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 4) {

                    $query = "SELECT 
                    id,
                    deleted,
                    UltimaActualizacion,
                    FechaCreacion,
                    getUserName(ModificadoPor) modi,
                    getUserName(CreadoPor) creado,
                    Dependencia,
                    Prorroga,
                    Oficio,
                    SIGAOficio,
                    FOficio
                    FROM SICSA.C_Contestacion_area
                    where deleted =0
                    ";
                    $query =  $query . " and    idNotificacion='" . $request->P_IDNOTIFICACION. "'";
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
                 'NUMCODE' =>$NUMCODE,
                 'STRMESSAGE' =>$STRMESSAGE,
                 'RESPONSE' => $response,
                 'SUCCESS' => $SUCCESS,
                 ] );
    
     }
}

<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
        /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
        */

        public function Auditoriaindex(Request $request)  {
        
            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";


            try {
                $type = $request->NUMOPERACION;
    
                if ($type == 1) {
                    $OBJ = new Auditorium();

                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->anio = $request->NOMBRE;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 2) {
    
                    $OBJ = Auditorium::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->Nombre = $request->NOMBRE;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 3) {
                    $OBJ = Auditorium::find($request->CHID);
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 4) {

                    $query = "
                    SELECT               
                    id,
                    deleted,
                    UltimaActualizacion,
                    FechaCreacion,
                    getUserName(ModificadoPor) modi,
                    getUserName(CreadoPor) creado,
                    Consecutivo,
                    FolioSIGA,
                    Encargado,
                    PersonalEncargado,
                    NAUDITORIA,
                    NombreAudoria,
                    ActaInicio
                    FROM SICSA.Auditoria   
                    where deleted =0 
                    order by Consecutivo asc
                    ";
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

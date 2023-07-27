<?php

namespace App\Http\Controllers;

use App\Models\CatTiposAccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiposAccionController extends Controller
{
      /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
        */

        public function TiposAccion_index(Request $request)  {
        
            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";


            try {
                $type = $request->NUMOPERACION;
    
                if ($type == 1) {
                    $OBJ = new CatTiposAccion();

                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->Abreviatura = $request->ABREVIATURA;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 2) {
    
                    $OBJ = CatTiposAccion::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->Abreviatura = $request->ABREVIATURA;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 3) {
                    $OBJ = CatTiposAccion::find($request->CHID);
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 4) {
                    $response = DB::table('Cat_Tipos_Accion')
                    ->where('deleted','=', 0)
                    ->orderBy('FechaCreacion', 'desc')
                    ->get();
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

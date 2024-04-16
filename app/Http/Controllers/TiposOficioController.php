<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatTiposOficio;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class TiposOficioController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
         5._ ELIMINA REGISTROS SELECCIONADOS
        */

        public function TipoOficio_index(Request $request)  {
        
            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";


            try {
                $type = $request->NUMOPERACION;
    
                if ($type == 1) {
                    $OBJ = new CatTiposOficio();

                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 2) {
    
                    $OBJ = CatTiposOficio::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 3) {
                    $OBJ = CatTiposOficio::find($request->CHID);
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
                    getUserName(ModificadoPor) ModificadoPor,
                    getUserName(CreadoPor) CreadoPor,
                    Descripcion
                    FROM SICSA.Cat_Tipos_Oficios
                    where deleted =0 
                    order by FechaCreacion desc
                    ";
                    $response = DB::select($query);

                }else if ($type == 5) {
                    $CHIDs = $request->input('CHIDs'); 
                    $response = [];
    
                    foreach ($CHIDs as $CHID) {
                    $OBJ = CatTiposOficio::find($CHID);
    
                        if ($OBJ) {
                        $OBJ->deleted = 1;
                        $OBJ->ModificadoPor = $request->CHUSER;
                        $OBJ->save();
                        $response[] = $OBJ;
                        }
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
                 'NUMCODE' =>$NUMCODE,
                 'STRMESSAGE' =>$STRMESSAGE,
                 'RESPONSE' => $response,
                 'SUCCESS' => $SUCCESS,
                 ] );
    
     }
}

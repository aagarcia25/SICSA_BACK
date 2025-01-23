<?php

namespace App\Http\Controllers;

use App\Models\CatEntidadFiscalizada;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Entidad_FiscalizadaController extends Controller
{
     /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
         5._ ELIMINA REGISTROS SELECCIONADOS
        */

        public function Entidad_Fiscalizada_index(Request $request)  {
        
            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";


            try {
                $type = $request->NUMOPERACION;
    
                if ($type == 1) {
                    $OBJ = new CatEntidadFiscalizada();

                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor = $request->CHUSER;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 2) {
    
                    $OBJ = CatEntidadFiscalizada::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    //$OBJ->Nombre = $request->NOMBRE;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 3) {
                    $OBJ = CatEntidadFiscalizada::find($request->CHID);
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
                    FROM SICSA.Cat_Entidad_Fiscalizada   
                    where deleted =0 
                    order by Descripcion asc
                    ";
                    $response = DB::select($query);

                    // $response = DB::table('Cat_Entidad_Fiscalizada')
                    // ->where('deleted','=', 0)
                    // ->orderBy('FechaCreacion', 'desc')
                    // ->get();
                }else if ($type == 5) {
                    $CHIDs = $request->input('CHIDs'); 
                    $response = [];
    
                    foreach ($CHIDs as $CHID) {
                    $OBJ = CatEntidadFiscalizada::find($CHID);
    
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Models\CatUnidade;


class UnidadesController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
        1._ INSERTAR UN REGISTRO
        2._ ACTUALIZAR UN REGISTRO
        3._ ELIMINAR UN REGISTRO
        4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
        5._ ELIMINA REGISTROS SELECCIONADOS
       */

       public function Unidad_index(Request $request)  {
       
           $SUCCESS = true;
           $NUMCODE = 0;
           $STRMESSAGE = 'Exito';
           $response = "";


           try {
               $type = $request->NUMOPERACION;
   
               if ($type == 1) {
                   $OBJ = new CatUnidade();

                   $OBJ->ModificadoPor = $request->CHUSER;
                   $OBJ->CreadoPor = $request->CHUSER;
                   $OBJ->Descripcion = $request->DESCRIPCION;
                   $OBJ->idSecretaria = $request->idSecretaria;

                   $OBJ->save();
                   $response = $OBJ;
   
   
               } else if ($type == 2) {
   
                   $OBJ = CatUnidade::find($request->CHID);
                   $OBJ->ModificadoPor = $request->CHUSER;
                   //$OBJ->Nombre = $request->NOMBRE;
                   $OBJ->Descripcion = $request->DESCRIPCION;
                   $OBJ->idSecretaria = $request->idSecretaria;

                   $OBJ->save();
                   $response = $OBJ;
   
   
               } else if ($type == 3) {
                   $OBJ = CatUnidade::find($request->CHID);
                   $OBJ->deleted = 1;
                   $OBJ->ModificadoPor = $request->CHUSER;
                   $OBJ->save();
                   $response = $OBJ;
   
   
               } else if ($type == 4) {
                   $query = "
                   SELECT               
                   uni.id,
                   uni.deleted,
                   uni.UltimaActualizacion,
                   uni.FechaCreacion,
                   getUserName(uni.ModificadoPor) ModificadoPor,
                   getUserName(uni.CreadoPor) CreadoPor,
                   uni.idSecretaria,
                   uni.Descripcion uniDescripcion,
                   sec.id secid,
                   sec.Descripcion secDescripcion
                   FROM SICSA.cat_unidades uni  
				   LEFT JOIN SICSA.cat_secretarias sec ON uni.idSecretaria = sec.id 
                   where uni.deleted =0 
                   order by FechaCreacion desc
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
                   $OBJ = CatUnidade::find($CHID);
   
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

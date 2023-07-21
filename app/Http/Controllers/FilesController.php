<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use App\Models\CContestacionArea;
use App\Models\CNotificacionArea;
use Illuminate\Http\Request;

use App\Models\File;
use App\Traits\ApiDocTrait;
use Exception;
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

        public function Filesindex(Request $request)  {
        
            $SUCCESS = true;
            $NUMCODE = 0;
            $STRMESSAGE = 'Exito';
            $response = "";


            try {
                $type = $request->NUMOPERACION;
                $FOLIO ="";

               if($request->TIPO ==1){
                //   ES AUDITORIA
                $OBJ = Auditorium::find($request->ID);
                $FOLIO = $OBJ->NAUDITORIA;
               }else if($request->TIPO ==2){
                //  ES NOTIFICACION 
                $OBJ = CNotificacionArea::find($request->ID);
                $FOLIO = $OBJ->auditorium->NAUDITORIA."/".$OBJ->Oficio;
               }else if($request->TIPO ==3){
                // ES CONTESTACION
                $OBJ = CContestacionArea::find($request->ID);
                $NOTIFICACION =$OBJ->c_notificacion_area;
                $FOLIO = $NOTIFICACION->auditorium->NAUDITORIA."/".$NOTIFICACION->Oficio."/". $OBJ->Oficio;
               }


    
                if ($type == 1) {

                  
                   $file = request()->file('FILE');
                   $nombre = $file->getClientOriginalName();
                   $data =$this->UploadFile($request->TOKEN,env('APP_DOC_ROUTE'). $FOLIO,$nombre,$file,'TRUE') ;
                   if($data->SUCCESS){
                    $OBJ = new File();
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->CreadoPor     = $request->CHUSER;
                    $OBJ->idowner       = $request->ID;
                    $OBJ->Route         = strval($data->RESPONSE->RUTA);
                    $OBJ->Nombre        = $nombre;
                    $OBJ->save();
                    $response = $OBJ;
                   }else{
                    throw new Exception($data->STRMESSAGE);
                   }


                  
    
    
                } else if ($type == 2) {
    
                    $OBJ = File::find($request->CHID);
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->Nombre = $request->NOMBRE;
                    $OBJ->Descripcion = $request->DESCRIPCION;
                    $OBJ->save();
                    $response = $OBJ;
    
    
                } else if ($type == 3) {
                    $OBJ = File::find($request->CHID);
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
                    idowner,
                    Route,
                    Nombre
                    FROM Files
                    where deleted =0
                    ";
                    $query =  $query . " and    idowner='" . $request->P_IDAUDITORIA. "'";
                    $response = DB::select($query);
                   
                }else if ($type == 5){
                    $data =$this->GetByRoute($request->TOKEN,$request->P_ROUTE,$request->P_NOMBRE) ;
                    $response = $data->RESPONSE;
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

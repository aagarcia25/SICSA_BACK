<?php

namespace App\Http\Controllers;

use App\Models\PreguntasFrecuentes;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PreguntasFrecuentesController extends Controller
{
    //
    public function AdminAyudas(Request $request){
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;
            if ($type==1){
                $NuevoVideo = new PreguntasFrecuentes();
                $file = request()->file('VIDEO');
    
                $ruta=env('APP_DOC_ROUTE').'/VIDEOS/TUTORIALES/';
                if($file != null){
                    $nombre = $file->getClientOriginalName();
                    // $ruta=env('APP_DOC_ROUTE').'/PDRMYE_DEV/VIDEOS/TUTORIALES/'.$request->TIPO;
                    $data =$this->UploadFile($request->TOKEN,$ruta,$nombre,$file) ;
                    $response =  $data;
                    if($data->SUCCESS){
                        $NuevoVideo-> RutaVideo =   $data->RESPONSE->NOMBREIDENTIFICADOR;
                        $NuevoVideo-> ModificadoPor  =  $request->CHUSER;
                        $NuevoVideo-> CreadoPor        = $request->CHUSER;
                        $NuevoVideo-> idMenu        = $request->CHID;
                        $NuevoVideo-> NombreOriginalVideo  = $request->NAME;
                        $NuevoVideo-> Departamento  = $request->TIPO;
                      $response = $data;
                    }
                }
                $NuevoVideo->save();
            }
            if ($type==2){
                $nuevoGuiaRapida = new PreguntasFrecuentes();
                $file = request()->file('VIDEO');
            
                $ruta=env('APP_DOC_ROUTE').'/GUIAS/';
                if($file != null){
                    $nombre = $file->getClientOriginalName();
                    // $ruta=env('APP_DOC_ROUTE').'/PDRMYE_DEV/VIDEOS/TUTORIALES/'.$request->TIPO;
                    $data =$this->UploadFile($request->TOKEN,$ruta,$nombre,$file) ;
                    $response =  $data;
                    if($data->SUCCESS){
                        $nuevoGuiaRapida-> RutaGuia =   $data->RESPONSE->NOMBREIDENTIFICADOR;
                        $nuevoGuiaRapida-> Pregunta =   $request->PREGUNTA;
                        $nuevoGuiaRapida-> ModificadoPor  =  $request->CHUSER;
                        $nuevoGuiaRapida-> CreadoPor        = $request->CHUSER;
                        $nuevoGuiaRapida-> idMenu        = $request->CHID;
                        $nuevoGuiaRapida-> Departamento        = $request->TIPO;
            
                      $response = $data;
                    }
                }
                $nuevoGuiaRapida->save();
            }

            if ($type==3){
                $nuevoGuiaRapida = new PreguntasFrecuentes();
                    $nuevoGuiaRapida-> Pregunta =   $request->PREGUNTA;
                    $nuevoGuiaRapida-> Texto =   $request->RESPUESTA;
                    $nuevoGuiaRapida-> ModificadoPor  =  $request->CHUSER;
                    $nuevoGuiaRapida-> CreadoPor        = $request->CHUSER;
                    $nuevoGuiaRapida-> idMenu        = $request->CHID;
                    $nuevoGuiaRapida-> Departamento  = $request->TIPO;
                
                $nuevoGuiaRapida->save();
                $response = $nuevoGuiaRapida;
            }
 

            if ($type==4){

                if($request->CHID !=""){
                    $preguntas = DB::table('PreguntasFrecuentes')
                   ->join('RMenus', 'PreguntasFrecuentes.idMenu', '=', 'RMenus.id')
                   ->select('PreguntasFrecuentes.*','RMenus.Menu')
                   ->where('PreguntasFrecuentes.idMenu', $request->CHID)
                   ->where('PreguntasFrecuentes.deleted', '=', 0)
                   ->where('PreguntasFrecuentes.Texto', '!=', "")
                   ->get();   
                   $response = $preguntas;    
                   }
                   
                   else if ($request->CHID =="") {
                   $preguntas = DB::table('PreguntasFrecuentes')
                   ->join('RMenus', 'PreguntasFrecuentes.idMenu', '=', 'RMenus.id')
                   ->select('PreguntasFrecuentes.*','RMenus.Menu')
                   ->where('PreguntasFrecuentes.deleted', '=', 0)
                   ->where('PreguntasFrecuentes.Texto', '!=', "")
                   ->get(); 
                   $response = $preguntas; 
                   }

            }

            if ($type == 5) {
                $response = DB::select(DB::raw("
                 SELECT vt.RutaVideo, vt.NombreOriginalVideo
                 FROM PDRMYE.PreguntasFrecuentes vt
                 WHERE vt.deleted = 0 
                 AND vt.idMenu='".$request->CHID ."' AND vt.RutaVideo !=''
                 "));
             }
 
             if ($type == 6) {
                $response = DB::select(DB::raw("
                 SELECT *
                 FROM PDRMYE.PreguntasFrecuentes vt
                 WHERE vt.deleted = 0 
                "));
             }
     ///////// BUSQUEDA DE REGISTROS DE Pregunta SI ES ORG/MUN 
             if ($type == 7) {
                $preguntas =  PreguntasFrecuentes::select('id','Pregunta','Texto')
                ->where('idMenu', $request->CHID)
                ->where('deleted', '=', 0)
                ->where('Texto', '!=', "")
                ->where('Departamento', '=', $request->TIPO)
                ->get();

                $response = $preguntas;
             }
     ///////// BUSQUEDA DE REGISTROS DE RutaGuia SI ES ORG/MUN 
              if ($type == 8) {
                $preguntas =  PreguntasFrecuentes::select('id','Pregunta','RutaGuia')
                ->where('idMenu', $request->CHID)
                ->where('deleted', '=', 0)
                ->where('RutaGuia', '!=', "")
                ->where('Departamento', '=', $request->TIPO)
                ->get();   
                $response = $preguntas;
             }
      ///////// BUSQUEDA DE REGISTROS DE Pregunta SI ES ORG/MUN 

             if ($type == 9) {
                $preguntas =  PreguntasFrecuentes::select('id','NombreOriginalVideo','RutaVideo')
                ->where('idMenu', $request->CHID)
                ->where('deleted', '=', 0)
                ->where('RutaVideo', '!=', "")
                ->where('Departamento', '=', $request->TIPO)
                ->get();   
                $response = $preguntas;
             }


     ///////// BUSQUEDA DE REGISTROS DE Pregunta SI ES admin
               if ($type == 10) {
                $preguntas =  PreguntasFrecuentes::select('id','Pregunta','Texto')
                ->where('idMenu', $request->CHID)
                ->where('deleted', '=', 0)
                ->where('Texto', '!=', "")
                ->get();

                $response = $preguntas;
             }
     ///////// BUSQUEDA DE REGISTROS DE RutaGuia SI ES admin
              if ($type == 11) {
                if($request->CHID !=""){
                 $preguntas = DB::table('PreguntasFrecuentes')
                ->join('RMenus', 'PreguntasFrecuentes.idMenu', '=', 'RMenus.id')
                ->select('PreguntasFrecuentes.*','RMenus.Menu')
                ->where('PreguntasFrecuentes.idMenu', $request->CHID)
                ->where('PreguntasFrecuentes.deleted', '=', 0)
                ->where('PreguntasFrecuentes.RutaGuia', '!=', "")
                ->get();   
                $response = $preguntas;    
                }
                
                else if ($request->CHID =="") {
                $preguntas = DB::table('PreguntasFrecuentes')
                ->join('RMenus', 'PreguntasFrecuentes.idMenu', '=', 'RMenus.id')
                ->select('PreguntasFrecuentes.*','RMenus.Menu')
                ->where('PreguntasFrecuentes.deleted', '=', 0)
                ->where('PreguntasFrecuentes.RutaGuia', '!=', "")
                ->get(); 
                $response = $preguntas; 
                }
             
             }
      ///////// BUSQUEDA DE REGISTROS DE video SI ES admin 

             if ($type == 12) {
                if($request->CHID !=""){
                    $preguntas = DB::table('PreguntasFrecuentes')
                   ->join('RMenus', 'PreguntasFrecuentes.idMenu', '=', 'RMenus.id')
                   ->select('PreguntasFrecuentes.*','RMenus.Menu')
                   ->where('PreguntasFrecuentes.idMenu', $request->CHID)
                   ->where('PreguntasFrecuentes.deleted', '=', 0)
                   ->where('PreguntasFrecuentes.RutaVideo', '!=', "")
                   ->get();   
                   $response = $preguntas;    
                   }
                   
                   else if ($request->CHID =="") {
                   $preguntas = DB::table('PreguntasFrecuentes')
                   ->join('RMenus', 'PreguntasFrecuentes.idMenu', '=', 'RMenus.id')
                   ->select('PreguntasFrecuentes.*','RMenus.Menu')
                   ->where('PreguntasFrecuentes.deleted', '=', 0)
                   ->where('PreguntasFrecuentes.RutaVideo', '!=', "")
                   ->get(); 
                   $response = $preguntas; 
                   }

             }

             if ($type == 13) {
                $preguntas = PreguntasFrecuentes::find($request->CHID);
             
                 if($preguntas ->Texto !=""){
                 $preguntas ->deleted=1;
                 $preguntas->update();
                 }
                 if($preguntas ->RutaGuia !=""){
                 $ruta=env('APP_DOC_ROUTE').'/GUIAS/';
                 $dataDelete =$this->DeleteFile($request->TOKEN,$ruta,$preguntas ->RutaGuia) ;
                 $preguntas ->deleted=1;
                 $preguntas->update();
                 }
                 if($preguntas ->RutaVideo !=""){
                 $ruta=env('APP_DOC_ROUTE').'/VIDEOS/TUTORIALES/';
                 $dataDelete =$this->DeleteFile($request->TOKEN,$ruta,$preguntas ->RutaVideo) ;
                 $preguntas ->deleted=1;
                 $preguntas->update();
                 }
  
                   $response = $preguntas;    
                

             }

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }


        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS
            ]
        );
    }

    public function AdminVideoTutoriales(Request $request){
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        try {
            $type = $request->NUMOPERACION;
 
          }

         catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS
            ]
        );
    }

    public function AdminPreguntasFrecuentes(Request $request){
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        try {
            $type = $request->NUMOPERACION;

                 if ($type==1){
                 
                     $NuevoVideo = new PreguntasFrecuentes();
                     $file = request()->file('VIDEO');
                 
                     $ruta=env('APP_DOC_ROUTE').'/VIDEOS/TUTORIALES/';
                     if($file != null){
                         $nombre = $file->getClientOriginalName();
                         // $ruta=env('APP_DOC_ROUTE').'/PDRMYE_DEV/VIDEOS/TUTORIALES/'.$request->TIPO;
                         $data =$this->UploadFile($request->TOKEN,$ruta,$nombre,$file) ;
                         $response =  $data;
                         if($data->SUCCESS){
                             $NuevoVideo-> nombreVideo =   $data->RESPONSE->NOMBREIDENTIFICADOR;
                             $NuevoVideo-> ModificadoPor  =  $request->CHUSER;
                             $NuevoVideo-> CreadoPor        = $request->CHUSER;
                             $NuevoVideo-> idMenu        = $request->CHID;
                             $NuevoVideo-> nombreOriginal  = $request->NAME;
                 
                           $response = $data;
                         }
                 
                         // $response = "Carga Exitosa";
                     }
                 
                     $NuevoVideo->save();
                 
                 }


            if ($type == 4) {
               $response = DB::select(DB::raw("
               SELECT pf.id, pf.Pregunta, pf.Texto
               FROM PDRMYE.PreguntasFrecuentes pf
               WHERE pf.deleted = 0
               AND pf.Texto !='' AND pf.idMenu='".$request->CHID ."'"));
            }

            if ($type == 5) {
                $response = DB::select(DB::raw("
                SELECT pf.id, pf.Pregunta, pf.RutaGuia
                FROM PDRMYE.PreguntasFrecuentes pf
                WHERE pf.deleted = 0
                AND pf.RutaGuia != '' AND pf.idMenu='".$request->CHID ."'"));
            }

   
          }

         catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS
            ]
        );
    }

    public function AdminGuiaRapida(Request $request){
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        try {
            $type = $request->NUMOPERACION;

            if ($type == 4) {
                $response = DB::select(DB::raw("
                SELECT pf.id, pf.Pregunta, pf.RutaGuia
                FROM PDRMYE.PreguntasFrecuentes pf
                WHERE pf.deleted = 0
                AND pf.RutaGuia != '' AND pf.idMenu='".$request->CHID ."'"));
            }

            if ($type == 5) {
               $response = DB::select(DB::raw("
                SELECT *
                FROM PDRMYE.VideoTutorial vt
                WHERE vt.deleted = 0 
               "));
            }
 
   
          }

         catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS
            ]
        );
    }

}
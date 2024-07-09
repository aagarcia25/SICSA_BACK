<?php

namespace App\Http\Controllers;

use App\Models\OficiosA;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CNotificacionArea;
use App\Models\File;


class OficiosAController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
         9._ ELIMINA REGISTROS SELECCIONADOS

        */


    public function OficiosA_index(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $id = $this->uuidretrun();

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {

                $OBJ = new OficiosA();
                $OBJ->id = $id;
                $OBJ->ModificadoPor    = $request->CHUSER;
                $OBJ->CreadoPor        = $request->CHUSER;
                $OBJ->idAuditoria      = $request->idAuditoria;
                $OBJ->Oficio           = $request->Oficio;
                $OBJ->FechaRecibido    = $request->FechaRecibido;
                $OBJ->FechaVencimiento = $request->FechaVencimiento;
                $OBJ->idOficios = $request->idOficios;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->Observacion = $request->Observacion;
                $OBJ->idEtapa = $request->idEtapa;




                if ($OBJ->save()) {

                    // $OBJNotificaciones = new CNotificacionArea();
                    // //$OBJNotificaciones->id = $id;
                    // $OBJNotificaciones->ModificadoPor    = $request->CHUSER;
                    // $OBJNotificaciones->CreadoPor        = $request->CHUSER;
                    // $OBJNotificaciones->idAuditoria      = $request->idAuditoria;
                    // $OBJNotificaciones-> Oficio = $request->Oficio;
                    // $OBJNotificaciones->save();


                    //                 $response = DB::select("SELECT  ? as id, ? as ModificadoPor, ? as CreadoPor, cff.Route, cff.Nombre FROM 
                    // SICSA.cfolios cf 
                    // JOIN SICSA.cfoliosfiles cff ON cf.id = cff.idfolio
                    // WHERE cf.Oficio= ?", [$id, $request->CHUSER, $request->CHUSER, $OBJ->Oficio]);

                    //                 // $response =DB::select("
                    //                 // SELECT  {$id}, {$request->CHUSER}, {$request->CHUSER},cff.Route,cff.Nombre FROM 
                    //                 //                 SICSA.cfolios cf 
                    //                 //                 JOIN SICSA.cfoliosfiles cff ON cf.id = cff.idfolio
                    //                 //                 WHERE cf.Oficio= '{$OBJ->Oficio}'");

                    //                 $OBJFile = new File();

                    //                 foreach ($response as $result) {
                    //                     $OBJFile->idowner =  $id;
                    //                     $OBJFile->ModificadoPor = $result->ModificadoPor;
                    //                     $OBJFile->CreadoPor = $result->CreadoPor;
                    //                     $OBJFile->Route    = $result->Route;
                    //                     $OBJFile->Nombre    = $result->Nombre;
                    //                 }
                    //                 $OBJFile->save();
                } else {
                    $response = $OBJ;
                }
            } else if ($type == 2) {

                $OBJ = OficiosA::find($request->CHID);
                $OBJ->ModificadoPor    = $request->CHUSER;
                $OBJ->Oficio           = $request->Oficio;
                $OBJ->FechaRecibido    = $request->FechaRecibido;
                $OBJ->FechaVencimiento = $request->FechaVencimiento;
                $OBJ->idOficios = $request->idOficios;
                $OBJ->Descripcion = $request->Descripcion;
                $OBJ->Observacion = $request->Observacion;
                $OBJ->idEtapa = $request->idEtapa;



                $OBJ->save();
                $response = $OBJ;
            } else if ($type == 3) {
                $OBJ = OficiosA::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;
            } else if ($type == 4) {
                $query = "
                SELECT               
                ofa.id,
                ofa.deleted,
                ofa.UltimaActualizacion,
                ofa.FechaCreacion,
                getUserName(ofa.ModificadoPor) modi,
                getUserName(ofa.CreadoPor) creado,
                ofa.Oficio,
                TO_CHAR(ofa.FechaRecibido, 'DD/MM/YYYY') as FechaRecibido,
                TO_CHAR(ofa.FechaVencimiento,'DD/MM/YYYY') as FechaVencimiento,
                ofa.idAuditoria,
                ofa.idOficios,
                tof.Descripcion tofDescripcion,
                tof.id tofid,
                ofa.Descripcion,
                ofa.Observacion,
                et.id etid,
                ofa.entregado,
                et.Descripcion etDescripcion,
                (SELECT COUNT(cont.id) FROM SICSA.Oficios_Contestacion cont WHERE cont.idOficio = ofa.id and cont.deleted=0) NoContestacion
                FROM SICSA.OficiosA ofa
                LEFT JOIN SICSA.Cat_Tipos_Oficios tof ON ofa.idOficios = tof.id
                LEFT JOIN SICSA.Cat_Etapas et ON ofa.idEtapa = et.id
                where ofa.deleted =0
                     
                    ";
                $query =  $query . " and    idAuditoria='" . $request->P_IDAUDITORIA . "'
                order by Oficio desc
                ";
                $response = DB::select($query);
            } elseif ($type == 5) {
                $OBJ = OficiosA::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                //$OBJ->entregado = 1;

                if ($OBJ->entregado == 1) {
                    $OBJ->entregado = 0;
                } else {
                    $OBJ->entregado = 1;
                }

                $OBJ->save();
                $response = $OBJ;

            }else if ($type == 9) {
                $CHIDs = $request->input('CHIDs');
                $response = [];

                foreach ($CHIDs as $CHID) {
                    $OBJ = OficiosA::find($CHID);

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
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }
}

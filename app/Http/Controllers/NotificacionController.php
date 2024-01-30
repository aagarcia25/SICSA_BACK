<?php

namespace App\Http\Controllers;

use App\Models\CNotificacionArea;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\File;


class NotificacionController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */
    private function uuidretrun()
    {
        // Lógica para generar un nuevo UUID, por ejemplo:
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }
    public function Notificacionindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $id = $this->uuidretrun();


        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new CNotificacionArea();
                $OBJ->id = $id;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->Prorroga = $request->Prorroga; 
                $OBJ->Oficio = $request->Oficio;
                $OBJ->SIGAOficio = $request->SIGAOficio;
                $OBJ->FOficio = $request->FOficio;
                $OBJ->FRecibido = $request->FRecibido;
                $OBJ->FVencimiento = $request->FVencimiento;
                $OBJ->idsecretaria = $request->idsecretaria;
                $OBJ->idunidad = $request->idunidad;

                if ($OBJ->save()) {
                 
                    $response = DB::select("SELECT  ? as id, ? as ModificadoPor, ? as CreadoPor, cff.Route, cff.Nombre FROM 
    SICSA.cfolios cf 
    JOIN SICSA.cfoliosfiles cff ON cf.id = cff.idfolio
    WHERE cf.Oficio= ?", [$id, $request->CHUSER, $request->CHUSER, $OBJ->Oficio]);


                $OBJFile = new File();
                    
                    foreach ($response as $result){
                        $OBJFile->idowner =  $id;
                        $OBJFile->ModificadoPor = $result->ModificadoPor;
                        $OBJFile->CreadoPor = $result->CreadoPor;
                        $OBJFile->Route    = $result->Route;
                        $OBJFile->Nombre    = $result->Nombre;
                    }
                    $OBJFile ->save();
                                } else {
                                    $response = $OBJ;
                                }



            } elseif ($type == 2) {

                $OBJ = CNotificacionArea::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->Prorroga = $request->Prorroga;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->SIGAOficio = $request->SIGAOficio;
                $OBJ->FOficio = $request->FOficio;
                $OBJ->FRecibido = $request->FRecibido;
                $OBJ->FVencimiento = $request->FVencimiento;
                $OBJ->idsecretaria = $request->idsecretaria;
                $OBJ->idunidad = $request->idunidad;

                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = CNotificacionArea::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                SELECT
                    ca.id,
                    ca.deleted,
                    ca.UltimaActualizacion,
                    ca.FechaCreacion,
                    getUserName(ca.ModificadoPor) modi,
                    getUserName(ca.CreadoPor) creado,
                    ca.Prorroga,
                    ca.Oficio,
                    ca.SIGAOficio,
                    ca.FOficio,
                    ca.FRecibido,
                    ca.FVencimiento,
                    sec.Descripcion secretaria,
                    sec.id secid,
                    uni.id uniid,
                    uni.Descripcion unidad
                    FROM SICSA.C_Notificacion_area ca
                    INNER JOIN SICSA.cat_secretarias sec ON ca.idsecretaria = sec.id
                    INNER JOIN SICSA.cat_unidades uni ON ca.idunidad = uni.id
                    where ca.deleted =0
                    ";
                $query = $query . " and    idAuditoria='" . $request->P_IDAUDITORIA . "'";
                $response = DB::select($query);

            }elseif ($type == 5) {

                $query = "
                SELECT cf.Fecha 
                FROM SICSA.cfolios cf 
                INNER JOIN SICSA.cfoliosfiles cff ON cff.idfolio=cf.id
                WHERE cf.deleted=0 AND cf.Oficio='";
                $query = $query . $request->Oficio."'";
                 $response = DB::select($query);
               // $response = $query;

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
            ]);

    }

}

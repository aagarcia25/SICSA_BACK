<?php

namespace App\Http\Controllers;

use App\Models\CContestacionArea;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\File;


class ContestacionController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
    9._ ELIMINA REGISTROS SELECCIONADOS
     */


    public function Contestacionindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $id = $this->uuidretrun();

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new CContestacionArea();
                $OBJ->id = $id;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idNotificacion = $request->idNotificacion;
                $OBJ->Prorroga = $request->Prorroga;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->SIGAOficio = $request->SIGAOficio;
                $OBJ->FOficio = $request->FOficio;
                $OBJ->FRecibido = $request->FRecibido;
                $OBJ->FVencimiento = $request->FVencimiento;
                $OBJ->idsecretaria = $request->idsecretaria;
                $OBJ->idunidad = $request->idunidad;
                if ($OBJ->save()) {

                    // $response = DB::select("SELECT  ? as id, ? as ModificadoPor, ? as CreadoPor, cff.Route, cff.Nombre FROM 
                    // SICSA.cfolios cf 
                    // JOIN SICSA.cfoliosfiles cff ON cf.id = cff.idfolio
                    // WHERE cf.Oficio= ?", [$id, $request->CHUSER, $request->CHUSER, $OBJ->Oficio]);


                    // $OBJFile = new File();

                    // foreach ($response as $result) {
                    //     $OBJFile->idowner =  $id;
                    //     $OBJFile->ModificadoPor = $result->ModificadoPor;
                    //     $OBJFile->CreadoPor = $result->CreadoPor;
                    //     $OBJFile->Route    = $result->Route;
                    //     $OBJFile->Nombre    = $result->Nombre;
                    // }
                    // $OBJFile->save();
                } else {
                    $response = $OBJ;
                }
            } elseif ($type == 2) {

                $OBJ = CContestacionArea::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idNotificacion = $request->idNotificacion;
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
                $OBJ = CContestacionArea::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 4) {

                $query = "SELECT
                ca.id,
                ca.deleted,
                ca.UltimaActualizacion,
                ca.FechaCreacion,
                ca.idNotificacion,
                getUserName(ca.ModificadoPor) modi,
                getUserName(ca.CreadoPor) creado,
                ca.Oficio,
                ca.SIGAOficio,
                TO_CHAR(ca.FOficio, 'DD/MM/YYYY') AS FOficio,
                sec.id secid,
                sec.Descripcion secretaria,
                uni.id uniid,
                uni.Descripcion unidad, 
                TO_CHAR(ca.FRecibido, 'DD/MM/YYYY') AS FRecibido,
                TO_CHAR(ca.FVencimiento, 'DD/MM/YYYY') AS FVencimiento,
                TO_CHAR(ca.Prorroga, 'DD/MM/YYYY') AS Prorroga,
                na.idAuditoria,
                aud.NAUDITORIA,
                dep.Descripcion depDescripcion,
                dep.id depid
                FROM SICSA.C_Contestacion_area ca
                INNER JOIN SICSA.cat_secretarias sec ON ca.idsecretaria = sec.id
                LEFT JOIN SICSA.cat_unidades uni ON ca.idunidad = uni.id
                INNER JOIN SICSA.C_Notificacion_area na ON ca.idNotificacion = na.id
                INNER JOIN SICSA.auditoria aud ON na.idAuditoria = aud.id
                LEFT JOIN SICSA.Cat_Dependencias dep ON ca.idunidad = dep.id
                WHERE ca.deleted =0
                    ";
                $query = $query . " and    idNotificacion='" . $request->P_IDNOTIFICACION . "'
                order by Oficio desc";
                $response = DB::select($query);
            } else if ($type == 9) {
                $CHIDs = $request->input('CHIDs');
                $response = [];

                foreach ($CHIDs as $CHID) {
                    $OBJ = CContestacionArea::find($CHID);

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

<?php

namespace App\Http\Controllers;

use App\Models\OrganoC;
use App\Models\OrganoR;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\File;


class OrganoController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
    9._ ELIMINA REGISTROS SELECCIONADOS
     */



    public function OrganoCindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $id = $this->uuidretrun();

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new OrganoC();
                $OBJ->id = $id;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->SIGAOficio = $request->SIGAOficio;
                $OBJ->FOficio = $request->FOficio;
                $OBJ->FRecibido = $request->FRecibido;
                $OBJ->FVencimiento = $request->FVencimiento;
                $OBJ->idOrganoAuditorOrigen = $request->idOrganoAuditorOrigen;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 2) {

                $OBJ = OrganoC::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->SIGAOficio = $request->SIGAOficio;
                $OBJ->FOficio = $request->FOficio;
                $OBJ->FRecibido = $request->FRecibido;
                $OBJ->FVencimiento = $request->FVencimiento;
                $OBJ->idOrganoAuditorOrigen = $request->idOrganoAuditorOrigen;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 3) {
                $OBJ = OrganoC::find($request->CHID);
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
                    ca.Oficio,
                    ca.SIGAOficio,
                    ca.FOficio,
                    ca.FRecibido,
                    ca.FVencimiento,
                    sec.id secid,
                    sec.Descripcion descripcionsec
                    FROM SICSA.Organo_C ca
                    INNER JOIN SICSA.Cat_Origen_Auditoria sec ON ca.idOrganoAuditorOrigen = sec.id
                    where ca.deleted =0
                    ";
                $query = $query . " and    ca.idAuditoria='" . $request->P_IDAUDITORIA . "'
                order by Oficio desc";
                $response = DB::select($query);
            } else if ($type == 9) {
                $CHIDs = $request->input('CHIDs');
                $response = [];

                foreach ($CHIDs as $CHID) {
                    $OBJ = OrganoC::find($CHID);

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

    public function OrganoRindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $id = $this->uuidretrun();

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {

                $OBJ = new OrganoR();
                $OBJ->id = $id;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idOrganoC = $request->idOrganoC;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->SIGAOficio = $request->SIGAOficio;
                $OBJ->FOficio = $request->FOficio;
                $OBJ->FRecibido = $request->FRecibido;
                $OBJ->FVencimiento = $request->FVencimiento;
                $OBJ->idOrganoAuditorOrigen = $request->idOrganoAuditorOrigen;
                $OBJ->idOrganoAuditorDestino = $request->idOrganoAuditorDestino;

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

                $OBJ = OrganoR::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idOrganoC = $request->idOrganoC;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->SIGAOficio = $request->SIGAOficio;
                $OBJ->FOficio = $request->FOficio;
                $OBJ->FRecibido = $request->FRecibido;
                $OBJ->FVencimiento = $request->FVencimiento;
                $OBJ->idOrganoAuditorOrigen = $request->idOrganoAuditorOrigen;
                $OBJ->idOrganoAuditorDestino = $request->idOrganoAuditorDestino;

                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 3) {
                $OBJ = OrganoR::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 4) {

                $query = "
                SELECT
                    organo.id,
                    organo.deleted,
                    organo.UltimaActualizacion,
                    organo.FechaCreacion,
                    getUserName(organo.ModificadoPor) modi,
                    getUserName(organo.CreadoPor) creado,
                    organo.Oficio,
                    organo.SIGAOficio,
                    organo.FOficio,
                    organo.FRecibido,
                    organo.FVencimiento,
                    origen.id origenid,
                    origen.Descripcion descripcionorigen,
                    destino.id destinoid,
                    destino.Descripcion descripciodestino
                    FROM SICSA.Organo_R organo
                    left JOIN SICSA.Cat_Origen_Auditoria origen ON origen.id = organo.idOrganoAuditorOrigen
                    left JOIN SICSA.Cat_Origen_Auditoria destino ON destino.id = organo.idOrganoAuditorDestino
                    where organo.deleted =0
                    ";
                $query = $query . " and    organo.idOrganoC='" . $request->P_IDNOTIFICACION . "'
                order by Oficio desc";
                $response = DB::select($query);
            } else if ($type == 9) {
                $CHIDs = $request->input('CHIDs');
                $response = [];

                foreach ($CHIDs as $CHID) {
                    $OBJ = OrganoR::find($CHID);

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

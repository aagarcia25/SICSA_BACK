<?php

namespace App\Http\Controllers;

use App\Models\OrganoC;
use App\Models\OrganoR;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganoController extends Controller
{

    public function OrganoCindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new OrganoC();
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
                $query = $query . " and    ca.idAuditoria='" . $request->P_IDAUDITORIA . "'";
                $response = DB::select($query);

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

    public function OrganoRindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {

                $OBJ = new OrganoR();
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
                $query = $query . " and    organo.idOrganoC='" . $request->P_IDNOTIFICACION . "'";
                $response = DB::select($query);

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

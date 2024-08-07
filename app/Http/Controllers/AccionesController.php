<?php

namespace App\Http\Controllers;

use App\Models\Accione;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccionesController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
    9._ ELIMINA REGISTROS SELECCIONADOS
     */

    public function Acciones_index(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Accione();
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->idTipoAccion = $request->idTipoAccion;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->idEstatusAccion = $request->idEstatusAccion;
                $OBJ->ClaveAccion = $request->ClaveAccion;
                $OBJ->TextoAccion = $request->TextoAccion;
                $OBJ->Valor = $request->Valor;
                $OBJ->accionSuperviviente = $request->accionSuperviviente;
                $OBJ->numeroResultado = $request->numeroResultado;
                $OBJ->monto = $request->monto;
                $OBJ->idOficio = $request->idOficio;

                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = Accione::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->idTipoAccion = $request->idTipoAccion;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->idEstatusAccion = $request->idEstatusAccion;
                $OBJ->ClaveAccion = $request->ClaveAccion;
                $OBJ->TextoAccion = $request->TextoAccion;
                $OBJ->Valor = $request->Valor;
                $OBJ->accionSuperviviente = $request->accionSuperviviente;
                $OBJ->numeroResultado = $request->numeroResultado;
                $OBJ->monto = $request->monto;
                $OBJ->idOficio = $request->idOficio;
                

                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = Accione::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                    SELECT
                      accion.id,
                      accion.deleted,
                      accion.UltimaActualizacion,
                      accion.FechaCreacion,
                      getUserName(accion.ModificadoPor) modi,
                      getUserName(accion.CreadoPor) creado,
                      accion.idTipoAccion,
                      accion.idAuditoria,
                      accion.idEstatusAccion,
                      accion.ClaveAccion,
                      accion.TextoAccion,
                      accion.Valor,
                      accion.numeroResultado,
                      accion.monto,
                      aud.NAUDITORIA,
                      accion.idOficio,
                      ofi.Oficio OficioA,
                      cta.Descripcion AS DescripcionTipoDeAccion,
                      cea.Descripcion AS DescripcionEstatusAccion,
                      accion.accionSuperviviente
                      FROM SICSA.acciones accion
                      LEFT JOIN SICSA.auditoria aud ON accion.idAuditoria = aud.id
                      LEFT JOIN SICSA.Cat_Tipos_Accion cta ON accion.idTipoAccion = cta.id
                      LEFT JOIN SICSA.Cat_Estatus_Acciones cea ON accion.idEstatusAccion = cea.id
                      LEFT JOIN SICSA.OficiosA ofi ON ofi.id = accion.idOficio

                    where accion.deleted =0

                      ";

                $query = $query . " and accion.idAuditoria='" . $request->P_IDAUDITORIA . "'";

                $query .= " AND ( accion.idOficio = '" . $request->P_IDOFICIO .  "' OR accion.idOficio IS NULL )";


                $response = DB::select($query);

            }else if ($type == 9) {
                $CHIDs = $request->input('CHIDs'); 
                $response = [];

                foreach ($CHIDs as $CHID) {
                $OBJ = Accione::find($CHID);

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
            ]);

    }
}

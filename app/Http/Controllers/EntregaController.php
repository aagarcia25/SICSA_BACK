<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrega;
use App\Models\CatInforme;
use App\Models\Auditorium;
use Illuminate\Database\QueryException;
use App\Models\File;
use Illuminate\Support\Facades\DB;


class EntregaController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
    9._ ELIMINA REGISTROS SELECCIONADOS
     */

     public function Entregaindex(Request $request)
     {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $id = $this->uuidretrun();

        try{
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Entrega();
                $OBJ->id = $id;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->Entrega = $request->Entrega;
                $OBJ->Fecha = $request->Fecha;
                $OBJ->Oficio = $request->Oficio;

                $OBJ->save();

                $response = $OBJ;
            } elseif ($type == 2) {

                $OBJ = Entrega::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->idAuditoria = $request->idAuditoria;
                $OBJ->Entrega = $request->Entrega;
                $OBJ->Fecha = $request->Fecha;
                $OBJ->Oficio = $request->Oficio;


                $OBJ->save();

                $response = $OBJ;
            } elseif ($type == 3) {
                $OBJ = Entrega::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 4) {

                $query = "
                
                SELECT
                en.id,
                en.deleted,
                en.UltimaActualizacion,
                en.FechaCreacion,
                getUserName(en.ModificadoPor) modi,
                getUserName(en.CreadoPor) creado,
                en.Entrega,
                en.idAuditoria,
                ci.Descripcion ciDescripcion,
                ci.id ciid,
                en.Oficio,
                TO_CHAR(en.Fecha, 'DD/MM/YYYY') as  Fecha
               
                FROM SICSA.Entregas en
                INNER JOIN SICSA.auditoria aud ON en.idAuditoria = aud.id 
                left JOIN SICSA.Cat_Informes ci ON en.Entrega = ci.id
                where en.deleted =0
                    ";
                $query = $query . " and    en.idAuditoria='" . $request->P_IDAUDITORIA . "'
                order by Entrega desc";
                $response = DB::select($query);
            } else if ($type == 9) {
                $CHIDs = $request->input('CHIDs');
                $response = [];

                foreach ($CHIDs as $CHID) {
                    $OBJ = Entrega::find($CHID);

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

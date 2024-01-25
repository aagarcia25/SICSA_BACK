<?php

namespace App\Http\Controllers;

use App\Models\OficiosA;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OficiosAController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
         1._ INSERTAR UN REGISTRO
         2._ ACTUALIZAR UN REGISTRO
         3._ ELIMINAR UN REGISTRO
         4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
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
                if ($OBJ->save()) {
                    SELECT  $id, $request->CHUSER, $request->CHUSER,cff.Route,cff.Nombre FROM 
                    SICSA.cfolios cf 
                    JOIN SICSA.cfoliosfiles cff ON cf.id = cff.idfolio
                    WHERE cf.Oficio= $OBJ->Oficio;

                } else {
                }
                $response = $OBJ;
            } else if ($type == 2) {

                $OBJ = OficiosA::find($request->CHID);
                $OBJ->ModificadoPor    = $request->CHUSER;
                $OBJ->Oficio           = $request->Oficio;
                $OBJ->FechaRecibido    = $request->FechaRecibido;
                $OBJ->FechaVencimiento = $request->FechaVencimiento;
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
                    id,
                    deleted,
                    UltimaActualizacion,
                    FechaCreacion,
                    getUserName(ModificadoPor) modi,
                    getUserName(CreadoPor) creado,
                    Oficio,
                    FechaRecibido,
                    FechaVencimiento,
                    idAuditoria
                    FROM SICSA.OficiosA   
                    where deleted =0
                    ";
                $query =  $query . " and    idAuditoria='" . $request->P_IDAUDITORIA . "'";
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
            ]
        );
    }
}

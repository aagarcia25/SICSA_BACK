<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficasController extends Controller
{

    public function graficas(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {

            switch ($request->nivel) {

                case '0':
                    $query = "
                                SELECT
                                ct.Descripcion AS Clasificacion,
                                COUNT( CASE WHEN cea.Descripcion = 'En Proceso' THEN aud.id END ) AS 'En Proceso',
                                COUNT( CASE WHEN cea.Descripcion = 'Concluida' THEN aud.id END ) AS 'Concluida'
                                FROM
                                SICSA.auditoria aud
                                LEFT JOIN SICSA.cat_tipo ct ON aud.idClasificacion = ct.id
                                LEFT JOIN SICSA.Cat_Tipos_Auditoria cta ON aud.idTipoAuditoria = cta.id
                                LEFT JOIN SICSA.cat_estatus_auditoria cea ON aud.idEstatus = cea.id
                                WHERE
                                aud.deleted = 0
                                GROUP BY
                                ct.Descripcion
                        ";
                    $response = DB::select($query);

                    break;

                default:
                    $response = "No se Encuentra configurado para la migración";
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

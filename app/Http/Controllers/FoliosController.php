<?php

namespace App\Http\Controllers;


use App\Models\Cfolio;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class FoliosController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */


    public function Foliosindex(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $id = $this->uuidretrun();

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Cfolio();
                $OBJ->id = $id;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Fecha = $request->Fecha;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->Nauditoria = $request->Nauditoria;
                $OBJ->Solicita = $request->Solicitante;
                $OBJ->FechaEntrega = $request->FechaEntregado;
                $OBJ->FechaRecibido = $request->FechaRecibido;
                $OBJ->Asunto = $request->Asunto;
                $OBJ->Tema = $request->Tema;
                $OBJ->Tipo = $request->Tipo;
                $OBJ->Observaciones = $request->Observaciones;
                $OBJ->Destinatario = $request->Destinatario;
                $OBJ->Puesto = $request->Puesto;
                $OBJ->save();
                $response = $OBJ;

                DB::update("
                          UPDATE SICSA.cfolios cf
                           SET cf.Anio = (
                            SELECT SUBSTRING(af.Oficio, -4) 
                            FROM SICSA.cfolios af 
                            WHERE af.id = cf.id
                            )
                         WHERE cf.Anio IS NULL
                          ");
            } elseif ($type == 2) {
                $OBJ = Cfolio::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Fecha = $request->Fecha;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->Nauditoria = $request->Nauditoria;
                $OBJ->Solicita = $request->Solicitante;
                $OBJ->FechaEntrega = $request->FechaEntregado;
                $OBJ->FechaRecibido = $request->FechaRecibido;
                $OBJ->Asunto = $request->Asunto;
                $OBJ->Tema = $request->Tema;
                $OBJ->Tipo = $request->Tipo;
                $OBJ->Observaciones = $request->Observaciones;
                //$OBJ->Cargo = $request->Cargo;
                $OBJ->Destinatario = $request->Destinatario;
                $OBJ->Puesto = $request->Puesto;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 3) {
                $OBJ = Cfolio::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 4) {
// df.Cargo AS dfCargo,
                $query = "
                                SELECT
                                 cp.id AS cpid,
                                 cp.Nombre AS cpNombre,
                                 df.id AS dfid,
                                 df.Titular AS dfTitular,
                                 df.Cargo,
                                 cf.Puesto cfPuesto,
                                 cf.*,
                                 CASE
                                     WHEN cf.Tipo = 'CAF' THEN 'COORDINACION DE AUDITORIAS FEDERALES'
                                     WHEN cf.Tipo = 'CAE' THEN 'COORDINACION DE AUDITORIAS ESTATALES'
                                 END AS tipoau,
                                 CASE
                                     WHEN cf.Cancelado = '1' THEN 'CANCELADO'
                                     ELSE ''
                                 END AS Cancelado
                             FROM
                                 SICSA.cfolios cf
                             LEFT JOIN SICSA.Cat_Personal cp ON cf.Solicita = cp.id
                             LEFT JOIN SICSA.Cat_Destinatarios_Oficios df ON cf.Destinatario = df.id
                             WHERE
                                 cf.deleted = 0
                            
                                  
                              
                                ";


                if ($request->FolioSIGA != "") {
                    $query = $query . " and    aud.FolioSIGA='" . $request->FolioSIGA . "'";
                }
                if ($request->Anio != "") {
                    $query = $query . " and    cf.Anio='" . $request->Anio . "'";
                }

                $query = $query . " order by   CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(cf.Oficio, '-', -2), '-', 1) AS SIGNED) desc";

                $response = DB::select($query);
            } else if ($type == 5) {
                $OBJ = new Cfolio();

                $meses = [
                    'enero' => 1,
                    'febrero' => 2,
                    'marzo' => 3,
                    'abril' => 4,
                    'mayo' => 5,
                    'junio' => 6,
                    'julio' => 7,
                    'agosto' => 8,
                    'septiembre' => 9,
                    'octubre' => 10,
                    'noviembre' => 11,
                    'diciembre' => 12,
                ];
                $mesNumero = $meses[strtolower($request->mes)];
                $fecha = Carbon::create($request->anio, $mesNumero, $request->dia);

                $fechaFormateada = $fecha->format('Y-m-d');
                $OBJ->id = $id;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Fecha = $fechaFormateada;
                $OBJ->Oficio = $request->Oficio;
                // $OBJ->Nauditoria = $request->Nauditoria;
                $OBJ->Asunto = $request->Asunto;

                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 6) {
                $OBJ = Cfolio::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                if ($OBJ->Cancelado == 1) {
                    $OBJ->Cancelado = 0;
                } else {
                    $OBJ->Cancelado = 1;
                }

                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 7) {
                $OBJ = new Cfolio();
$OBJ->ModificadoPor = $request->CHUSER;
$OBJ->CreadoPor = $request->CHUSER;
$OBJ->Oficio = 'BS-' . $request->Oficio;
$OBJ->save();

$response = $OBJ;
Log::info('BS-' . $request->Oficio);
DB::update("
    UPDATE SICSA.cfolios
    SET Anio = CAST(SUBSTRING(Oficio, -4) AS UNSIGNED)
    WHERE Anio IS NULL
    AND SUBSTRING(Oficio, -4) REGEXP '^[0-9]{4}$'
    AND Oficio = ?
", ['BS-' . $request->Oficio]);




            } else if ($type == 8) {
                $CHIDs = $request->input('CHIDs'); // Supongamos que CHIDs es un array de identificadores
                $response = [];

                foreach ($CHIDs as $CHID) {
                    $OBJ = Cfolio::find($CHID);

                    if ($OBJ) {
                        $OBJ->deleted = 1;
                        $OBJ->ModificadoPor = $request->CHUSER;
                        $OBJ->save();
                        $response[] = $OBJ;
                    }
                }
            } else if ($type == 9) {
                $query = "
                                select
                                 df.Cargo
                                 FROM Cat_Destinatarios_Oficios df
                                 WHERE df.id = ? 
                              
                                ";
                               // $query = $query . " order by   CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(cf.Oficio, '-', -2), '-', 1) AS SIGNED) desc";

                $response = DB::select($query,[$request->Destinatario]);
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

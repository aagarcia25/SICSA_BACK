<?php

namespace App\Http\Controllers;

use App\Models\CatModalidad;
use App\Models\Cfolio;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Cfolio();
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



                $OBJ->save();
                $response = $OBJ;
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

                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 3) {
                $OBJ = Cfolio::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;
            } elseif ($type == 4) {

                $query = "
                           SELECT
                           cp.id cpid,
                           cp.Nombre cpNombre,
                           df.id dfid,
                           df.Titular dfTitular,
                           df.Cargo dfCargo,
                             cf.*,
                             Case 
                             when cf.Tipo ='CAF' then 'COORDINACION DE AUDITORIAS FEDERALES'
                             when cf.Tipo ='CAE' then 'COORDINACION DE AUDITORIAS ESTATALES'
                             END tipoau, 
                             Case 
                             when cf.Cancelado ='1' then 'CANCELADO'
                             else ''
                             END Cancelado
                             FROM SICSA.cfolios cf
                             LEFT JOIN SICSA.Cat_Personal cp ON cf.Solicita = cp.id
                             LEFT JOIN SICSA.Cat_Destinatarios_Oficios df ON cf.Destinatario = df.id

                             
                             where cf.deleted =0
                             AND (year(cf.Fecha) = (
                                SELECT ca.anio 
                                FROM SICSA.Cat_Anios ca 
                                WHERE ca.anio ='" . $request->Anio . "' 
                                )
                                OR '" . $request->Anio . "'IS NULL 
                                OR '" . $request->Anio . "'='')
                                order by FechaCreacion desc";
                if ($request->FolioSIGA != "") {
                    $query = $query . " and    aud.FolioSIGA='" . $request->FolioSIGA . "'";
                }
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
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Fecha = $fechaFormateada;
                $OBJ->Oficio = $request->Oficio;
                // $OBJ->Nauditoria = $request->Nauditoria;
                $OBJ->Asunto = $request->Asunto;

                $OBJ->save();
                $response = $OBJ;
            }elseif ($type == 6) {
                $OBJ = Cfolio::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                if( $OBJ->Cancelado == 1){
                    $OBJ->Cancelado = 0;
                }else{
                    $OBJ->Cancelado = 1;
                }
                
                $OBJ->save();
                $response = $OBJ;

            }elseif ($type == 7){
                $OBJ = new Cfolio();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Oficio = $request->Oficio;
                $OBJ->save();
                $response = $OBJ;

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

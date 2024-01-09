<?php

namespace App\Http\Controllers;

use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{

    use ReportTrait;

    public function ReportesData(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {

            $query = "
                    SELECT
                   *
                    FROM SICSA.Reportes
                    where deleted =0
                    order by Nombre desc
                    ";
            $response = DB::select($query);

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

    public function ReportesIndex(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $params = [];

        try {
            $format = [$request->TIPO];
            if($request->REPORTE == "REP_07.jrxml"){
                $params = [
                //  "P_IMAGEN" => public_path() . '/img/TesoreriaLogo.png',
                "P_ANIO" => trim($request->P_ANIO),
                "Filtro" => $request->Filtro,
                "ResumenResultados" =>$request->ResumenResultados,
                
            ];
            }else{
                $params = [
                "P_ANIO" => trim($request->P_ANIO),
                
                
            ];
            }
            
            
            $reporte = $request->REPORTE;
            $partes = explode(".", $reporte);
            
            $data = $this->ejecutaReporte($format, $params, $reporte)->getData();
            if ($data->SUCCESS) {
                $salida = public_path() . '/reportes/' . $partes[0] . '.pdf';
                $response = base64_encode(file_get_contents($salida));

            } else {
                $SUCCESS = false;
                $response = $data;

            }

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
                'PARAMS' => $params,  // Aquí se incluyen los parámetros
            ]);

    }
}

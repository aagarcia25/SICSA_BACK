<?php

namespace App\Http\Controllers;

use App\Traits\ReportTrait;
use Illuminate\Http\Request;

class ReportesController extends Controller
{

    use ReportTrait;

    public function ReportesIndex(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $format = [$request->TIPO];
            $params = [
                //  "P_IMAGEN" => public_path() . '/img/TesoreriaLogo.png',
                "P_ANIO" => trim($request->P_ANIO),
            ];
            $reporte = $request->REPORTE;
            $partes = explode(".", $reporte);

            $data = $this->ejecutaReporte($format, $params, $reporte)->getData();
            if ($data->SUCCESS) {
                $salida = public_path() . '/reportes/' . $partes[0] . '.pdf';
                $response = file_get_contents(base64_encode($salida));

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
            ]);

    }
}

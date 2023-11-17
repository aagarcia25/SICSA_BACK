<?php
namespace App\Traits;

use Exception;
use PHPJasper\PHPJasper;

trait ReportTrait
{

    public function ejecutaReporte($formato, $parametros, $reporte)
    {

        $response = "Reporte Generado Correctamente";
        $SUCCESS = true;

        try {

            $input = public_path() . '/reportes/' . $reporte;
            $output = public_path() . '/reportes';

            if ($reporte === "") {
                throw new Exception("El nombre del Reporte es Obligatorio");
            }

            if ($parametros === "") {
                throw new Exception("es necesario un areglo de parametros o enviar el areglo vacio -> []");
            }

            if ($formato === "" || $formato === []) {
                throw new Exception("El arreglo de formato debe ser obligatorio ejemplos -> ['pdf','xlsx','csv']");
            }

            $options = [
                'format' => $formato,
                'params' => $parametros,
                'db_connection' => [
                    'driver' => env('DB_CONNECTION'),
                    'username' => env('DB_USERNAME'),
                    'password' => env('DB_PASSWORD'),
                    'host' => env('DB_HOST'),
                    'database' => env('DB_DATABASE'),
                    'port' => env('DB_PORT'),
                ],
            ];

            $jasper = new PHPJasper;
            $jasper->process(
                $input,
                $output,
                $options
            )->execute();

        } catch (\Exception $e) {
            $jasper = new PHPJasper;
            $X = $jasper->process(
                $input,
                $output,
                $options
            )->output();

            $SUCCESS = false;
            $response = $X;
        }

        return response()->json(
            [
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );

    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Cfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FormatosController extends Controller
{

    public function remplazarPalabras($inputPath, $outputPath, $reemplazos)
    {
        // Crear un objeto TemplateProcessor usando el archivo de entrada
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($inputPath);
        // Iterar sobre los reemplazos y realizarlos en el archivo de Word
        foreach ($reemplazos as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }
        // Guardar el archivo de Word resultante en la ruta de salida
        $templateProcessor->saveAs($outputPath);
    }



    public function informes(Request $request)
    {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = '';
        $SUCCESS = true;
        try {
            $inputPath = "";
            $outputPath = "";
            $rutaCompleta = "";
            setlocale(LC_TIME, 'es_ES');
            $param = Cfolio::find($request->CHID);
            $fecha_formateada = date('d \d\e F \d\e Y', strtotime($param->Fecha));
            $destinatario = $param->Cat_Destinatarios_Oficios;

            if ($request->TIPO == "ADMINISTRATIVO") {

                $inputPath = storage_path('/archivos/ADMINISTRATIVO.docx');
                $outputPath = storage_path('/archivos/ADMINISTRATIVO_TES.docx');

                $reemplazos = [
                    '${OFICIO}' => $param->Oficio,
                    '${FECHA}' => $fecha_formateada,
                    '${ASUNTO}' => $param->Asunto,
                    '${DESTINATARIO}' => $destinatario->Titular,
                    '${CARGO}' => $destinatario->Cargo,
                ];

                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            } else if ($request->TIPO == "SALIDA") {
                $inputPath = storage_path('/archivos/SALIDA.docx');
                $outputPath = storage_path('/archivos/SALIDA_TES.docx');

                $reemplazos = [
                    '${OFICIO}' => $param->Oficio,
                    '${FECHA}' => $fecha_formateada,
                    '${ASUNTO}' => $param->Asunto,
                    '${DESTINATARIO}' => $destinatario->Titular,
                    '${CARGO}' => $destinatario->Cargo,

                ];

                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            } else if ($request->TIPO == "SOLICITUD") {

                $inputPath = storage_path('/archivos/SOLICITUD.docx');
                $outputPath = storage_path('/archivos/SOLICITUD_TES.docx');

                $reemplazos = [
                    '${OFICIO}' => $param->Oficio,
                    '${FECHA}' => $fecha_formateada,
                    '${ASUNTO}' => $param->Asunto,
                    '${DESTINATARIO}' => $destinatario->Titular,
                    '${CARGO}' => $destinatario->Cargo,

                ];
                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            }


            $rutaCompleta = storage_path('archivos' . DIRECTORY_SEPARATOR . $request->TIPO . '_TES.docx');
            $response = base64_encode(file_get_contents($rutaCompleta));




            // unlink($rutaCompleta);
            // unlink($outputPath);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
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

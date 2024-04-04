<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoAuditoriaController extends Controller
{
    public function handleReport(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response64 = '';

        try {
            $obj = new \stdClass();
            $input = public_path() . '/reportes/informe.xlsx';
            $book = \PhpOffice\PhpSpreadsheet\IOFactory::load($input);
            $sheet1 = $book->getSheetByName('Sheet1');

            $auditoria = Auditorium::find($request->CHID);

            $sheet1->setCellValue('B1', $auditoria->anio);
            $sheet1->setCellValue('B2', $auditoria->NAUDITORIA);
            $sheet1->setCellValue('B3', $auditoria->NombreAudoria);
            $sheet1->setCellValue('B4', $auditoria->cat_area_auditora->Descripcion);
            $sheet1->setCellValue('B5', $auditoria->cat_inicio_auditorium->Descripcion);
            $sheet1->setCellValue('B6', $auditoria->ActaInicio);
            $query = "
                                 SELECT
                         uni.Descripcion AS AreaNotificada,
                         na.Oficio AS OficioNotificación,
                         na.FOficio AS Fecha,
                         (SELECT ca.Oficio FROM SICSA.C_Contestacion_area ca WHERE ca.idNotificacion = na.id AND ca.deleted = 0 LIMIT 1) AS OficioContestación,
                         (SELECT ca.FRecibido FROM SICSA.C_Contestacion_area ca WHERE ca.idNotificacion = na.id AND ca.deleted = 0 LIMIT 1) AS FechaRecibido
                        
                     FROM
                         SICSA.auditoria aud
                     LEFT JOIN
                         SICSA.C_Notificacion_area na ON aud.id = na.idAuditoria
                     LEFT JOIN
                         SICSA.cat_unidades uni ON na.idunidad = uni.id
                         
                     WHERE
                         aud.NAUDITORIA = ?
                         AND na.deleted = 0
                         ";
            $dataSheet1 = DB::select($query, [$auditoria->NAUDITORIA]);
            $count = 11;
            for ($i = 0; $i < count($dataSheet1); ++$i) {
                $sheet1->setCellValue('A' . $count, $dataSheet1[$i]->AreaNotificada);
                $sheet1->setCellValue('B' . $count, $dataSheet1[$i]->OficioNotificación);
                $sheet1->setCellValue('C' . $count, $dataSheet1[$i]->Fecha);
                $sheet1->setCellValue('D' . $count, '');
                $sheet1->setCellValue('E' . $count, $dataSheet1[$i]->OficioContestación);
                $sheet1->setCellValue('F' . $count, $dataSheet1[$i]->FechaRecibido);
                ++$count;
            }




            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($book);
            $writer->setOffice2003Compatibility(true);
            $writer->save($_SERVER['DOCUMENT_ROOT'] . '/reportes/auditoria.xlsx');
            $returninput = public_path() . '/reportes/auditoria.xlsx';

            $fragmentos = explode('.', $returninput);
            $obj->extencion = $fragmentos[1];
            $response = file_get_contents($returninput);
            $response64 = base64_encode($response);
            $obj->response64 = $response64;
        } catch (\Exception $e) {
            info($e->getMessage());
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $obj,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }
}

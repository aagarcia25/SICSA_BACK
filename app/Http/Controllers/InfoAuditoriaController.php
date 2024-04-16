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
            ofi.Oficio Oficio,
            cto.Descripcion,
            DATE(ofi.FechaVencimiento) AS FechaVencimiento
            
            FROM SICSA.OficiosA ofi
            LEFT JOIN SICSA.auditoria aud on ofi.idAuditoria = aud.id 
            LEFT JOIN SICSA.Cat_Tipos_Oficios cto ON ofi.idOficios = cto.id
            
            WHERE aud.deleted = 0
            AND ofi.deleted = 0
            and aud.NAUDITORIA = ?
                         ";
            $dataSheet1 = DB::select($query, [$auditoria->NAUDITORIA]);
            $count = 11;
            for ($i = 0; $i < count($dataSheet1); ++$i) {
                $sheet1->setCellValue('A' . $count, $dataSheet1[$i]->Oficio);
                $sheet1->setCellValue('B' . $count, $dataSheet1[$i]->FechaVencimiento);
                $sheet1->setCellValue('C' . $count, $dataSheet1[$i]->Descripcion);
                
                
                ++$count;
            }

            
            $query = "
            SELECT 
            sec.Descripcion Secretaria,
            uni.Descripcion UnidadAdministrativa,
            na.Oficio Oficio,
            DATE(na.FOficio) AS FechaOficioNA,
            DATE(na.FRecibido) AS FechaRecibidoNA,
            DATE(na.FVencimiento) AS FechaVencimientoNA,
            DATE(na.Prorroga) AS ProrrogaNA
            FROM SICSA.C_Notificacion_area na
            LEFT JOIN SICSA.auditoria aud on na.idAuditoria = aud.id 
            LEFT JOIN SICSA.cat_unidades uni ON na.idunidad = uni.id 
            LEFT JOIN SICSA.cat_secretarias sec  ON na.idsecretaria = sec.id
            
            WHERE aud.deleted = 0
            AND na.deleted = 0
            and aud.NAUDITORIA = ?
            order by Oficio asc

                         ";
            $dataSheet1 = DB::select($query, [$auditoria->NAUDITORIA]);
            $count = 11;
            for ($i = 0; $i < count($dataSheet1); ++$i) {
                //$sheet1->setCellValue('D' . $count, $dataSheet1[$i]->Secretaria);
                $sheet1->setCellValue('E' . $count, $dataSheet1[$i]->UnidadAdministrativa);
                $sheet1->setCellValue('F' . $count, $dataSheet1[$i]->Oficio);
                $sheet1->setCellValue('G' . $count, $dataSheet1[$i]->FechaOficioNA);
                $sheet1->setCellValue('H' . $count, $dataSheet1[$i]->FechaRecibidoNA);
                $sheet1->setCellValue('I' . $count, $dataSheet1[$i]->FechaVencimientoNA);
                $sheet1->setCellValue('J' . $count, $dataSheet1[$i]->ProrrogaNA);

                ++$count;
            }


            $query = "
            SELECT 
            ca.Oficio Oficio,
          uni.Descripcion UnidadAdministrativa,
          ca.SIGAOficio,
          DATE(ca.FOficio) AS FechaOficioCA,
          DATE(ca.FRecibido) AS FechaRecibidoCA,
          DATE(ca.FVencimiento) AS FechaVencimientoCA,
          DATE(ca.Prorroga) AS ProrrogaCA

          FROM SICSA.C_Contestacion_area ca
          LEFT JOIN SICSA.cat_unidades uni ON ca.idunidad = uni.id 
          LEFT JOIN SICSA.C_Notificacion_area na ON ca.idNotificacion = na.id
          LEFT JOIN SICSA.auditoria aud on na.idAuditoria = aud.id 
          WHERE aud.deleted = 0
          AND na.deleted = 0
          AND ca.deleted = 0
          and aud.NAUDITORIA = ?
          order by Oficio asc

                         ";
            $dataSheet1 = DB::select($query, [$auditoria->NAUDITORIA]);
            $count = 11;
            for ($i = 0; $i < count($dataSheet1); ++$i) {
                //$sheet1->setCellValue('D' . $count, $dataSheet1[$i]->Secretaria);
                $sheet1->setCellValue('L' . $count, $dataSheet1[$i]->UnidadAdministrativa);
                $sheet1->setCellValue('M' . $count, $dataSheet1[$i]->Oficio);
                $sheet1->setCellValue('N' . $count, $dataSheet1[$i]->FechaOficioCA);
                $sheet1->setCellValue('O' . $count, $dataSheet1[$i]->FechaRecibidoCA);
                $sheet1->setCellValue('P' . $count, $dataSheet1[$i]->FechaVencimientoCA);
                $sheet1->setCellValue('Q' . $count, $dataSheet1[$i]->ProrrogaCA);

                ++$count;
            }



            $query = "
            SELECT 
            coa.Descripcion UnidadAdministrativa,
            oc.Oficio Oficio,
            oc.SIGAOficio FolioSIGA,
            DATE(oc.FOficio) AS FechaOficioOC,
            DATE(oc.FRecibido) AS FechaRecibidoOC,
            DATE(oc.FVencimiento) ASFechaVencimientoOC
           
           FROM SICSA.Organo_C oc
           LEFT JOIN SICSA.auditoria aud on oc.idAuditoria = aud.id 
           LEFT JOIN SICSA.Cat_Origen_Auditoria coa ON oc.idOrganoAuditorOrigen = coa.id 
           
           WHERE aud.deleted = 0
           AND oc.deleted = 0
           and aud.NAUDITORIA = ?
                         ";
            $dataSheet1 = DB::select($query, [$auditoria->NAUDITORIA]);
            $count = 11;
            for ($i = 0; $i < count($dataSheet1); ++$i) {
                $sheet1->setCellValue('S' . $count, $dataSheet1[$i]->UnidadAdministrativa);
                $sheet1->setCellValue('T' . $count, $dataSheet1[$i]->Oficio);
                $sheet1->setCellValue('U' . $count, $dataSheet1[$i]->FolioSIGA);
                $sheet1->setCellValue('V' . $count, $dataSheet1[$i]->FechaOficioOC);
                $sheet1->setCellValue('W' . $count, $dataSheet1[$i]->FechaRecibidoOC);
                $sheet1->setCellValue('X' . $count, $dataSheet1[$i]->ASFechaVencimientoOC);
                ++$count;
            }

            $query = "
            SELECT 
                         ta.Descripcion TipoResultado,
                         ea.Descripcion EstatusResultados,
                         ac.monto Monto,
                         ac.ClaveAccion ClaveResultado,
                         ac.TextoAccion ResultadoObservacion,
                         ac.accionSuperviviente ResultadoSuperviviente,
                         ac.numeroResultado NumeroResultado
                         
                         FROM SICSA.acciones ac
                          LEFT JOIN SICSA.auditoria aud on ac.idAuditoria = aud.id 
                          LEFT JOIN SICSA.Cat_Estatus_Acciones ea ON ac.idEstatusAccion = ea.id
                          LEFT JOIN SICSA.Cat_Tipos_Accion ta  ON ac.idTipoAccion = ta.id
                         
                         WHERE 
                         ac.deleted = 0
                         and aud.NAUDITORIA = ?
                         ";
            $dataSheet1 = DB::select($query, [$auditoria->NAUDITORIA]);
            $count = 11;
            for ($i = 0; $i < count($dataSheet1); ++$i) {
                $sheet1->setCellValue('Z' . $count, $dataSheet1[$i]->TipoResultado);
                $sheet1->setCellValue('AA' . $count, $dataSheet1[$i]->EstatusResultados);
                $sheet1->setCellValue('AB' . $count, $dataSheet1[$i]->Monto);
                $sheet1->setCellValue('AC' . $count, $dataSheet1[$i]->ClaveResultado);
                $sheet1->setCellValue('AD' . $count, $dataSheet1[$i]->ResultadoObservacion);
                $sheet1->setCellValue('AE' . $count, $dataSheet1[$i]->ResultadoSuperviviente);
                $sheet1->setCellValue('AF' . $count, $dataSheet1[$i]->NumeroResultado);

                ++$count;
            }

            $query = "
            SELECT
                        
            uni.Descripcion AS AreaNotificada,
            na.Oficio AS OficioNotificación,
            obtenerAsunto(na.Oficio) AS obtenerAsunto,
            DATE(na.FOficio) AS Fecha,
            (SELECT ca.Oficio FROM SICSA.C_Contestacion_area ca WHERE ca.idNotificacion = na.id AND ca.deleted = 0 LIMIT 1) AS OficioContestación,
            (SELECT DATE(ca.FRecibido) FROM SICSA.C_Contestacion_area ca WHERE ca.idNotificacion = na.id AND ca.deleted = 0 LIMIT 1) AS FechaRecibido
           
        FROM
            SICSA.auditoria aud
        LEFT JOIN
            SICSA.C_Notificacion_area na ON aud.id = na.idAuditoria
        LEFT JOIN
            SICSA.cat_unidades uni ON na.idunidad = uni.id
        
            
        WHERE
            aud.NAUDITORIA = ?
        
             AND na.deleted = 0
            
            ORDER BY oficio asc
                         
                     
                         ";
            $dataSheet1 = DB::select($query, [$auditoria->NAUDITORIA]);
            $count = 11;
            for ($i = 0; $i < count($dataSheet1); ++$i) {
                $sheet1->setCellValue('AH' . $count, $dataSheet1[$i]->AreaNotificada);
                $sheet1->setCellValue('AI' . $count, $dataSheet1[$i]->OficioNotificación);
                $sheet1->setCellValue('AJ' . $count, $dataSheet1[$i]->Fecha);
                $sheet1->setCellValue('AK' . $count, $dataSheet1[$i]->obtenerAsunto);
                $sheet1->setCellValue('AL' . $count, $dataSheet1[$i]->OficioContestación);
                $sheet1->setCellValue('AM' . $count, $dataSheet1[$i]->FechaRecibido);
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

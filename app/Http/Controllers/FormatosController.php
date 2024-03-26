<?php

namespace App\Http\Controllers;

use App\Models\Cfolio;
use Illuminate\Http\Request;

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
            if ($request->TIPO == "ADMINISTRATIVO") {

                $inputPath = storage_path('/archivos/ADMINISTRATIVO.docx');
                $outputPath = storage_path('/archivos/ADMINISTRATIVO_TES.docx');
                $param = Cfolio::find($request->CHID);

                $reemplazos = [
                    '${HECHOS}' => $param[0]->Hechos,
                    '${FECHA}' => $param[0]->FechaCreacion,
                    '${UO}' => $param[0]->cuDescripcion,
                    '${FOLIO}' => $param[0]->Folio,
                    '${VICTIMA}' => $param[0]->VictimaNombre,
                    '${VICTIMARIO}' => $param[0]->VictimarioNombre,
                    '${CURPVICTIMA}' => $param[0]->VictimaCURP,
                    '${CURPVICTIMARIO}' => $param[0]->VictimarioCURP,
                    '${IMSSVICTIMA}' => $param[0]->VictimaIMSS,
                    '${IMSSVICTIMARIO}' => $param[0]->VictimarioIMSS,
                    '${RAZONVICTIMA}' => $param[0]->VictimaRazonSocial,
                    '${RAZONVICTIMARIO}' => $param[0]->VictimarioRazonSocial,
                    '${ENTR}' => $param[0]->Entrevista,
                    '${PRUEBA}' => $param[0]->Veritas,
                    '${PSICO}' => $param[0]->PC,
                    '${ESTATUS}' => $param[0]->ceDescripcion,
                    '${ANTECEDENTE}' => $param[0]->Antecedente,
                    '${SEGUIMIENTO}' => $param[0]->Seguimiento,
                    '${CRONOLOGIA}' => $param[0]->Cronologia,
                    '${FUENTEINF}' => $param[0]->Fuenteinf,
                    '${RELEVANTES}' => $param[0]->Relevantes,
                    '${CONCLUSION}' => $param[0]->Conclusion,
                    '${RECOMENDACIONES}' => $param[0]->Recomendacion,

                ];

                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            } else if ($request->TIPO == "SALIDA") {
                $inputPath = storage_path('/archivos/SALIDA.docx');
                $outputPath = storage_path('/archivos/SALIDA_TES.docx');
                $param = Cfolio::find($request->CHID);
                $reemplazos = [
                    '${MOTIVO}' => $param[0]->Motivo,
                    '${FECHA}' => $param[0]->FechaNacimiento,
                    '${FOLIO}' => $param[0]->Folio,
                    '${NOMBRE}' => $param[0]->Nombre,
                    '${NUMEROEMPLEADO}' => $param[0]->NumeroEmpleado,
                    '${EDAD}' => $param[0]->Edad,
                    '${FECHANACIMIENTO}' => $param[0]->FechaNacimiento,
                    '${ESTADOC}' => $param[0]->EstadoC,
                    '${ESCOLARIDAD}' => $param[0]->Escolaridad,
                    '${TELEFONO}' => $param[0]->Telefono,
                    '${CURP}' => $param[0]->CURP,
                    '${RFC}' => $param[0]->RFC,
                    '${SEGURO}' => $param[0]->Seguro,
                    '${CORREO}' => $param[0]->Correo,
                    '${DIRECCION}' => $param[0]->Direccion,
                    '${PRINCIPALHA}' => $param[0]->PrincipalHa,
                    '${PRUEBAVERITAS}' => $param[0]->PruebaVe,
                    '${NORMAS}' => $param[0]->Normas,
                    '${CONFESIONES}' => $param[0]->Confesiones,
                    '${PRUEBACONFIANZA}' => $param[0]->PruebaConfianza,
                    '${ENTREVISTA}' => $param[0]->Entrevista,
                    '${FUENTEINF}' => $param[0]->FuentesInf,
                    '${RELEVANTES}' => $param[0]->Relevantes,
                    '${CONCLUSION}' => $param[0]->Conclusion,
                    '${RECOMENDACIONES}' => $param[0]->Recomendacion,

                ];

                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            } else if ($request->TIPO == "SOLICITUD") {

                $inputPath = storage_path('/informes/SOLICITUD.docx');
                $outputPath = storage_path('/informes/SOLICITUD_TES.docx');
                $obj = Cfolio::find($request->CHID);

                $reemplazos = [
                    '${Folio}' => $obj->Folio,
                    '${Asunto}' => $obj->Asunto,
                    '${Fecha}' => $obj->Fecha,
                    '${SitioWeb}' => $obj->SitioWeb,
                    '${CorreoElectronico}' => $obj->CorreoElectronico,
                    '${Telefonos}' => $obj->Telefonos,
                    '${Sector}' => $obj->Sector,
                    '${Sede}' => $obj->Sede,
                    '${Especialidades}' => $obj->Especialidades,
                    '${Domicilio}' => $obj->Domicilio,
                    '${Sucursales}' => $obj->Sucursales,
                    '${Solistica}' => $obj->Solistica,
                    '${InicioOperaciones}' => $obj->InicioOperaciones,
                    '${SAT}' => $obj->SAT,
                    '${Antecedente}' => $obj->Antecedente,
                    '${ObjetivoInforme}' => $obj->ObjetivoInforme,
                    '${LugaresInteres}' => $obj->LugaresInteres,
                    '${Rutas}' => $obj->Rutas,
                    '${Inteligencia}' => $obj->Inteligencia,
                    '${Seguimiento}' => $obj->Seguimiento,
                    '${Introduccion}' => $obj->Introduccion,
                    '${UbiGeo}' => $obj->UbiGeo,
                    '${IndiceDelictivo}' => $obj->IndiceDelictivo,
                    '${GraficasDelictivas}' => $obj->GraficasDelictivas,
                    '${IncidenciasRelevantes}' => $obj->IncidenciasRelevantes,
                    '${ZonaInteres}' => $obj->ZonaInteres,
                    '${RutasC}' => $obj->RutasC,
                    '${MapaDelictivo}' => $obj->MapaDelictivo,
                    '${AnalisisColindancias}' => $obj->AnalisisColindancias,
                    '${FuenteInformacion}' => $obj->FuenteInformacion,
                    '${Conclusion}' => $obj->Conclusion,
                    '${Relevantes}' => $obj->Relevantes,
                    '${Recomendaciones}' => $obj->Recomendaciones,
                    '${NumeroEmergencia}' => $obj->NumeroEmergencia,
                    '${Bibliografia}' => $obj->Bibliografia
                ];
                $this->remplazarPalabras($inputPath, $outputPath, $reemplazos);
            }


            if ($request->SALIDA == 'word') {
                $rutaCompleta = storage_path('informes' . DIRECTORY_SEPARATOR . $request->TIPO . '_TES.docx');
                $response = base64_encode(file_get_contents($rutaCompleta));
            }




            // unlink($rutaCompleta);
            // unlink($outputPath);
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            $this->encryptData(json_encode(
                [
                    'NUMCODE' => $NUMCODE,
                    'STRMESSAGE' => $STRMESSAGE,
                    'RESPONSE' => $response,
                    'SUCCESS' => $SUCCESS,
                ]
            ))
        );
    }
}

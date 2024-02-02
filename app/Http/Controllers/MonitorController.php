<?php

namespace App\Http\Controllers;

use App\Models\MonitoreoWeb;
use App\Traits\MailTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\DiffOnlyOutputBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;



class MonitorController extends Controller
{
    use MailTrait;
    public function monitorWeb(Request $request)
    {

        // Establecer el nombre del archivo para almacenar el contenido
        $filename = 'contenido_actual.html';

        // Realizar una solicitud HTTP para obtener el contenido actual
        $client = new Client();
        $response = $client->get($request->url);
        $newContent = $response->getBody()->getContents();


        // Verificar si el archivo existe y comparar el contenido
        if (File::exists($filename)) {
            $currentContent = File::get($filename);

            // Comparar el contenido actual con el anterior
            if ($currentContent !== $newContent) {
                // El contenido ha cambiado, puedes realizar acciones aquí
                // por ejemplo, enviar una notificación o guardar el nuevo contenido
                // ...
                // Obtener las diferencias utilizando la biblioteca de Sebastian Bergmann
                $differ = new Differ(new DiffOnlyOutputBuilder("\n"));
                $differences = $differ->diff($currentContent, $newContent);
                $body = "<p>Favor de revisar la siguiente ruta: <strong>{$request->url}</strong></p>";
                $body .= "<br>";
                $body .= "<p>Se ha detectado la siguiente diferencia:</p>";
                $body .= "<br>";
                $body .= "<p>{$differences}</p>";
                $this->sendMailNotificacion("aagarcia@cecapmex.com",  $body);
                // Guardar el nuevo contenido
                File::put($filename, $newContent);
            } else {
                Log::info('sin cambios ' . $request->url);
            }
        } else {
            // El archivo no existe, crea uno y guarda el contenido actual
            File::put($filename, $newContent);
        }

        return response('Monitoreo completado');
    }

    public function monitorWebcron()
    {

        $monitoreos = MonitoreoWeb::all();


        foreach ($monitoreos as $monitoreo) {
            // Obtener la hora actual

            Carbon::setLocale('es');
            $horaActual = Carbon::now('America/Monterrey');
            $url = $monitoreo->Url;
            $alias = $monitoreo->Alias;
            $email = $monitoreo->Correos;
            $tiempo = $monitoreo->Tiempo;
            $ultimaves = $monitoreo->UltimaEjecucion;
            Log::info('Hora de Ejecucion' . $horaActual);
            Log::info('Datos' . $monitoreo);
            $diferenciaEnMinutos = $horaActual->diffInMinutes($ultimaves);

            if ($diferenciaEnMinutos >= $tiempo) {

                try {
                    // Establecer el nombre del archivo para almacenar el contenido
                    // Realizar una solicitud HTTP para obtener el contenido actual
                    $client = new Client();
                    $response = $client->get($url);
                    $newContent = $response->getBody()->getContents();
                    $rutaArchivo = storage_path("archivos/{$alias}.html");
                    Log::info('Ruta de Archivo' . $rutaArchivo);
                    // Verificar si el archivo existe y comparar el contenido
                    if (File::exists($rutaArchivo)) {
                        $currentContent = File::get($rutaArchivo);

                        // Comparar el contenido actual con el anterior
                        if ($currentContent !== $newContent) {
                            $differ = new Differ(new DiffOnlyOutputBuilder("\n"));
                            $differences = $differ->diff($currentContent, $newContent);
                            $body = "<p>Favor de revisar la siguiente ruta: <strong>{$url}</strong></p>";
                            $body .= "<br>";
                            $body .= "<p>Se ha detectado la siguiente diferencia:</p>";
                            $body .= "<br>";
                            $body .= "<p>{$differences}</p>";

                            $correos = explode(
                                ';',
                                $email
                            );

                            foreach ($correos as $correo) {
                                // Limpiar espacios alrededor del correo electrónico
                                $correo = trim($correo);
                                // Enviar notificación a cada dirección de correo electrónico
                                $this->sendMailNotificacion($correo, $body);
                            }


                            File::put($rutaArchivo, $newContent);
                        } else {
                            Log::info('sin cambios ' . $url);
                        }
                    } else {
                        File::put($rutaArchivo, $newContent);
                    }
                    $monitoreo->UltimaEjecucion = $horaActual;
                    $monitoreo->save();
                } catch (\Exception $e) {
                    Log::info('Ruta de Archivo' . $e->getMessage());
                }
            } else {
                Log::info('No se ejecuto el cron');
            }
        }
    }

    public function Monitoreo_index(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new MonitoreoWeb();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Url = $request->Url;
                $OBJ->Correos = $request->Correos;
                $OBJ->Alias = $request->Alias;
                $OBJ->Tiempo = $request->Tiempo;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = MonitoreoWeb::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Url = $request->Url;
                $OBJ->Correos = $request->Correos;
                $OBJ->Alias = $request->Alias;
                $OBJ->Tiempo = $request->Tiempo;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = MonitoreoWeb::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                    SELECT
                    id,
                    deleted,
                    UltimaActualizacion,
                    FechaCreacion,
                    getUserName(ModificadoPor) modi,
                    getUserName(CreadoPor) creado,
                    Url,
                    Correos,
                    Alias,
                    Tiempo,
                    UltimaEjecucion
                    FROM SICSA.MonitoreoWeb
                    where deleted =0
                    order by FechaCreacion desc
                    ";
                $response = DB::select($query);

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
            ]);

    }

}


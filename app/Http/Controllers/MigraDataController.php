<?php

namespace App\Http\Controllers;

use App\Imports\AccioneImport;
use App\Imports\AuditoriaImport;
use App\Models\Cfolio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MigraDataController extends Controller
{

    public function ValidaServicio(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "Servicio Activo";

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,

            ]
        );
    }

    public function migraData(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {

            switch ($request->tipo) {

                case 'migraAcciones':
                    Excel::import(new AccioneImport($request->CHUSER), request()->file('inputfile'), ExcelExcel::XLS);
                    break;
                case 'migraAuditorias':
                    Excel::import(new AuditoriaImport($request->CHUSER), request()->file('inputfile'), ExcelExcel::XLS);
                    break;
                case 'migraoficios':

                    $file = request()->file('inputfile');
                    if ($file) {
                        // Almacenar el archivo temporalmente en el sistema de archivos local
                        $filePath = $file->storeAs('temp', $file->getClientOriginalName());
                        try {
                            // Leer el contenido del archivo Excel usando Maatwebsite/Laravel-Excel
                            $data = Excel::toArray([], $filePath);

                            // Obtener la primera hoja del archivo (ajustar según tu archivo)
                            $sheetData = $data[0];
                            $sheetDataWithoutHeader = array_slice($sheetData, 1);

                            // Iterar sobre las filas

                            foreach ($sheetDataWithoutHeader as $row) {
                                $id = $this->uuidretrun();
                            
                                if ("cancelado" === strtolower($row[1])) {
                                    Log::info("OFICIO CANCELADO: " . $row[0]);
                                    $OBJ = new Cfolio();
                                    $OBJ->id = $id;
                                    $OBJ->ModificadoPor = $request->CHUSER;
                                    $OBJ->CreadoPor = $request->CHUSER;
                                    $OBJ->Oficio = $row[0];
                                    $OBJ->Cancelado = 1;
                                    $OBJ->save();
                                } else {
                                    Log::info("****************************");
                                    Log::info("Filas afectadas: " . $row[0]);
                                    Log::info("Filas afectadas: " . $row[1]);
                                    Log::info("Filas afectadas: " . $row[2]);
                                    Log::info("Filas afectadas: " . $row[3]);
                                    Log::info("Filas afectadas: " . $row[4]);
                                    Log::info("Filas afectadas: " . $row[5]);
                                    Log::info("Filas afectadas: " . $row[6]);
                                    Log::info("Filas afectadas: " . $row[7]);
                            
                                    // Validar si la celda de la fecha no está vacía
                                    $fecha = !empty($row[8]) ? Date::excelToDateTimeObject($row[8])->format('Y-m-d H:i:s') : null;
                                    $fechaRecibido = !empty($row[9]) ? Date::excelToDateTimeObject($row[9])->format('Y-m-d H:i:s') : null;
                            
                                    Log::info("Filas afectadas: " . $fecha);
                                    Log::info("Filas afectadas: " . $fechaRecibido);
                                    Log::info("Filas afectadas: " . $row[10]);
                                    Log::info("****************************");
                            
                                    $OBJ = new Cfolio();
                                    $OBJ->id = $id;
                                    $OBJ->ModificadoPor = $request->CHUSER;
                                    $OBJ->CreadoPor = $request->CHUSER;
                                    $OBJ->Oficio = $row[0];
                                    $OBJ->Cancelado = 0;
                                    $OBJ->Asunto = $row[4];
                                    $OBJ->Tema = $row[5];
                                    $OBJ->Fecha = $fecha; // Asignar null si no hay fecha
                                    $OBJ->FechaRecibido = $fechaRecibido; // Asignar null si no hay fecha recibida
                                    $OBJ->Tema = $row[5];
                                    $OBJ->Observaciones = $row[10];
                                    $OBJ->Destinatario = $OBJ->getDestinataria(strval($row[2]));
                                    $OBJ->Puesto = $row[3];
                                    $OBJ->Solicita = $OBJ->getsolicitante(strval($row[7]));
                                    $OBJ->Nauditoria = $row[6];
                                    $OBJ->save();
                                }
                            }
                            

                            // foreach ($sheetDataWithoutHeader as $row) {
                            //     $id = $this->uuidretrun();

                            //     if ("cancelado" ===  strtolower($row[1])) {
                            //         Log::info("OFICIO CANCELADO: " . $row[0]);
                            //         $OBJ = new Cfolio();
                            //         $OBJ->id = $id;
                            //         $OBJ->ModificadoPor = $request->CHUSER;
                            //         $OBJ->CreadoPor = $request->CHUSER;
                            //         $OBJ->Oficio = $row[0];
                            //         $OBJ->Cancelado = 1;
                            //         $OBJ->save();
                            //     } else {
                            //         Log::info("****************************");
                            //         Log::info("Filas afectadas: " . $row[0]);
                            //         Log::info("Filas afectadas: " . $row[1]);
                            //         Log::info("Filas afectadas: " . $row[2]);
                            //         Log::info("Filas afectadas: " . $row[3]);
                            //         Log::info("Filas afectadas: " . $row[4]);
                            //         Log::info("Filas afectadas: " . $row[5]);
                            //         Log::info("Filas afectadas: " . $row[6]);
                            //         Log::info("Filas afectadas: " . $row[7]);
                            //         Log::info("Filas afectadas: " . Date::excelToDateTimeObject($row[8])->format('Y-m-d H:i:s'));
                            //         Log::info("Filas afectadas: " . Date::excelToDateTimeObject($row[9])->format('Y-m-d H:i:s'));
                            //         Log::info("Filas afectadas: " . $row[10]);
                            //         Log::info("****************************");
                            //         $OBJ = new Cfolio();
                            //         $OBJ->id = $id;
                            //         $OBJ->ModificadoPor = $request->CHUSER;
                            //         $OBJ->CreadoPor = $request->CHUSER;
                            //         $OBJ->Oficio = $row[0];
                            //         $OBJ->Cancelado = 0;
                            //         $OBJ->Asunto = $row[4];
                            //         $OBJ->Tema = $row[5];
                            //         $OBJ->Fecha = Date::excelToDateTimeObject($row[8]);
                            //         $OBJ->FechaRecibido = Date::excelToDateTimeObject($row[9]);
                            //         $OBJ->Tema = $row[5];
                            //         $OBJ->Observaciones = $row[10];
                            //         $OBJ->Destinatario = $OBJ->getDestinataria(strval($row[2]));
                            //         $OBJ->Puesto = $row[3];
                            //         $OBJ->Solicita = $OBJ->getsolicitante(strval($row[7]));
                            //         $OBJ->Nauditoria = $row[6];
                            //         $OBJ->save();
                            //         // Log::info("Destinatario: " . $OBJ->getDestinataria(strval($row[2])));
                            //         // Log::info("Solicita: " . $OBJ->getsolicitante(strval($row[7])));
                            //     }
                            // }


                            DB::update("
                          UPDATE SICSA.cfolios cf
                           SET cf.Anio = (
                            SELECT SUBSTRING(af.Oficio, -4) 
                            FROM SICSA.cfolios af 
                            WHERE af.id = cf.id
                            )
                         WHERE cf.Anio IS NULL
                          ");
                        } catch (\Exception $e) {
                            // Manejar la excepción, por ejemplo, registrarla o mostrar un mensaje al usuario.
                            var_dump($e->getMessage());
                            Log::error('Error al leer el archivo Excel: ' . $e->getMessage());
                            // También podrías redirigir al usuario a una página de error
                        }

                        // Eliminar el archivo temporal después de procesarlo
                        Storage::delete($filePath);
                    }
                    break;

                default:
                    $response = "No se Encuentra configurado para la migración";
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

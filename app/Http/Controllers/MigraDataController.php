<?php

namespace App\Http\Controllers;

use App\Imports\AccioneImport;
use App\Imports\AuditoriaImport;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

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

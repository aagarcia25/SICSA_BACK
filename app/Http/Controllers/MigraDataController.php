<?php

namespace App\Http\Controllers;

use App\Imports\AccioneImport;
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

                default:
                    $response = "No se Encuentra configurado para la migración";
            }
        } catch (\Exception $e) {
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

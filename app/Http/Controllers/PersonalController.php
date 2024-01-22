<?php

namespace App\Http\Controllers;

use App\Models\CatPersonal;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PersonalController extends Controller
{
    //

    public function Personal_index(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new CatPersonal();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Empleado = $request->Empleado;
                $OBJ->Nombre = $request->Nombre;
                $OBJ->Puesto = $request->Puesto;
                $OBJ->RFC = $request->RFC;
                $OBJ->CURP = $request->CURP;
                $OBJ->CorreoElectronico = $request->CorreoElectronico;
                $OBJ->Telefono = $request->Telefono;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = CatPersonal::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Empleado = $request->Empleado;
                $OBJ->Nombre = $request->Nombre;
                $OBJ->Puesto = $request->Puesto;
                $OBJ->RFC = $request->RFC;
                $OBJ->CURP = $request->CURP;
                $OBJ->CorreoElectronico = $request->CorreoElectronico;
                $OBJ->Telefono = $request->Telefono;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = CatPersonal::find($request->CHID);
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
                    Empleado,
                    Nombre,
                    Puesto,
                    RFC,
                    CURP,
                    CorreoElectronico,
                    Telefono
                    FROM SICSA.Cat_Personal
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

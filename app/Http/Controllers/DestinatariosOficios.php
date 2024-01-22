<?php

namespace App\Http\Controllers;

use App\Models\CatDestinatariosOficio;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DestinatariosOficios extends Controller
{
    //

    public function Destinatarios_index(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new CatDestinatariosOficio();
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Titular = $request->Titular;
                $OBJ->Cargo = $request->Cargo;
                $OBJ->Area = $request->Area;
                $OBJ->CorreoElectronico = $request->CorreoElectronico;
                $OBJ->Telefono = $request->Telefono;
                $OBJ->Extension = $request->Extension;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = CatDestinatariosOficio::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Titular = $request->Titular;
                $OBJ->Cargo = $request->Cargo;
                $OBJ->Area = $request->Area;
                $OBJ->CorreoElectronico = $request->CorreoElectronico;
                $OBJ->Telefono = $request->Telefono;
                $OBJ->Extension = $request->Extension;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = CatDestinatariosOficio::find($request->CHID);
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
                    Titular,
                    Cargo,
                    Area,
                    CorreoElectronico,
                    Telefono,
                    Extension
                    FROM SICSA.Cat_Destinatarios_Oficios
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

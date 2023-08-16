<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
     */

    public function Auditoriaindex(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $type = $request->NUMOPERACION;

            if ($type == 1) {
                $OBJ = new Auditorium();

                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->CreadoPor = $request->CHUSER;
                $OBJ->Tipo = $request->CHUSER;
                $OBJ->Anio = $request->Anio;
                $OBJ->FolioSIGA = $request->FolioSIGA;
                $OBJ->Encargado = $request->Encargado;
                $OBJ->PersonalEncargado = $request->PersonalEncargado;
                $OBJ->NAUDITORIA = $request->NAUDITORIA;
                $OBJ->Anio = $request->Anio;
                $OBJ->NombreAudoria = $request->NombreAudoria;
                $OBJ->ActaInicio = $request->ActaInicio;
                $OBJ->idCatInforme = $request->idCatInforme;
                $OBJ->idTipoAuditoria = $request->idTipoAuditoria;
                $OBJ->idCatSector = $request->idCatSector;
                $OBJ->idCatEntidadFiscalizada = $request->idCatEntidadFiscalizada;
                $OBJ->idCatGrupoFuncional = $request->idCatGrupoFuncional;
                $OBJ->universopesos = $request->universopesos;
                $OBJ->muestrapesos = $request->muestrapesos;
                
                $OBJ->save();
                $response = $OBJ;
                
            } elseif ($type == 2) {

                $OBJ = Auditorium::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->Tipo = $request->CHUSER;
                $OBJ->Anio = $request->Anio;
                $OBJ->FolioSIGA = $request->FolioSIGA;
                $OBJ->Encargado = $request->Encargado;
                $OBJ->PersonalEncargado = $request->PersonalEncargado;
                $OBJ->NAUDITORIA = $request->NAUDITORIA;
                $OBJ->Anio = $request->Anio;
                $OBJ->NombreAudoria = $request->NombreAudoria;
                $OBJ->ActaInicio = $request->ActaInicio;
                $OBJ->idCatInforme = $request->idCatInforme;
                $OBJ->idTipoAuditoria = $request->idTipoAuditoria;
                $OBJ->idCatSector = $request->idCatSector;
                $OBJ->idCatEntidadFiscalizada = $request->idCatEntidadFiscalizada;
                $OBJ->idCatGrupoFuncional = $request->idCatGrupoFuncional;
                $OBJ->universopesos = $request->universopesos;
                $OBJ->muestrapesos = $request->muestrapesos;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 3) {
                $OBJ = Auditorium::find($request->CHID);
                $OBJ->deleted = 1;
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 4) {

                $query = "
                    SELECT
                    aud.id,
                    aud.deleted,
                    aud.UltimaActualizacion,
                    aud.FechaCreacion,
                    getUserName(aud.ModificadoPor) modi,
                    getUserName(aud.CreadoPor) creado,
                    aud.Consecutivo,
                    aud.FolioSIGA,
                    aud.Encargado,
                    aud.PersonalEncargado,
                    aud.NAUDITORIA,
                    aud.NombreAudoria,
                    aud.ActaInicio,
                    ci.id ciid,
                    ci.Descripcion ciDescripcion,
                    cta.id ctaid,
                    cta.Descripcion ctaDescripcion,
                    cef.id cefid,
                    cef.Descripcion cefDescripcion,
                    cgf.id cgfid,
                    cgf.Descripcion cgfDescripcion,
                    cs.id csid,
                    cs.Descripcion csDescripcion,
                    cs.id csid,
                    cs.Descripcion csDescripcion
                    FROM SICSA.auditoria   aud
                    LEFT JOIN SICSA.Cat_Informes ci ON aud.idCatInforme = ci.id
                    LEFT JOIN SICSA.Cat_Tipos_Auditoria cta ON aud.idTipoAuditoria = cta.id
                    LEFT JOIN SICSA.Cat_Sector cs ON aud.idCatSector = cs.id
                    LEFT JOIN SICSA.Cat_Entidad_Fiscalizada cef ON cef.id=aud.idCatEntidadFiscalizada
                    LEFT JOIN SICSA.Cat_Grupo_Funcional  cgf ON aud.idCatGrupoFuncional = cgf.id
                    where aud.deleted =0
                    order by aud.Consecutivo asc
                    ";
                $response = DB::select($query);

            }
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

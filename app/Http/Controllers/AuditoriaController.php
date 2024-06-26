<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
{
    /* SE IDENTIFICA EL TIPO DE OPERACION A REALIZAR
    1._ INSERTAR UN REGISTRO
    2._ ACTUALIZAR UN REGISTRO
    3._ ELIMINAR UN REGISTRO
    4._ CONSULTAR GENERAL DE REGISTROS, (SE INCLUYEN FILTROS)
    5._ CAMBIA EL ESTADO DE ENTREGA DE LA AUDITRIA
    9._ ELIMINA REGISTROS SELECCIONADOS
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
                $OBJ->anio = $request->anio;
                $OBJ->NAUDITORIA = $request->NAUDITORIA;
                $OBJ->FolioSIGA = $request->FolioSIGA;
                $OBJ->idModalidad = $request->idModalidad;
                $OBJ->Consecutivo = $request->Consecutivo;
                $OBJ->ActaInicio = $request->ActaInicio;
                $OBJ->NombreAudoria = $request->NombreAudoria;
                $OBJ->Encargado = $request->Encargado;
                $OBJ->PersonalEncargado = $request->PersonalEncargado;
                $OBJ->idClasificacion = $request->idClasificacion;
                $OBJ->idcatorigenaud = $request->idcatorigenaud;
                $OBJ->idCatGrupoFuncional = $request->idCatGrupoFuncional;
                $OBJ->idCatSector = $request->idCatSector;
                $OBJ->idCatEntidadFiscalizada = $request->idCatEntidadFiscalizada;
                $OBJ->idTipoAuditoria = $request->idTipoAuditoria;
                //$OBJ->idCatInforme = $request->idCatInforme;
                $OBJ->idUnidadAdm = $request->idUnidadAdm;
                $OBJ->idAreaAdm = $request->idAreaAdm;
                $OBJ->idRamo = $request->idRamo;
                $OBJ->universopesos = $request->universopesos;
                $OBJ->muestrapesos = $request->muestrapesos;
                $OBJ->idInicioauditoria = $request->inicio;
                $OBJ->idmunicipio = $request->municipio;
                $OBJ->idEstatus = $request->idEstatus;
                $OBJ->montoauditado = $request->montoauditado;

                $OBJ->save();
                $response = $OBJ;

            } elseif ($type == 2) {

                $OBJ = Auditorium::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                $OBJ->anio = $request->anio;
                $OBJ->NAUDITORIA = $request->NAUDITORIA;
                $OBJ->FolioSIGA = $request->FolioSIGA;
                $OBJ->idModalidad = $request->idModalidad;
                $OBJ->Consecutivo = $request->Consecutivo;
                $OBJ->ActaInicio = $request->ActaInicio;
                $OBJ->NombreAudoria = $request->NombreAudoria;
                $OBJ->Encargado = $request->Encargado;
                $OBJ->PersonalEncargado = $request->PersonalEncargado;
                $OBJ->idClasificacion = $request->idClasificacion;
                $OBJ->idcatorigenaud = $request->idcatorigenaud;
                $OBJ->idCatGrupoFuncional = $request->idCatGrupoFuncional;
                $OBJ->idCatSector = $request->idCatSector;
                $OBJ->idCatEntidadFiscalizada = $request->idCatEntidadFiscalizada;
                $OBJ->idTipoAuditoria = $request->idTipoAuditoria;
                //$OBJ->idCatInforme = $request->idCatInforme;
                $OBJ->idUnidadAdm = $request->idUnidadAdm;
                $OBJ->idAreaAdm = $request->idAreaAdm;
                $OBJ->idRamo = $request->idRamo;
                $OBJ->universopesos = $request->universopesos;
                $OBJ->muestrapesos = $request->muestrapesos;
                $OBJ->idInicioauditoria = $request->inicio;
                $OBJ->idmunicipio = $request->municipio;
                $OBJ->idEstatus = $request->idEstatus;
                $OBJ->montoauditado = $request->montoauditado;

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
                    aud.entregado,
                    aud.id,
                    aud.deleted,
                    aud.UltimaActualizacion,
                    aud.FechaCreacion,
                    getUserName(aud.ModificadoPor) modi,
                    getUserName(aud.CreadoPor) creado,
                    aud.anio,
                    aud.NAUDITORIA,
                    aud.FolioSIGA,
                    aud.Consecutivo,
					aud.ActaInicio,
					aud.NombreAudoria,
					aud.Encargado,
                    aud.PersonalEncargado,
                    
                    ct.id ctid,
					ct.Descripcion ctDescripcion,
					coa.id coaid,
					coa.Descripcion coaDescripcion,
                    cgf.id cgfid,
                    cgf.Descripcion cgfDescripcion,
					cs.id csid,
                    cs.Descripcion csDescripcion,
                    cef.id cefid,
                    cef.Descripcion cefDescripcion,
                    cta.id ctaid,
                    cta.Descripcion ctaDescripcion,
                    
                    cuaa.id cuaaid,
                    cuaa.Descripcion cuaaDescripcion,
                    caa.id caaid,
                    caa.Descripcion caaDescripcion,
                    cr.id crid,
                    cea.id ceaid,
                    cea.Descripcion ceaDescripcion,
                    cia.Descripcion ciaDescripcion,
                    cia.id ciaid,
                    mun.id munid,
                    mun.Nombre munNombre,
                    cr.Descripcion crDescripcion,
					aud.universopesos,
                    mun.Nombre,
					aud.muestrapesos,
                    aud.montoauditado,
                    cmo.Descripcion cmoDescripcion,
                    cmo.id cmoid
                    FROM SICSA.auditoria   aud
                    LEFT JOIN SICSA.cat_tipo ct ON aud.idClasificacion = ct.id
                    LEFT JOIN SICSA.Cat_Origen_Auditoria coa ON aud.idcatorigenaud = coa.id
                    LEFT JOIN SICSA.Cat_Grupo_Funcional  cgf ON aud.idCatGrupoFuncional = cgf.id
                    LEFT JOIN SICSA.Cat_Sector cs ON aud.idCatSector = cs.id
                    LEFT JOIN SICSA.Cat_Entidad_Fiscalizada cef ON cef.id=aud.idCatEntidadFiscalizada
                    LEFT JOIN SICSA.Cat_Tipos_Auditoria cta ON aud.idTipoAuditoria = cta.id
                    LEFT JOIN SICSA.Cat_Unidad_Admin_Auditora cuaa ON aud.idUnidadAdm = cuaa.id
                    LEFT JOIN SICSA.cat_area_auditoras caa ON aud.idAreaAdm = caa.id
                    LEFT JOIN SICSA.cat_ramo cr ON aud.idRamo = cr.id
                    LEFT JOIN SICSA.cat_estatus_auditoria cea ON aud.idEstatus = cea.id
                    LEFT JOIN SICSA.cat_inicio_auditoria cia ON aud.idInicioauditoria = cia.id
                    LEFT JOIN SICSA.Municipios mun ON aud.idmunicipio = mun.id
                    LEFT JOIN SICSA.Cat_Modalidad cmo ON aud.idModalidad = cmo.id

                    where aud.deleted =0

                    ";

                if ($request->FolioSIGA != "") {
                    $query = $query . " and    aud.FolioSIGA='" . $request->FolioSIGA . "'";
                }

                if ($request->NAUDITORIA != "") {
                    $query = $query . " and    aud.NAUDITORIA=" . $request->NAUDITORIA;
                }
                if ($request->anio != "") {
                    $query = $query . " and    aud.anio='" . $request->anio . "'";
                }
                if ($request->idEstatus != "") {
                    $query = $query . " and    cea.id='" . $request->idEstatus . "'";
                }
                if ($request->idInicioauditoria != "") {
                    $query = $query . " and    cia.id='" . $request->idInicioauditoria . "'";
                }
                if ($request->idModalidad != "") {
                    $query = $query . " and    cmo.id='" . $request->idModalidad . "'";
                }
                if ($request->idmunicipio != "") {
                    $query = $query . " and    mun.id='" . $request->idmunicipio . "'";
                }

                if ($request->tipo != "") {
                    $query = $query . " and    ct.id='" . $request->tipo . "'";
                }

                if ($request->ente != "") {
                    $query = $query . " and    coa.id='" . $request->ente . "'";
                }

                if ($request->idCatEntidadFiscalizada != "") {
                    $query = $query . " and    cef.id='" . $request->idCatEntidadFiscalizada . "'";
                }

                $query = $query . "   order by aud.Consecutivo asc";

                $response = DB::select($query);

            }elseif ($type == 5) {
                $OBJ = Auditorium::find($request->CHID);
                $OBJ->ModificadoPor = $request->CHUSER;
                //$OBJ->entregado = 1;

                if ($OBJ->entregado == 1) {
                    $OBJ->entregado = 0;
                } else {
                    $OBJ->entregado = 1;
                }

                $OBJ->save();
                $response = $OBJ;

            }else if ($type == 9) {
                $CHIDs = $request->input('CHIDs'); 
                $response = [];

                foreach ($CHIDs as $CHID) {
                $OBJ = Auditorium::find($CHID);

                    if ($OBJ) {
                    $OBJ->deleted = 1;
                    $OBJ->ModificadoPor = $request->CHUSER;
                    $OBJ->save();
                    $response[] = $OBJ;
                    }
                }
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

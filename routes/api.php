<?php

use App\Http\Controllers\AccionesController;
use App\Http\Controllers\AniosController;
use App\Http\Controllers\Area_AuditoraController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ContestacionController;
use App\Http\Controllers\Entidad_FiscalizadaController;
use App\Http\Controllers\Estatus_AccionesController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\Grupo_FuncionalController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\MigraDataController;
use App\Http\Controllers\ModalidadController;
use App\Http\Controllers\MunicipiosController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\OficiosAController;
use App\Http\Controllers\Origen_AuditoriaController;
use App\Http\Controllers\plandetrabajoAnualController;
use App\Http\Controllers\PlandetrabajoController;
use App\Http\Controllers\PreguntasFrecuentesController;
use App\Http\Controllers\RamoController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SelectController;
use App\Http\Controllers\TiposAccionController;
use App\Http\Controllers\Tipos_AuditoriaController;
use App\Http\Controllers\Unidad_Admin_AuditoraController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::group([
    'prefix' => 'Api_SICSA',
], function () {

    Route::post('ValidaServicio', [MigraDataController::class, 'ValidaServicio']);
    Route::post('migraData', [MigraDataController::class, 'migraData']);
    Route::post('aniosindex', [AniosController::class, 'aniosindex']);
    Route::post('Ramo_index', [RamoController::class, 'Ramo_index']);
    Route::post('Acciones_index', [AccionesController::class, 'Acciones_index']);
    Route::post('Auditoriaindex', [AuditoriaController::class, 'Auditoriaindex']);
    Route::post('Notificacionindex', [NotificacionController::class, 'Notificacionindex']);
    Route::post('Contestacionindex', [ContestacionController::class, 'Contestacionindex']);
    Route::post('Filesindex', [FilesController::class, 'Filesindex']);
    Route::post('Entidad_Fiscalizada_index', [Entidad_FiscalizadaController::class, 'Entidad_Fiscalizada_index']);
    Route::post('Estatus_Acciones_index', [Estatus_AccionesController::class, 'Estatus_Acciones_index']);
    Route::post('Grupo_Funcional_index', [Grupo_FuncionalController::class, 'Grupo_Funcional_index']);
    Route::post('Informes_index', [InformesController::class, 'Informes_index']);
    Route::post('Origen_Auditoria_index', [Origen_AuditoriaController::class, 'Origen_Auditoria_index']);
    Route::post('Sector_index', [SectorController::class, 'Sector_index']);
    Route::post('TiposAccion_index', [TiposAccionController::class, 'TiposAccion_index']);
    Route::post('Tipos_Auditoria_index', [Tipos_AuditoriaController::class, 'Tipos_Auditoria_index']);
    Route::post('Unidad_Admin_Auditora_index', [Unidad_Admin_AuditoraController::class, 'Unidad_Admin_Auditora_index']);
    Route::post('SelectIndex', [SelectController::class, 'SelectIndex']);
    Route::post('OficiosA_index', [OficiosAController::class, 'OficiosA_index']);
    Route::post('areaindex', [Area_AuditoraController::class, 'areaindex']);
    Route::post('planindex', [PlandetrabajoController::class, 'planindex']);
    Route::post('planAnualindex', [plandetrabajoAnualController::class, 'planAnualindex']);
    Route::post('Municipios_index', [MunicipiosController::class, 'Municipios_index']);
    Route::post('Modalidad_index', [ModalidadController::class, 'Modalidad_index']);
    Route::post('AdminAyudas', [PreguntasFrecuentesController::class, 'AdminAyudas']);
    Route::post('AdminVideoTutoriales', [PreguntasFrecuentesController::class, 'AdminVideoTutoriales']);
    Route::post('AdminPreguntasFrecuentes', [PreguntasFrecuentesController::class, 'AdminPreguntasFrecuentes']);
    Route::post('AdminGuiaRapida', [PreguntasFrecuentesController::class, 'AdminGuiaRapida']);
    Route::post('obtenerguias', [PreguntasFrecuentesController::class, 'obtenerguias']);
    Route::post('obtenerDoc', [PreguntasFrecuentesController::class, 'obtenerDoc']);

});

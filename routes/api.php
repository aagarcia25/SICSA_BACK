<?php

use App\Http\Controllers\AniosController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Entidad_FiscalizadaController;
use App\Http\Controllers\Estatus_AccionesController;
use App\Http\Controllers\Grupo_FuncionalController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\Origen_AuditoriaController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\Tipos_AuditoriaController;
use App\Http\Controllers\TiposAccionController;
use App\Http\Controllers\Unidad_Admin_AuditoraController;
use Illuminate\Http\Request;
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
    'prefix' => 'Api_SICSA'
], function () {


        Route::post('aniosindex',                  [AniosController::class, 'aniosindex']);
        Route::post('Auditoriaindex',              [AuditoriaController::class, 'Auditoriaindex']);
        Route::post('Entidad_Fiscalizada_index',   [Entidad_FiscalizadaController::class, 'Entidad_Fiscalizada_index']);
        Route::post('Estatus_Acciones_index',      [Estatus_AccionesController::class, 'Estatus_Acciones_index']);
        Route::post('Grupo_Funcional_index',       [Grupo_FuncionalController::class, 'Grupo_Funcional_index']);
        Route::post('Informes_index',              [InformesController::class, 'Informes_index']);
        Route::post('Origen_Auditoria_index',      [Origen_AuditoriaController::class, 'Origen_Auditoria_index']);
        Route::post('Sector_index',                [SectorController::class, 'Sector_index']);
        Route::post('TiposAccion_index',           [TiposAccionController::class, 'TiposAccion_index']);
        Route::post('Tipos_Auditoria_index',       [Tipos_AuditoriaController::class, 'Tipos_Auditoria_index']);
        Route::post('Unidad_Admin_Auditora_index', [Unidad_Admin_AuditoraController::class, 'Unidad_Admin_Auditora_index']);

});

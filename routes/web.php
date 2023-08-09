<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;

use App\Http\Controllers\Personal\PcmController;
use App\Http\Controllers\Personal\PcmTabController;
use App\Http\Controllers\Personal\AsesoresController;
use App\Http\Controllers\Personal\AsesoresTabController;
use App\Http\Controllers\Asistencia\AsistenciaController;


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    //PAGINA DE INICIO
    Route::get('/' , [PagesController::class, 'index'])->name('inicio');


    Route::group(['prefix'=>'personal','as'=>'personal.' ],function () {

        //////  ASESORES

        Route::get('/asesores' , [AsesoresController::class, 'asesores'])->name('asesores');
        Route::get('/tablas/tb_asesores' , [AsesoresTabController::class, 'tb_asesores'])->name('tablas.tb_asesores');
        Route::post('/modals/md_add_asesores' , [AsesoresController::class, 'md_add_asesores'])->name('modals.md_add_asesores');
        Route::post('/store_asesores' , [AsesoresController::class, 'store_asesores'])->name('store_asesores');
        Route::post('/modals/md_edit_asesores' , [AsesoresController::class, 'md_edit_asesores'])->name('modals.md_edit_asesores');
        Route::post('/update_asesores' , [AsesoresController::class, 'update_asesores'])->name('update_asesores');
        Route::post('/delete_asesores' , [AsesoresController::class, 'delete_asesores'])->name('delete_asesores');

        //////  PCM

        Route::get('/asesores' , [AsesoresController::class, 'asesores'])->name('asesores');
        Route::get('/tb_asesores' , [AsesoresController::class, 'tb_asesores'])->name('tb_asesores');

    });

    Route::group(['prefix'=>'asistencia','as'=>'asistencia.' ],function () {

        Route::get('/asistencia' , [AsistenciaController::class, 'asistencia'])->name('asistencia');
        Route::get('/tablas/tb_asistencia' , [AsistenciaController::class, 'tb_asistencia'])->name('tablas.tb_asistencia');
        Route::post('/modals/md_add_asistencia' , [AsistenciaController::class, 'md_add_asistencia'])->name('modals.md_add_asistencia');
        Route::post('/store_asistencia' , [AsistenciaController::class, 'store_asistencia'])->name('store_asistencia');

    });
});


<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;


use App\Http\Controllers\Personal\PcmController;
use App\Http\Controllers\Almacen\AlmacenController;
use App\Http\Controllers\Personal\BienesController;
use App\Http\Controllers\Personal\PcmTabController;
use App\Http\Controllers\Personal\AsesoresController;
use App\Http\Controllers\Inventari\InventarioController;
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

    Route::group(['prefix'=>'almacen','as'=>'almacen.' ],function () {

        Route::get('/almacen' , [AlmacenController::class, 'almacen'])->name('almacen');
        Route::get('/tablas/tb_almacen' , [AlmacenController::class, 'tb_almacen'])->name('tablas.tb_almacen');

    });

    Route::group(['prefix'=>'inventario','as'=>'inventario.' ],function () {

        Route::get('/inventario' , [InventarioController::class, 'inventario'])->name('inventario');
        Route::get('/tablas/tb_inventario' , [InventarioController::class, 'tb_inventario'])->name('tablas.tb_inventario');
        Route::get('/asignacion_inventario/{id}' , [InventarioController::class, 'asignacion_inventario'])->name('asignacion_inventario');
        Route::get('/tablas/tb_asig_b' , [InventarioController::class, 'tb_asig_b'])->name('tablas.tb_asig_b');
        Route::post('/modals/md_add_producto' , [InventarioController::class, 'md_add_producto'])->name('modals.md_add_producto');
        Route::get('/tablas/tb_add_producto' , [InventarioController::class, 'tb_add_producto'])->name('tablas.tb_add_producto');
        Route::post('/storeproducto_ass' , [InventarioController::class, 'storeproducto_ass'])->name('storeproducto_ass');
        Route::post('/deleteproducto_ass' , [InventarioController::class, 'deleteproducto_ass'])->name('deleteproducto_ass');
        Route::post('/modals/md_add_observacion' , [InventarioController::class, 'md_add_observacion'])->name('modals.md_add_observacion');
        Route::post('/store_obser_ass' , [InventarioController::class, 'store_obser_ass'])->name('store_obser_ass');

    });

    Route::group(['prefix'=>'m_bienes','as'=>'m_bienes.' ],function () {
        Route::get('/m_bien' , [BienesController::class, 'm_bien'])->name('m_bien');
    }); 

});


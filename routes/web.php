<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LineasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Routing\RouteAction;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('users',[UserController::class,'index'])->name('admin.user.index');
Route::get('users/edit/{id}',[UserController::class,'edit'])->name('admin.user.edit');
Route::match(['get', 'post'], '/users/update',[UserController::class,'update'])->name('admin.user.update');

Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios/store', [UsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/edit/{id}',[UsuariosController::class, 'edit'])->name('usuarios.edit');
Route::post('/usuarios/update/{id}',[UsuariosController::class, 'update'])->name('usuarios.update');
Route::get('/usuarios/reasignar/{id}',[UsuariosController::class, 'reasignar'])->name('usuarios.reasignar');
Route::post('/usuarios/guardarResignar',[UsuariosController::class, 'guardarReasignar'])->name('usuarios.guardarResignar');
Route::get('/usuarios/buscar',[UsuariosController::class, 'buscar'])->name('usuarios.buscar');


Route::get('/lineas', [LineasController::class, 'index'])->name('lineas.index');
Route::get('/lineas/create', [LineasController::class, 'create'])->name('lineas.create');
Route::post('/lineas/store', [LineasController::class, 'store'])->name('lineas.store');
Route::get('/lineas/edit/{id}',[LineasController::class, 'edit'])->name('lineas.edit');
Route::match(['get', 'post'],'/lineas/update/{id}',[LineasController::class, 'update'])->name('lineas.update');
Route::get('/lineas/reasignar/{id}',[LineasController::class, 'reasignar'])->name('lineas.reasignar');
Route::post('/lineas/guardarResignar',[LineasController::class, 'guardarReasignar'])->name('lineas.guardarResignar');
Route::get('/lineas/exportar/excel',[LineasController::class, 'exportarExcel'])->name('lineas.exportarExcel');
Route::get('/lineas/exportar/csv',[LineasController::class, 'exportarCsv'])->name('lineas.exportarCsv');
Route::get('/lineas/buscar',[LineasController::class, 'buscar'])->name('lineas.buscar');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

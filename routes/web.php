<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProcedureController;
use Illuminate\Contracts\Auth\UserProvider;

// Home (bebas diakses tanpa login)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman login admin
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login_process'])->name('login_process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//Route::get('/adminhome', [AdminHomeController::class, 'index'])->name('adminhome');


Route::get('/adminhome', function () {
    return view('adminhome');   // atau kalau ada controller khusus admin, bisa panggil controller di sini
})->name('adminhome');
Route::get('/adminhome', [AdminHomeController::class, 'index'])->name('adminhome');
// Logout

Route::middleware([AuthAdmin::class])->group(function () {
    // Procedure (hanya bisa diakses setelah login)
    Route::get('/procedure', [ProcedureController::class, 'index'])->name('procedure');
    Route::get('/procedures', [ProcedureController::class, 'index'])->name('procedures');
    Route::get('/procedures/create', [ProcedureController::class, 'create'])->name('procedures.create');
    Route::post('/procedures', [ProcedureController::class, 'store'])->name('procedures.store');
    Route::get('/procedures/{procedure}/edit', [ProcedureController::class, 'edit'])->name('procedures.edit');
    Route::put('/procedures/{id}/update', [ProcedureController::class, 'update'])->name('procedures.update');
    Route::delete('/procedures/{procedure}', [ProcedureController::class, 'destroy'])->name('procedures.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/upload', [UploadController::class, 'index'])->name('upload');
    Route::get('/uploads', [UploadController::class, 'index'])->name('uploads');
    Route::get('/uploads/create', [UploadController::class, 'create'])->name('uploads.create');
    Route::post('/uploads', [UploadController::class, 'store'])->name('uploads.store');
    Route::get('/uploads/{upload}/edit', [UploadController::class, 'edit'])->name('uploads.edit');
    Route::put('/uploads/{id}', [UploadController::class, 'update'])->name('uploads.update');
    Route::delete('/uploads/{upload}', [UploadController::class, 'destroy'])->name('uploads.destroy');

    Route::get('/procedure/tractor', [ProcedureController::class, 'index'])->name('procedure');
    Route::post('/procedure/tractor/create', [ProcedureController::class, 'create_tractor'])->name('procedure.tractor.create');
    Route::put('/procedure/tractor/update/{Id_Tractor}', [ProcedureController::class, 'update_tractor'])->name('procedure.tractor.update');
    Route::delete('/procedure/tractor/delete/{Id_Tractor}', [ProcedureController::class, 'destroy_tractor'])->name('procedure.tractor.destroy');

    Route::get('/procedure/tractor/area/{Name_Tractor}', [ProcedureController::class, 'index_area'])->name('procedure.area.index');
    Route::post('/procedure/tractor/area/create', [ProcedureController::class, 'create_area'])->name('procedure.area.create');
    Route::put('/procedure/tractor/area/update/{Id_Area}', [ProcedureController::class, 'update_area'])->name('procedure.area.update');
    Route::delete('/procedure/tractor/area/delete/{Id_Area}', [ProcedureController::class, 'destroy_area'])->name('procedure.area.destroy');

    Route::get('/procedure/tractor/area/procedure/{Name_Tractor}/{Name_Area}', [ProcedureController::class, 'index_procedure'])->name('procedure.procedure.index');
    Route::post('/procedure/tractor/area/procedure/create', [ProcedureController::class, 'create_procedure'])->name('procedure.procedure.create');
    Route::post('/procedure/tractor/area/procedure/item', [ProcedureController::class, 'insert_item_procedure'])->name('procedure.procedure.item');
    Route::put('/procedure/tractor/area/procedure/update/{Id_Procedure}', [ProcedureController::class, 'update_procedure'])->name('procedure.procedure.update');
    Route::put('/procedure/tractor/area/procedure/upload/{Id_Procedure}', [ProcedureController::class, 'upload_procedure'])->name('procedure.procedure.upload');
    Route::delete('/procedure/tractor/area/procedure/delete/{Id_Procedure}', [ProcedureController::class, 'destroy_procedure'])->name('procedure.procedure.destroy');

});


Route::get('/userprocedure/tractor', [UserProcedureController::class, 'index'])->name('userprocedure');
Route::post('/userprocedure/tractor/create', [UserProcedureController::class, 'create_tractor'])->name('userprocedure.tractor.create');
Route::put('/userprocedure/tractor/update/{Id_Tractor}', [UserProcedureController::class, 'update_tractor'])->name('userprocedure.tractor.update');
Route::delete('/userprocedure/tractor/delete/{Id_Tractor}', [UserProcedureController::class, 'destroy_tractor'])->name('userprocedure.tractor.destroy');

Route::get('/userprocedure/tractor/area/{Name_Tractor}', [UserProcedureController::class, 'index_area'])->name('userprocedure.area.index');
Route::post('/userprocedure/tractor/area/create', [UserProcedureController::class, 'create_area'])->name('userprocedure.area.create');
Route::put('/userprocedure/tractor/area/update/{Id_Area}', [UserProcedureController::class, 'update_area'])->name('userprocedure.area.update');
Route::delete('/userprocedure/tractor/area/delete/{Id_Area}', [UserProcedureController::class, 'destroy_area'])->name('userprocedure.area.destroy');

Route::get('/userprocedure/tractor/area/procedure/{Name_Tractor}/{Name_Area}', [UserProcedureController::class, 'index_procedure'])->name('userprocedure.procedure.index');
Route::post('/userprocedure/tractor/area/procedure/create', [UserProcedureController::class, 'create_procedure'])->name('userprocedure.procedure.create');
Route::post('/userprocedure/tractor/area/procedure/item', [UserProcedureController::class, 'insert_item_procedure'])->name('userprocedure.procedure.item');
Route::put('/userprocedure/tractor/area/procedure/update/{Id_Procedure}', [UserProcedureController::class, 'update_procedure'])->name('userprocedure.procedure.update');
Route::put('/userprocedure/tractor/area/procedure/upload/{Id_Procedure}', [UserProcedureController::class, 'upload_procedure'])->name('userprocedure.procedure.upload');
Route::delete('/userprocedure/tractor/area/procedure/delete/{Id_Procedure}', [UserProcedureController::class, 'destroy_procedure'])->name('userprocedure.procedure.destroy');

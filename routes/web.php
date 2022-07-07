<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('landingpage.landingpage');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::resource('users', \App\Http\Controllers\UserController::class);
    // Route::get('users/create/getUnitkerja/{id}', function ($id) {
    //     $unitkerja = App\Models\Unitkerja::where('id_opd',$id)->get();
    //     return response()->json($unitkerja);
    // });
    // Route::get('users/create/getunitkerja/{id}', [\App\Http\Controllers\UserController::class, 'getUnitkerja'])->name('getUnitkerja');
    Route::get('users/create/getunitkerja/', [\App\Http\Controllers\UserController::class, 'getUnitkerja'])->name('getUnitkerja');
});


Route::get('/dashboard', function() {
    return view('adminkab.index');
})->name('dashboard')->middleware('auth');

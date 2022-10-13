<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminGameController;

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
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'index']);

Route::get('/admin/jogos/novo', [AdminGameController::class, 'create']);
Route::get('/admin/jogos/{game}', [AdminGameController::class, 'edit'])->name('games.edit');

Route::get('/admin/jogos/{game}/tecnicos', [AdminGameCrewController::class, 'editTechnicalCast']);
Route::get('/admin/jogos/{game}/vozes', [AdminGameCrewController::class, 'editVoiceCast']);

Route::put('/admin/jogos/{game}/vozes', [AdminGameCrewController::class, 'updateVoiceCast']);


Route::post('/admin/jogos/novo', [AdminGameController::class, 'store'])->name('games.store');
Route::put('/admin/jogos/{game}', [AdminGameController::class, 'update'])->name('games.update');
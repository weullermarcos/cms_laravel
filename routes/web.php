<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

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

//Parte frontal do sistema
Route::get('/', [HomeController::class, 'index']);


//criando grupo para rotas do painel - Parte "de trás" do sistema
Route::prefix('painel')->group(function (){

    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');

    //rota para login
    Route::get('login', [LoginController::class, 'index'])->name('login');

});

//Auth::routes();

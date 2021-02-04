<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Site\HomeController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\ProfileController;
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

    //rota para página de login
    Route::get('login', [LoginController::class, 'index'])->name('login');

    //rota para realizar autenticação
    Route::post('login', [LoginController::class, 'authenticate']);

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('logout', [LoginController::class, 'logout'])->name('painel.logout');

//    Route::get('users', [UserController::class, 'index'])->name('users');

    //equivale ao crud para rotas de usuários
    Route::resource('users', UserController::class);

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');

    Route::put('profilesave', [ProfileController::class, 'save'])->name('profile.save');

});

//Auth::routes();

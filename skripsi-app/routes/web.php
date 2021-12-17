<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\WebController;
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

// Route::get('/', function () {
//     return view('home');
// })->name('index');

Route::get('/', [WebController::class, 'index'])->name('index');

// Route::get('/hasilAHP', [MainController::class, 'check'])->name('hasilAHP');
// Route::get('/hasilTOPSIS', [MainController::class, 'check'])->name('hasilTOPSIS');

Route::get('/hasilAHP', [MainController::class, 'index']);
// Route::get('/hasilTOPSIS', function () {
//     return view('hasilTOPSIS');
// });

// Route::get('/hasilAHP', function () {
//     return view('hasilTOPSIS');
// });

Route::get('/home', function () {
    return view('home');
});

Route::post('/hasil', [MainController::class, 'index']);
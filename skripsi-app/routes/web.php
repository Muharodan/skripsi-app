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
Route::get('/compare', [WebController::class, 'compare']);
Route::post('/compare', [MainController::class, 'compare']);

Route::get('/hasilAHP', [MainController::class, 'hasilAHP'])->name('hasilAHP');
Route::get('/hasilTOPSIS', [MainController::class, 'hasilTOPSIS'])->name('hasilTOPSIS');

// Route::get('/hasilTOPSIS', function () {
//     return view('hasilTOPSIS');
// });

// Route::get('/hasilAHP', function () {
//     return view('hasilTOPSIS');
// });

Route::get('/home', function () {
    return view('home');
});

// Route::get('/compare', function () {
//     return view('compare');
// });

Route::post('/proses', [MainController::class, 'index']);
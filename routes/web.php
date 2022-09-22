<?php

use App\Http\Controllers\CryptoController;
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

//Example http://localhost/history/bitcoin/2022-09-20
Route::get('/history/{id}/{date}', [CryptoController::class, 'getBitcoinDataByDate', 'id', 'date']);

//Example http://localhost/currency/bitcoin
Route::get('/currency/{id}', [CryptoController::class, 'saveCurrencyData', 'id']);

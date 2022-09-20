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

//http://127.0.0.1:8000/history/bitcoin/30-12-2017
Route::get('/history/{id}/{date}', [CryptoController::class, 'getBitcoinDataByDate', 'id', 'date']);

//http://127.0.0.1:8000/currency/bitcoin
Route::get('/currency/{id}', [CryptoController::class, 'saveCurrencyData', 'id']);

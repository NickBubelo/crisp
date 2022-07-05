<?php

@date_default_timezone_set('Europe/Kiev');

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LinksController;

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

Route::get( '/', [LinksController::class, 'index'] );
Route::post( '/', [LinksController::class, 'post'] );

if (preg_match('/^[0-9A-Za-z]{8}$/',Request::path())) {
    Route::get( Request::path(), [LinksController::class, 'index'] );
}

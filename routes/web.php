<?php

use App\Events\GetRequestEvent;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/trigger/{data}', function ($data) {
    echo "<p>You have sent $data.</p>";
    event(new GetRequestEvent($data));
});

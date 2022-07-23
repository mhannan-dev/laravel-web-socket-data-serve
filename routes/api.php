<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\GetRequestEvent;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [PassportController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/trigger/{data}', function () {
        $cachedUsers = Redis::get('users');
        if (isset($cachedUsers)) {
            $users = json_decode($cachedUsers);
            event(new GetRequestEvent($users));
        } else {
            $users = User::all();
            $cachedUsers = Redis::set('users', json_decode($users));
        }
        event(new GetRequestEvent($cachedUsers));
    });
});






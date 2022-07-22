<?php

use App\Models\User;
use App\Events\GetRequestEvent;
use Illuminate\Support\Facades\Redis;
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
    $cachedUsers = Redis::get('users');
    //$cachedUsers = User::all();
    $time_end = microtime(true);
    if (isset($cachedUsers)) {
        $users = json_decode($cachedUsers);
    } else {
        $users = User::all();
        $cachedUsers = Redis::set('users', json_decode($users));
    }
    return view('welcome', compact('users'));
});
Route::get('/trigger/{data}', function ($data) {
    echo "<p>You have sent $data.</p>";
    event(new GetRequestEvent($data));
});

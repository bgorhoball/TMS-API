<?php

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [\App\Http\Controllers\Auth\ApiAuthController::class, 'register'])->name('register');
Route::post('/login', [\App\Http\Controllers\Auth\ApiAuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->post('/logout', [\App\Http\Controllers\Auth\ApiAuthController::class, 'logout'])->name('logout');

JsonApi::register('default')->middleware('auth:api')->routes(function ($api) {
    $api->resource('users')->relationships(function ($relations) {
        $relations->hasMany(\App\Models\User::REL_WORKS);
    });
    $api->resource('works')->relationships(function ($relations) {
        $relations->hasOne(\App\Models\Work::REL_USER);
    });
});

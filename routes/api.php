<?php

use App\Http\Controllers\AppsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordProfilesController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'me']);
    Route::get('/isvalid', [AuthController::class, 'is_valid']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'apps'

], function ($router) {
    Route::get('/all', [AppsController::class, 'all']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'passwords'

], function ($router) {
    Route::get('/', [PasswordProfilesController::class, 'all']);
    Route::get('/{id}', [PasswordProfilesController::class, 'single']);
    Route::post('/', [PasswordProfilesController::class, 'store']);
    Route::delete('/{id}', [PasswordProfilesController::class, 'delete']);
});
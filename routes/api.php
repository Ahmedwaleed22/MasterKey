<?php

use App\Http\Controllers\AppsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\PasswordProfilesController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SuggestionsController;
use App\Http\Controllers\Admin\UsersAdminController;

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
    Route::post('/confirm_login', [AuthController::class, 'verify_login']);
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
    Route::get('/withoutpagination', [PasswordProfilesController::class, 'all_without_pagination']);
    Route::get('/{id}', [PasswordProfilesController::class, 'single']);
    Route::post('/', [PasswordProfilesController::class, 'store']);
    Route::delete('/{id}', [PasswordProfilesController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'suggestions'

], function ($router) {
    Route::get('/', [SuggestionsController::class, 'latest']);
    Route::post('/', [SuggestionsController::class, 'store']);
});

Route::post('/forgetpassword', [ForgetPasswordController::class, 'forgetpassword']);

Route::get('/checkresettoken/{resettoken}', [ForgetPasswordController::class, 'checktoken']);

Route::post('/resetpassword', [ForgetPasswordController::class, 'resetpassword']);

Route::get('/plans', [PricingController::class, 'all']);
Route::post('/plans', [PricingController::class, 'store']);

Route::post('/contact', [ContactController::class, 'store'])->middleware('auth:api');
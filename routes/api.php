<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecordController;

/*
|-------------------------------------------------------------------------
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


Route::group(['middleware' => 'api'], function ($router){
    Route::get('record', [RecordController::class, 'index']);
    Route::post('record', [RecordController::class, 'store']);
    Route::get('record/{id}', [RecordController::class, 'show']);
    Route::match(['put', 'patch'], 'record/{id}/edit', [RecordController::class, 'update']);
    Route::delete('record/{id}',[RecordController::class, 'destroy']); 

    //For PUT & PATCH METHOD use:
    //api/record/1/edit

});




Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router){
    Route::post('/register', [AuthController:: class, 'register']);
    Route::post('/login', [AuthController:: class, 'login']);
    Route::get('/me', [AuthController:: class, 'me']);
    Route::post('/logout', [AuthController:: class, 'logout']);
    Route::post('/refresh', [AuthController:: class, 'refresh']);

    //enpoint for auth
    ///api/auth/login
    //api/auth/me {then bearertoken}

});
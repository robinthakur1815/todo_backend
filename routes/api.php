<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodosController;
use Illuminate\Support\Facades\Auth;


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

// Route::middleware('auth:api')->group(function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });

  /// todos routes ///
//Route::get('/index',[TodosController::class,'index']);
Route::middleware('auth:api')->get('/index',[TodosController::class,'index'] );
Route::post('/store',[TodosController::class,'store']);
Route::post('/todos/{todo}',[TodosController::class,'destroy']);
Route::patch('/todosCheckAll',[TodosController::class,'updateAll']);
Route::patch('/todos/{todo}',[TodosController::class,'update']);
Route::delete('/todosDeleteCompleted',[TodosController::class,'destroyCompleted']);


/// auth routes ///
Route::post('/register',[AuthController::class,'register']); 
Route::post('/login',[AuthController::class,'login']);
Route::get('/logout',[AuthController::class,'logout']);
Route::get('/user',[AuthController::class,'userInfo']);
Route::get('/alluser',[AuthController::class,'getAllUser']);


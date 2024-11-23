<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//register
Route::post('/register', [AuthController::class, 'register']);
//login
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::group(['middleware' => ['check.role:staff']], function(){
        //get all students (paginated)
        Route::get('/students', [UserController::class, 'getAllStudents']);
    });
    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
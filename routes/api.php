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
        //get a student by their reg number
        Route::get('/student/{reg_number}', [UserController::class, 'getAStudent']);
        //search for a student with query attached to the get request
        Route::get('/students/search', [UserController::class, 'studentSearch']);
    });
    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomsController;
use App\Http\Controllers\Api\EmployeeController;

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

// START: Employees API

Route::get('employees', [EmployeeController::class, 'getAllEmployees']);
Route::post('employees', [EmployeeController::class, 'addNewEmployee']);
Route::get('employees/{id}',[EmployeeController::class, 'getEmployee']);
Route::get('employees/{id}/update',[EmployeeController::class, 'editEmployee']);
Route::put('employees/{id}/update',[EmployeeController::class, 'updateEmployee']);
Route::delete('employees/{id}/delete',[EmployeeController::class, 'deleteEmployee']);
Route::post('employees/login', [EmployeeController::class, 'employeeLogin']);

// END: Employees API

// START: Rooms API

Route::get('rooms', [RoomsController::class, 'getAllRooms']);
Route::post('rooms', [RoomsController::class, 'addNewRoom']);

// END: Rooms API
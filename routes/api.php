<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendController;
use App\Http\Controllers\DepReqController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\EmployeeController;

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
    return $request->user();});
Route::post('/login', [AuthController::class,'login']);
//Attendance
Route::post('/attendance/check-in', [AttendController::class, 'checkIn']);
Route::post('/attendance/check-out', [AttendController::class, 'checkOut']);
//information
Route::get('/info/{employeeId}', [EmployeeController::class,'getInfo']);
//LeveRequest
Route::post('/leaverequest',[LeavesController::class,'leaverequest']);
//Leaves
Route::get('/leaves/{employeeId}', [LeavesController::class,'approvedLeaves']);
//DepartureRequest
Route::post('/departurerequest',[DepReqController::class,'store']);

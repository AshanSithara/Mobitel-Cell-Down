<?php

use App\Http\Controllers\CellDownManagementController;
use App\Http\Controllers\UserController;
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

Route::post('cell-down/add',[CellDownManagementController::class,'addCellDownLog']);
Route::post('cell-down/update',[CellDownManagementController::class,'updateCellDownLog']);
Route::get('cell-down/delete/{id}',[CellDownManagementController::class,'deleteCellDownLog']);
Route::post('cell-down/delete/multi',[CellDownManagementController::class,'deleteCellDownLogMulti']);
Route::post('cell-down/up',[CellDownManagementController::class,'updateTocellUp']);
Route::post('cell-down/up/multi',[CellDownManagementController::class,'updateTocellUpMulti']);
Route::post('cell-down/add/comment',[CellDownManagementController::class,'addRegionComment']);
Route::get('cell-down/log/single/{id}',[CellDownManagementController::class,'getSingleCellLogDetails']);

Route::post('user/add',[UserController::class,'addUser']);
Route::get('user/email/{email}',[UserController::class,'checkemail']);
Route::get('user/delete/{id}',[UserController::class,'deleteUser']);
Route::post('user/update',[UserController::class,'updateUser']);
Route::get('user/single/{id}',[UserController::class,'getSingleUserDetails']);

Route::get('report/dashboard/{fromdate}/{todate}',[CellDownManagementController::class,'reportDashboardCart']);
Route::get('report/cell-report/{searchdate}',[CellDownManagementController::class,'reportCellReport']);
Route::post('report/cell-report',[CellDownManagementController::class,'reportCellReportTable']);
Route::get('report/region-report/{searchdate}',[CellDownManagementController::class,'reportRegionReportManagement']);

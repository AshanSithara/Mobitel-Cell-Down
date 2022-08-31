<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\CellDownManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/profile', [UserController::class,'viewProfile']);
Route::get('/logout', [HomeController::class,'logout']);
Route::get('add-cell-down', [CellDownManagementController::class,'addCellDownLogView']);
Route::get('cell-type-report', [CellDownManagementController::class,'cellTypeReport']);
Route::get('region-report', [CellDownManagementController::class,'regionReport']);

Route::get('excel/total-cell-log/{datetype}', [CellDownManagementController::class,'totalCellLogDetailExcel']);
Route::get('excel/cell-down-log', [CellDownManagementController::class,'cellDownLogDetailExcel']);
Route::get('excel/cell-up-log', [CellDownManagementController::class,'cellUpLogDetailExcel']);


Route::get('view-cell-down',[CellDownManagementController::class,'viewCellDowns']);
Route::get('cell-down/view/{parm}/{id}',[CellDownManagementController::class,'singleCellLog']);
Route::get('view-cell-up',[CellDownManagementController::class,'viewCellups']);
Route::get('user-management',[UserController::class,'index']);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('image/{filename}', [UserController::class,'displayImage'])->name('image.displayImage');

// 404 for undefined routes
//Route::any('/{page?}',function(){
//    return View::make('pages.error.404');
//})->where('page','.*');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

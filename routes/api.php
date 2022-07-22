<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExcelSheetController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user']);

    Route::group(['prefix' => 'employee'], function () {
        Route::get('/get/{id}', [EmployeeController::class, 'get']);
//        Route::get('/{date}', [EmployeeController::class, 'all']);
        Route::get('/all/{date}', [EmployeeController::class, 'all']);
        Route::get('/all/{resigned}', [EmployeeController::class, 'all']);
        Route::post('/create', [EmployeeController::class, 'create']);
        Route::post('/update', [EmployeeController::class, 'update']);
        Route::post('/delete', [EmployeeController::class, 'delete']);

        Route::group(['prefix' => '/salary'], function () {
            Route::get('/all/{date}', [SalaryController::class, 'all']);
            Route::post('/download/', [EmployeeController::class, 'prepareDownload']);
        });
    });

    Route::group(['prefix' => 'excel'], function () {
        Route::post('/upload', [ExcelSheetController::class, 'upload']);
        Route::get('/uploaded/get-page/{page}', [ExcelSheetController::class, 'uploaded']);
        Route::get('/all', [ExcelSheetController::class, 'all']);
        Route::get('/set/{date}', [ExcelSheetController::class, 'set']);
        Route::get('/download/get/{page}', [ExcelSheetController::class, 'perPage']);
        Route::get('/get-page/{page}/{month}/{date}', [ExcelSheetController::class, 'get']);
        Route::get('/search/{word}', [ExcelSheetController::class, 'search']);
        Route::get('/date/{date}', [ExcelSheetController::class, 'date']);
        Route::get('/month/{month}', [ExcelSheetController::class, 'month']);
//        Route::get('/download/{date_one}/{date_two}', [ExcelSheetController::class, 'download']);

        Route::group(['prefix' => '/attendance'], function () {
            Route::group(['prefix' => '/update'], function () {
                Route::post('/column', [ExcelSheetController::class, 'columnUpdate']);
                Route::get('/{status}/{id}', [ExcelSheetController::class, 'status']);
            });
        });

        Route::group(['prefix' => '/employee'], function () {
            Route::get('/get/{employee_id}/{date}', [ExcelSheetController::class, 'getEmployee']);
        });
    });

    Route::group(['prefix' => 'calendar'], function () {
        Route::post('/create', [CalendarController::class, 'create']);
        Route::get('/all/{date}', [CalendarController::class, 'all']);
        Route::post('/delete', [CalendarController::class, 'delete']);
    });
});

// download
Route::get('/excel/download/{date}', [ExcelSheetController::class, 'download']);
Route::get('/employee/download/{date}', [EmployeeController::class, 'download']);
Route::get('/employee/salary/download/{name}/{month}', [EmployeeController::class, 'salaryDownload']);

// login
Route::post('/login', [AuthController::class, 'login']);

// logout
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/get', [ExcelSheetController::class, 'getAll']);

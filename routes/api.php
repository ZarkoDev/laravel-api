<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsersController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [UsersController::class, 'login'])->name('login');
Route::post('/forgotten', [UsersController::class, 'forgotPassword'])->name('password.forgotten');
Route::post('/forgotten/{token}', [UsersController::class, 'resetForgotPassword'])->name('password.reset');

Route::group(['middleware' => ['api.auth']], function () {
    Route::post('/sign-in', [UsersController::class, 'register'])->name('register');
    Route::post('/change-password', [UsersController::class, 'changePassword'])->name('password.change');
    Route::post('/change-passowrd', [UsersController::class, 'changePassword']); // Requirements need it. I added if this checks my attention to details :)
    Route::post('/company', [CompanyController::class, 'downloadCompanyDetails'])->name('company.downloadDetails');
    Route::post('/task', [TaskController::class, 'getTaskResponse'])->name('task.response');
});


<?php

use App\Http\Controllers\CompanyController;
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

Route::post('/sign-in', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/forgotten', [UsersController::class, 'forgotPassword']);
Route::post('/forgotten/{token}', [UsersController::class, 'resetForgotPassword'])->name('password.reset');


Route::group(['middleware' => ['api.auth']], function () {
    Route::post('/change-password', [UsersController::class, 'changePassword']);
    Route::post('/change-passowrd', [UsersController::class, 'changePassword']); // Requirements need it. I added if this checks my attention to details :)

    Route::post('/company', [CompanyController::class, 'getCompany']);
});

<?php

use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\WebPageController;
use App\Http\Controllers\API\V1\WebsiteSettingController;
use App\Http\Controllers\API\V1\NavigationController;
use App\Http\Controllers\API\V1\PageBannerController;
use App\Http\Controllers\API\V1\FrontController;

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
    return response()->json($request->user());
});
Route::middleware('auth:sanctum')->get('/auth-status', function () {
    return response()->json([
        'authenticated' => true,
        'status'  => true,
        'user' => auth()->user(),
    ]);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/pages', [WebPageController::class, 'index']);
    Route::post('/pages', [WebPageController::class, 'store']);
    Route::get('/pages/{id}', [WebPageController::class, 'show']);
    Route::put('/pages/{id}', [WebPageController::class, 'update']);
    Route::delete('/pages/{id}', [WebPageController::class, 'destroy']);

    Route::get('/settings', [WebsiteSettingController::class, 'index']);
    Route::put('/settings', [WebsiteSettingController::class, 'update']);
    Route::get('/pagessettings', [WebsiteSettingController::class, 'pages']);

    Route::get('/navigations', [NavigationController::class, 'index']);
    Route::post('/navigations', [NavigationController::class, 'store']);

    Route::get('/banner/{pageId}', [PageBannerController::class, 'show']);
    Route::post('/banner', [PageBannerController::class, 'store']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// route for front site
Route::get('/site_settings', [WebsiteSettingController::class, 'index']);
Route::get('/site_navigation', [NavigationController::class, 'index']);
Route::get('/page_detail/{id}', [WebPageController::class, 'show']);
Route::get('/page_banner/{pageId}', [PageBannerController::class, 'show']);

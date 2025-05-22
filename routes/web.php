<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\FrontController;

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


Route::get('/', function () {
    return view('site'); // Change 'app' to your blade file name
});

Route::get('/admin', function () {
    return view('app');
})->where('any', '.*');

Route::get('/dashboard', function () {
    return view('app');
})->where('any', '.*');

Route::get('/login', function () {
    return view('app');
})->where('any', '.*');

Route::get('/register', function () {
    return view('app');
})->where('any', '.*');

Route::get('/pages', function () {
    return view('app');
})->where('any', '.*');

Route::get('/settings', function () {
    return view('app');
})->where('any', '.*');

Route::get('/navigation', function () {
    return view('app');
})->where('any', '.*');

Route::get('/banner/{any}', function () {
    return view('app');
})->where('any', '.*');

Route::get('/site/{any}', function () {
    return view('site'); // your main Blade file
})->where('any', '.*');
// Route::get('/pages', function () {
//     return Inertia::render('LiveEditor');
// })->middleware(['auth']);

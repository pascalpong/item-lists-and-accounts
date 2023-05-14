<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/items', ItemController::class)->only([
    'index', 'update', 'edit', 'create', 'store'
]);

Route::resource('/accounts', AccountController::class)->only([
    'index'
]);

Route::get('/accounts/lists', [AccountController::class, 'show']);
Route::post('/accounts/login', [AccountController::class, 'login']);

Route::get('/accounts', [AccountController::class, 'index']);
Route::post('/accounts', [AccountController::class, 'store']);
Route::put('/accounts/update', [AccountController::class, 'update']);
Route::delete('/accounts/delete', [AccountController::class, 'destroy']);

Route::post('/items/random', [ItemController::class, 'random']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\BallController;
use App\Http\Controllers\BallPlacementController;

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
    return view('welcome');
});

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/buckets/create', [BucketController::class, 'create']);
Route::post('/buckets', [BucketController::class, 'store']);
Route::resource('buckets', BucketController::class);

Route::get('/balls/create', [BallController::class, 'create']);
Route::post('/balls', [BallController::class, 'store']);
Route::resource('balls', BallController::class);


//Route::get('/ball-placements/create', [BallPlacementController::class, 'create']);
//Route::post('/ball-placements', [BallPlacementController::class, 'store']);
//Route::resource('ball-placements', BallPlacementController::class);

Route::get('/ball-placements', [BallPlacementController::class, 'index'])->name('ball-placements.index');
Route::post('/place-balls', [BallPlacementController::class, 'store'])->name('ball-placements.store');


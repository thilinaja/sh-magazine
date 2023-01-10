<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MagazineController;

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

// Route::get('/', [MagazineController::class, 'browse']);

// Route::get('/view/{magazine}', [MagazineController::class, 'show'])->name('magazines.read');
// Route::post('/time/{magazine}', [MagazineController::class, 'time'])->name('magazines.time');

// Route::resource('/magazines', MagazineController::class);

Route::redirect('/', 'login');

Route::group(['middleware' => ['web', 'guest'], 'namespace' => 'App\Http\Controllers'], function(){
    Route::get('login', 'AuthController@login')->name('login');
    Route::get('connect', 'AuthController@connect')->name('connect');
});

Route::group(['middleware' => ['web', 'MsGraphAuthenticated'], 'prefix' => 'app', 'namespace' => 'App\Http\Controllers'], function(){
    //Route::get('/', 'PagesController@app')->name('app');

	Route::get('/', [MagazineController::class, 'browse']);

	Route::get('/view/{magazine}', [MagazineController::class, 'show'])->name('magazines.read');
	Route::post('/time/{magazine}', [MagazineController::class, 'time'])->name('magazines.time');

	Route::resource('/magazines', MagazineController::class);
    
    Route::get('logout', 'Auth\AuthController@logout')->name('logout');
});
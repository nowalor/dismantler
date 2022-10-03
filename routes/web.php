<?php

use App\Http\Controllers\AboutUsPageController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\FaqPageController;
use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminHomepageController;
use App\Http\Controllers\AdminDitoNumbersController;
use App\Http\Controllers\ConnectDitoToDismantlerController;
use App\Http\Controllers\GermanDismantlerController;
use App\Http\Controllers\KbaController;

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

Route::get('/', HomepageController::class);
Route::get('/faq', FaqPageController::class)->name('faq');
Route::get('/about-us', AboutUsPageController::class)->name('about-us');
Route::get('/contact', ContactPageController::class)->name('contact');

Route::get('dismantlers', [TestController::class, 'showSelectPage']);
Route::get('dismantlers-german', [TestController::class, 'showGermanDismantlers'])->name('german.dismantlers');
Route::get('dismantlers-danish', [TestController::class, 'showDanishiDsmantlers'])->name('danish.dismantlers');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.show-login');
Route::post('login', [LoginController::class, 'login'])->name('login');

// Regular routes
Route::resource('car-parts', \App\Http\Controllers\CarPartController::class);

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('', AdminHomepageController::class)->name('admin.dito-numbers.index');
    Route::get('dito-numbers/{ditoNumber}/filter', [AdminDitoNumbersController::class, 'filter'])->name('admin.dito-numbers.filter');
    Route::resource('dito-numbers', AdminDitoNumbersController::class, ['as' => 'admin']);
    Route::post('kba/storeConnection/{kba}', [KbaController::class, 'storeConnectionToEngineType'])
        ->name('admin.kba.store-connection');
    Route::post('kba/delete/Connection/{kba}', [KbaController::class, 'deleteConnectionToEngineType'])
            ->name('admin.kba.delete-connection');
    Route::resource('kba', KbaController::class, ['as' => 'admin']);

    Route::resource('car-parts', \App\Http\Controllers\AdminCarPartController::class, ['as' => 'admin']);

    Route::post('dito-numbers/{ditoNumberId}', [ConnectDitoToDismantlerController::class, 'connect'])->name('test.store');
    Route::delete('dito-numbers/{ditoNumber}/{germanDismantler}', [ConnectDitoToDismantlerController::class, 'delete'])->name('test.delete');
});

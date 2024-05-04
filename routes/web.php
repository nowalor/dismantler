<?php

use App\Http\Controllers\AboutUsPageController;
use App\Http\Controllers\AdminConnectMultipleKbaToEngineTypeController;
use App\Http\Controllers\AdminEngineTypeController;
use App\Http\Controllers\CarPartController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\FaqPageController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SendContactUsEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminHomepageController;
use App\Http\Controllers\AdminDitoNumbersController;
use App\Http\Controllers\ConnectDitoToDismantlerController;
use App\Http\Controllers\GermanDismantlerController;
use App\Http\Controllers\KbaController;
use App\Http\Controllers\AdminNewCarpartController;
use App\Http\Controllers\browseCarParts;
use App\Http\Controllers\LandingPageController;

Route::get('preview-template/{carPart}', \App\Http\Controllers\PreviewEbayTemplateController::class);

Route::resource('reservations', \App\Http\Controllers\ReservationController::class)
    ->only(['show', 'destroy']);

Route::get('test-parts', [TestController::class, 'testingParts']);

Route::get('engine-type-engine-alias', \App\Http\Controllers\EngineTypeEngineAliasController::class);
// Payment routes
Route::post('products/{carPart}/payments/pay', [PaymentController::class, 'pay'])
    ->name('pay');
Route::get('payments/approval', [App\Http\Controllers\PaymentController::class, 'approval'])
    ->name('approval');
Route::get('payments/cancelled', [App\Http\Controllers\PaymentController::class, 'cancelled'])
    ->name('cancelled');
Route::get('payments/success', [App\Http\Controllers\PaymentController::class, 'success'])
    ->name('checkout.success');

// Checkout
Route::get('car-parts/{carPart}/checkout', [PaymentController::class, 'index'])
    ->name('checkout');


// testing remove later
Route::get('test3', [TestController::class, 'carPartIds']);

// Payment routes end

Route::get('', HomepageController::class)->name('home');
//Route::get('', [LandingPageController::class, 'returnLandingPage'] );
//Route::get('browse', browseCarParts::class)->name('landingPage');
Route::get('faq', FaqPageController::class)->name('faq');
Route::get('about-us', AboutUsPageController::class)->name('about-us');
Route::get('contact', ContactPageController::class)->name('contact');
Route::post('contact', SendContactUsEmailController::class)->name('contact.send');

Route::get('dismantlers', [TestController::class, 'showSelectPage']);
Route::get('dismantlers-german', [TestController::class, 'showGermanDismantlers'])->name('german.dismantlers');
Route::get('dismantlers-danish', [TestController::class, 'showDanishiDsmantlers'])->name('danish.dismantlers');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.show-login');
Route::post('login', [LoginController::class, 'login'])->name('login');

// Regular routes
Route::resource('car-parts', CarPartController::class);
Route::get('car-parts/search/by-code' , [CarPartController::class, 'searchByCode'])->name('car-parts.search-by-code');
Route::get('car-parts/search/by-model' , [CarPartController::class, 'searchByModel'])->name('car-parts.search-by-model');
Route::get('car-parts/search/by-oem' , [CarPartController::class, 'searchByOem'])->name('car-parts.search-by-oem');

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
    Route::resource('sbr-codes', \App\Http\Controllers\AdminSbrCodeController::class, ['as' => 'admin']);
    Route::resource('dito-numbers.sbr-codes', \App\Http\Controllers\AdminDitoNumberSbrCodeController::class, ['as' => 'admin'])
        ->only(['index','show', 'store', 'destroy']);

    Route::resource('car-parts', \App\Http\Controllers\AdminCarPartController::class, ['as' => 'admin']);

    Route::resource('export-parts', \App\Http\Controllers\AdminExportPartsController::class, ['as' => 'admin'])
        ->only(['index', 'show'])
        ->parameter('export-parts', 'carPart');

    Route::resource('orders', \App\Http\Controllers\AdminOrderController::class, ['as' => 'admin'])
        ->only(['index', 'show', 'update', 'destroy',]);

    Route::get('new-parts', AdminNewCarpartController::class)->name('admin.new-parts');

    Route::post('dito-numbers/{ditoNumberId}', [ConnectDitoToDismantlerController::class, 'connect'])->name('test.store');
    Route::delete('dito-numbers/{ditoNumber}/{germanDismantler}', [ConnectDitoToDismantlerController::class, 'delete'])->name('test.delete');
    Route::delete('dito-numbers/{ditoNumber}/delete/multiple', [ConnectDitoToDismantlerController::class, 'deleteMultiple'])
        ->name('test.delete-multiple');
    Route::delete('dito-numbers/{ditoNumber}/delete/except-selected', [ConnectDitoToDismantlerController::class, 'deleteExceptSelected'])
        ->name('test.delete-except-selected');
    Route::post('dito-numbers/{ditoNumber}/connections/restore', [ConnectDitoToDismantlerController::class, 'restore'])
        ->name('test.restore');

    Route::put('engine-types/{engineType}', AdminConnectMultipleKbaToEngineTypeController::class)
        ->name('admin.engine-types.connect');

    Route::get('information', [\App\Http\Controllers\MissingInformationController::class, 'index'])
        ->name('admin.information');

    Route::resource('engine-types', AdminEngineTypeController::class, ['as' => 'admin'])
        ->only(['index', 'show', 'update']);
    Route::delete('engine-types/{engineType}/german-dismantlers/{germanDismantler}', [AdminEngineTypeController::class, 'destroy'])
        ->name('admin.engine-types.destroy');
    Route::delete('engine-types/{engineType}/delete', [AdminEngineTypeController::class, 'destroyMultiple'])
        ->name('admin.engine-types.destroy-multiple');
    Route::delete('engine-types/{engineType}/delete/max-wat', [AdminEngineTypeController::class, 'destroyAllWithoutMaxWat'])
        ->name('admin.engine-types.delete-max-wat');

    Route::get('information/{ditoNumber}', [\App\Http\Controllers\MissingInformationController::class, 'show'])
        ->name('admin.information.show');
});


// Stripe webhooks
Route::stripeWebhooks('marcus-webhook-test');

Route::get('preview', function() {
    $dismantleId = '123';
    $fenixId = '123';

    return view('emails.reservation', compact('dismantleId', 'fenixId'));
});


// TEST HOOD TEMPLATE
Route::get('hood/{part}', function (\App\Models\NewCarPart $part) {
    $data = (new \App\Actions\GetTemplateInfoAction())->execute($part);

    return view('hood', compact('part', 'data'));
});

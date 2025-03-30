<?php

use App\Http\Controllers\AboutUsPageController;
use App\Http\Controllers\AdminConnectMultipleKbaToEngineTypeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminEngineTypeController;
use App\Http\Controllers\BrandModelCarPartTypeController;
use App\Http\Controllers\CarPartController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\FaqPageController;
use App\Http\Controllers\NewsletterSigneeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchByPlateController;
use App\Http\Controllers\SendContactUsEmailController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TestLangController;
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
use App\Http\Controllers\CarPartFullviewController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\BrandModelController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ViewCarPartTypesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\BrowsingCountryController;

Route::get('search-by-plate', SearchByPlateController::class);
Route::get('search-by-plate', [SearchByPlateController::class, 'search'])->name('search-by-plate');

Route::resource('reservations', \App\Http\Controllers\ReservationController::class)->only(['show', 'destroy']);

// Payment routes end

// this is the correct HomePageController with search, old design
//Route::get('', HomepageController::class)->name('home');
// currently using this for now until currusConnect production ready
//Route::get('', [TemporaryLandingPageController::class, 'TemporaryLandingPageView'])->name('home');

Route::get('browse', [CarPartController::class, 'searchParts'])->name('browse');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::get('', LandingPageController::class)->name('landingpage'); // homepage with new design
        Route::get('faq', FaqPageController::class)->name('faq');
        Route::get('contact', ContactPageController::class)->name('contact');
        Route::get('test-lang', TestLangController::class)->name('test-lang');

        // fetching part types depending on what category you're hovering
        Route::get('/subcategories/{mainCategory}', [ViewCarPartTypesController::class, 'index']);
        Route::get('/categories-with-subcategories', [ViewCarPartTypesController::class, 'getAllCategories']);
        Route::get('/main-categories-names', [ViewCarPartTypesController::class, 'getMainCategoryNames']);
        Route::get('/sub-categories-names', [ViewCarPartTypesController::class, 'getSubCategoryNames']);

        Route::get('/newsletter', [\App\Http\Controllers\NewsletterSigneeController::class, 'index'])->name('newsletter.index');
        Route::post('/newsletter', [\App\Http\Controllers\NewsletterSigneeController::class, 'store'])->name('newsletter.store');

        Route::get('about-us', AboutUsPageController::class)->name('about-us');
        Route::post('contact', SendContactUsEmailController::class)->name('contact.send');

        Route::get('login', [LoginController::class, 'showLoginForm'])->name('auth.show-login');
        Route::post('login', [LoginController::class, 'login'])->name('login');

        // Regular routes
        Route::resource('car-parts', CarPartController::class);
        Route::get('car-parts/search/by-code', [CarPartController::class, 'searchByCode'])->name('car-parts.search-by-code');
        Route::get('car-parts/search/by-model', [CarPartController::class, 'searchByModel'])->name('car-parts.search-by-model');
        Route::get('car-parts/search/by-oem', [CarPartController::class, 'searchByOem'])->name('car-parts.search-by-oem');
        Route::get('car-parts/search/by-name', [CarPartController::class, 'searchParts'])->name('car-parts.search-by-name');

        Route::get('/brands/{brand:slug}/models', [BrandModelController::class, 'index'])->name('brands.models');
        Route::get('/brands/{brand:slug}/{model}/categories', [BrandModelCarPartTypeController::class, 'index'])->name('brands.categories');

        Route::get('/categories/{mainCategory:slug}/subcategories', [SubcategoryController::class, 'index'])->name('categories.show');
        Route::get('/subcategories/{subCategory:slug}/brands', [SubcategoryController::class, 'showBrandsForSubcategories'])->name('subcategories.brands');
        Route::get('/subcategories/{subCategory:slug}/brands/{brand:slug}/models', [SubcategoryController::class, 'showModelsForSubCategoryAndBrand'])
            ->name('subcategories.brands.models')
            ->withoutScopedBindings();

        // Payment routes
        Route::post('products/{carPart}/payments/pay', [PaymentController::class, 'pay'])->name('pay');
        Route::get('payments/approval', [App\Http\Controllers\PaymentController::class, 'approval'])->name('approval');
        Route::get('payments/cancelled', [App\Http\Controllers\PaymentController::class, 'cancelled'])->name('cancelled');
        Route::get('payments/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('checkout.success');

        // Checkout
        Route::get('car-parts/{carPart}/checkout', [PaymentController::class, 'index'])->name('checkout');

        // Set browsing country
        Route::post('/browsing-country/filter', [BrowsingCountryController::class, 'filter'])->name('setBrowsingCountry');

        // full view of individual car part
        Route::get('car-parts/{part}/fullview', [CarPartFullviewController::class, 'index'])->name('fullview');
    },
);

// Admin routes
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'middleware' => [
            'localeSessionRedirect',
            'localizationRedirect',
            'localeViewPath',
            'admin', // Ensure this middleware is working correctly
        ],
    ],
    function () {
        Route::get('', AdminHomepageController::class)->name('admin.dito-numbers.index');
        Route::get('dito-numbers/{ditoNumber}/filter', [AdminDitoNumbersController::class, 'filter'])->name('admin.dito-numbers.filter');
        //Route::resource('dito-numbers', AdminDitoNumbersController::class, ['as' => 'admin']);
        Route::post('kba/storeConnection/{kba}', [KbaController::class, 'storeConnectionToEngineType'])->name('admin.kba.store-connection');
        Route::post('kba/delete/Connection/{kba}', [KbaController::class, 'deleteConnectionToEngineType'])->name('admin.kba.delete-connection');
        Route::resource('kba', KbaController::class, ['as' => 'admin']);

          //blog
        Route::resource('blogs', AdminBlogController::class, ['as' => 'admin']);
        Route::get('/blogs/tag/{tag}', [AdminBlogController::class, 'filterByTag'])->name('blogs.byTag');

        // routes for establishing connections for part types
        Route::resource('part-types-categories', AdminCategoryController::class, ['as' => 'admin']);
        // one mainCategory toMany subCategories
        Route::post('categories/connect-car-part/{mainCategory}', [AdminCategoryController::class, 'connectCarPart'])->name('admin.categories.connect-car-part');
        Route::post('categories/disconnect-car-part/{mainCategory}', [AdminCategoryController::class, 'disconnectCarPart'])->name('admin.categories.disconnect-car-part');
        // show individual category
        //Route::get('part-types-categories/{category}', [AdminCategoryController::class, 'show'])->name('admin.part-types-categories.show');

        Route::resource('sbr-codes', \App\Http\Controllers\AdminSbrCodeController::class, ['as' => 'admin']);
        Route::resource('dito-numbers.sbr-codes', \App\Http\Controllers\AdminDitoNumberSbrCodeController::class, ['as' => 'admin'])->only(['index', 'show', 'store', 'destroy']);

        // dashboard where admin can see how many car-parts we are uploading to ebay, autoteile-markt and hood.de - work in progress
        Route::get('dashboard', AdminDashboardController::class)->name('admin.dashboard');

        Route::resource('car-parts', \App\Http\Controllers\AdminCarPartController::class, ['as' => 'admin']);

        Route::resource('export-parts', \App\Http\Controllers\AdminExportPartsController::class, ['as' => 'admin'])
            ->only(['index', 'show'])
            ->parameter('export-parts', 'carPart');

        Route::get('newsletter', [\App\Http\Controllers\AdminNewsletterController::class, 'index'])->name('admin.newsletter.index');
        Route::post('newsletter/mark-as-seen', [\App\Http\Controllers\AdminNewsletterController::class, 'markAsSeen'])->name('admin.newsletter.mark-as-seen');

        Route::resource('orders', \App\Http\Controllers\AdminOrderController::class, ['as' => 'admin'])->only(['index', 'show', 'update', 'destroy']);

        Route::get('new-parts', AdminNewCarpartController::class)->name('admin.new-parts');

        Route::post('dito-numbers/{ditoNumberId}', [ConnectDitoToDismantlerController::class, 'connect'])->name('test.store');
        Route::delete('dito-numbers/{ditoNumber}/{germanDismantler}', [ConnectDitoToDismantlerController::class, 'delete'])->name('test.delete');
        Route::delete('dito-numbers/{ditoNumber}/delete/multiple', [ConnectDitoToDismantlerController::class, 'deleteMultiple'])->name('test.delete-multiple');
        Route::delete('dito-numbers/{ditoNumber}/delete/except-selected', [ConnectDitoToDismantlerController::class, 'deleteExceptSelected'])->name('test.delete-except-selected');
        Route::post('dito-numbers/{ditoNumber}/connections/restore', [ConnectDitoToDismantlerController::class, 'restore'])->name('test.restore');

        Route::put('engine-types/{engineType}', AdminConnectMultipleKbaToEngineTypeController::class)->name('admin.engine-types.connect');

        Route::get('information', [\App\Http\Controllers\MissingInformationController::class, 'index'])->name('admin.information');

        Route::resource('engine-types', AdminEngineTypeController::class, ['as' => 'admin'])->only(['index', 'show', 'update']);
        Route::delete('engine-types/{engineType}/german-dismantlers/{germanDismantler}', [AdminEngineTypeController::class, 'destroy'])->name('admin.engine-types.destroy');
        Route::delete('engine-types/{engineType}/delete', [AdminEngineTypeController::class, 'destroyMultiple'])->name('admin.engine-types.destroy-multiple');
        Route::delete('engine-types/{engineType}/delete/max-wat', [AdminEngineTypeController::class, 'destroyAllWithoutMaxWat'])->name('admin.engine-types.delete-max-wat');

        Route::get('information/{ditoNumber}', [\App\Http\Controllers\MissingInformationController::class, 'show'])->name('admin.information.show');
    },
);

// Stripe webhooks
Route::stripeWebhooks('marcus-webhook-test');

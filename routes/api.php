<?php

use App\Http\Controllers\API\ExportDataForAutoteileMarkt;
use App\Http\Controllers\ApiTestController;
use App\Http\Controllers\ApiTestController2;
use App\Http\Controllers\ApiTestController3;
use App\Models\CarBrand;
use App\Models\CarPart;
use App\Models\CarPartType;
use App\Models\DitoNumber;
use App\Models\EngineType;
use App\Models\GermanDismantler;
use App\Models\NewCarPart;
use App\Models\SbrCode;
use App\Services\ResolveKbaFromSbrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GetUniqueManufacturerPlaintextController;

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

Route::get('api-test', ApiTestController::class);
Route::get('api-test2', ApiTestController2::class);
Route::get('api-test3', ApiTestController3::class);
Route::get('export-data', ExportDataForAutoteileMarkt::class);

Route::get('engine-types', function () {
    $engineTypes = EngineType::select(['name'])->get();

    return $engineTypes;
});

Route::get('for-marcus', function () {
    $parts = NewCarPart::select('sbr_car_name', 'sbr_car_code', 'engine_type')
        ->where('name', 'like', '%LIGIER%')
        ->orWhere('name', 'like', '%AIXAM%')
        ->get()
        ->unique('sbr_car_code');

    return response()->json($parts);
});


Route::get('car-brands', function () {
    $brands = DitoNumber::distinct('producer')->pluck('producer');

    return $brands;
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('plaintexts', GetUniqueManufacturerPlaintextController::class);
Route::get('', function () {
    return 'Welcome to API';
});

Route::get('parts', function () {
//    $kbas = \App\Models\GermanDismantler::select(['id', 'hsn', 'tsn', 'full_name'])
//        ->where('manufacturer_plaintext', 'like', '%audi%')
//        ->take(50)
//        ->get();
//
//    $parts = \App\Models\CarPart::select(['id', 'name'])
//        ->take(50)
//        ->get();

    $carPartNames = CarPart::take(10000)->pluck('name');

    $uniqueWords = $carPartNames->flatMap(function ($name) {
        return preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
    })->unique()->values()->all();


    return count($uniqueWords);
});

Route::get('kbas', function () {
    $kbas = GermanDismantler::select(['id', 'hsn', 'tsn', 'manufacturer_plaintext'])->get();

    return response()->json($kbas);
});

Route::get('car-part-types', function () {
    $carPartTypes = CarPartType::getAllCarPartTypes();

    return response()->json($carPartTypes);
});

Route::get('service-test', function () {
    $service = new ResolveKbaFromSbrCodeService();

    return $service->resolve('1345', 'CCSA');
});


Route::get('car-models', function () {
    $codes = SbrCode::all();

    foreach ($codes as $code) {
        $parts = explode(' ', $code->name);

        $brand = $parts[0];

        $model = implode(' ', array_slice($parts, 1));

        if ($model !== '') {
            $data = [
                'name' => $model,
                'sbr_code_id' => $code->id,
            ];

            $brandInDb = CarBrand::where('name', $brand)->first();

            if ($brandInDb) {
                $data['car_brand_id'] = $brandInDb->id;
            }

            \App\Models\CarModel::create($data);
        }
    }

    return 'done...';
});


Route::get('testing123', function() {
    return NewCarPart::distinct('sbr_car_code')->count();
});

Route::post('do-upload', function (Request $request) {
   $file = $request->file('file');

    $path = Storage::disk('do')->putFileAs('test-folder', $file, 'test23.png', 'public');

    return Storage::disk('do')->url($path);
});

Route::get('to-seed', function() {
    return DitoNumber::all();
    return \App\Models\NewCarPartImage::all();
});



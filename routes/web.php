<?php
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CV\CVController;
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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class,'dashboard'])->name('dashboard');

    Route::get('/profiles', [App\Http\Controllers\Admin\AdminController::class,'profiles'])->name('profile');

    Route::prefix("/CV")->name('cv.')->group(function () {

        Route::get("", [App\Http\Controllers\Admin\AdminController::class,'listCV'])->name("");

        Route::prefix("/new")->name('create.')->group(function () {

            Route::get('', [App\Http\Controllers\Admin\ManageCVController::class,'create'])->name("init");

            Route::get("/identity", [App\Http\Controllers\Admin\ManageCVController::class,'fillIdentity'])->name("identity");

            Route::get("/{id}/experience", [App\Http\Controllers\Admin\ManageCVController::class,'fillExperience'])->name("experiece");

            Route::get("/{id}/education", [App\Http\Controllers\Admin\ManageCVController::class,'fillEducation'])->name("education");

            Route::get("/{id}/skill", [App\Http\Controllers\Admin\ManageCVController::class,'fillSkill'])->name("skill");

            Route::get("/{id}/extra", [App\Http\Controllers\Admin\ManageCVController::class,'fillExtra'])->name("extra");
        });

        Route::get("/{id}", [App\Http\Controllers\Admin\ManageCVController::class,'detail'])->name("detail");
    });

    Route::get('/profile/{id_profile}', [App\Http\Controllers\Admin\AdminController::class,'profileDetail'])->name('profile-detail');


    Route::prefix('resource')->name('resource.')->group(function () {
        Route::resources([
            'profiles' => ProfileController::class,
            'cvs' => CvController::class,
            'custom-field' => CustomFieldController::class
        ]);

        Route::patch('profiles/{id_profile}/profile-attribute-line', [App\Http\Controllers\ProfileController::class,'updateProfileAttributeLine']);
        Route::post('profiles/{id_profile}/profile-attribute-line', [App\Http\Controllers\ProfileController::class,'addProfileAttributeLine']);
        Route::delete('profiles/{id_profile}/profile-attribute-line', [App\Http\Controllers\ProfileController::class,'deleteProfileAttributeLine']);
    });
});

Route::prefix('public-resource')->name('PublicResources.')->group(function () {

    Route::resources([
        'cv' => 'App\Http\Controllers\PublicResources\PublicCvController'
    ]);
});

Route::prefix('CV')->name('CV.')->group(function () {

    Route::get('/first/{idcv}', [App\Http\Controllers\CV\CVController::class,'templates_first'])->name('templates_first');

    Route::get('/second/{idcv}', [App\Http\Controllers\CV\CVController::class,'templates_second'])->name('templates_second');

    // Route::get('/profiles', 'Admin\AdminController@profiles')->name('profile');

    // Route::prefix('resource')->name('resource.')->group(function(){
    //     Route::resources([
    //         'profiles' => ProfileController::class,
    //     ]);
    // });
});

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

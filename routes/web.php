<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');

    Route::get('/profiles', 'Admin\AdminController@profiles')->name('profile');

    Route::prefix("/CV")->name('cv.')->group(function () {

        Route::get("", 'Admin\AdminController@listCV')->name("");

        Route::prefix("/new")->name('create.')->group(function () {

            Route::get('', 'Admin\ManageCVController@create')->name("init");

            Route::get("/identity", 'Admin\ManageCVController@fillIdentity')->name("identity");

            Route::get("/{id}/experience", 'Admin\ManageCVController@fillExperience')->name("experiece");

            Route::get("/{id}/education", 'Admin\ManageCVController@fillEducation')->name("education");

            Route::get("/{id}/skill", 'Admin\ManageCVController@fillSkill')->name("skill");

            Route::get("/{id}/extra", 'Admin\ManageCVController@fillExtra')->name("extra");
        });

        Route::get("/{id}", "Admin\ManageCVController@detail")->name("detail");
    });

    Route::get('/profile/{id_profile}', 'Admin\AdminController@profileDetail')->name('profile-detail');


    Route::prefix('resource')->name('resource.')->group(function () {
        Route::resources([
            'profiles' => ProfileController::class,
            'cvs' => CvController::class,
            'custom-field' => CustomFieldController::class
        ]);

        Route::patch('profiles/{id_profile}/profile-attribute-line', 'ProfileController@updateProfileAttributeLine');
        Route::post('profiles/{id_profile}/profile-attribute-line', 'ProfileController@addProfileAttributeLine');
        Route::delete('profiles/{id_profile}/profile-attribute-line', 'ProfileController@deleteProfileAttributeLine');
    });
});

Route::prefix('public-resource')->name('PublicResources.')->group(function () {

    Route::resources([
        'cv' => 'PublicResources\PublicCvController'
    ]);
});

Route::prefix('CV')->name('CV.')->group(function () {

    Route::get('/first/{idcv}', 'CV\CVController@templates_first')->name('templates_first');

    Route::get('/second/{idcv}', 'CV\CVController@templates_second')->name('templates_second');

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

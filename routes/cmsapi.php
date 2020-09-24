<?php

use Illuminate\Support\Facades\Route;

Route::middleware('ajax')->name('cmsapi.')->group(function () {

    Route::prefix('administration')->group(function () {
        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', 'CMS\Api\UserCmsApiController@index')->name('index');
            Route::post('/store', 'CMS\Api\UserCmsApiController@store')->name('store');
            Route::post('/{id}/update', 'CMS\Api\UserCmsApiController@update')->name('update');
        });
    });
});

/* Route::middleware(['auth'])->name('cmsapi.')->group(function () {

    Route::apiResources([
        'users' => 'UserController',
        'enterprises' => 'EnterpriseController',
        'clients' => 'ClientController',
        'establishment_types' => 'EstablishmentTypeController',
        'establishments' => 'EstablishmentController',
        'departments' => 'DepartmentController',
        'establishment_evaluations' => 'EstablishmentEvaluationController',
        'department_evaluations' => 'DepartmentEvaluationController',
        'indicators' => 'IndicatorController',
        'indicator_groups' => 'IndicatorGroupController',
        'surveys' => 'SurveyController'
    ]);
}); */

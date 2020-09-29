<?php

use Illuminate\Support\Facades\Route;

Route::middleware('ajax')->name('cmsapi.')->group(function () {

    Route::prefix('administration')->group(function () {
        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', 'CMS\Api\UserCmsApiController@index')->name('index');
            Route::post('/store', 'CMS\Api\UserCmsApiController@store')->name('store');
            Route::post('/{user_id}/update', 'CMS\Api\UserCmsApiController@update')->name('update');
            Route::put('/{user_id}/set-state', 'CMS\Api\UserCmsApiController@setState')->name('setState');
            Route::get('/{user_id}/show', 'CMS\Api\UserCmsApiController@show')->name('show');
        });

        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', 'CMS\Api\PermissionCmsApiController@index')->name('index');
        });

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', 'CMS\Api\RoleCmsApiController@index')->name('index');
            Route::get('/{role_id}/permissions-by-role', 'CMS\Api\RoleCmsApiController@getPermissionsByRole')->name('get-permissions-by-role');
            Route::post('/store', 'CMS\Api\RoleCmsApiController@store')->name('store');
            Route::put('/{role_id}/update', 'CMS\Api\RoleCmsApiController@update')->name('update');
            /* Route::post('/store', 'CMS\Api\RoleCmsApiController@store')->name('store');
            Route::put('/{id}/update', 'CMS\Api\RoleCmsApiController@update')->name('update'); */
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

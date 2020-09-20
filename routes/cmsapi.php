<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['ajax'])->name('cmsapi.')->group(function () {

    Route::prefix('administration')->group(function () {
        Route::resource('users', 'CMS\Api\UserCmsApiController');
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

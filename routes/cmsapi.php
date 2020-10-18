<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['ajax', 'auth'])->name('cmsapi.')->group(function () {

    /* AUTH */
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/login', 'CMS\Api\Auth\LoginCmsApiController@login')->name('login')->withoutMiddleware(['auth']);
        Route::get('/logout', 'CMS\Api\Auth\LoginCmsApiController@logout')->name('logout');
        Route::get('/get-refresh-auth-user', 'CMS\Api\Auth\LoginCmsApiController@refreshUserAuth')->name('get-refresh-auth-user');
    });

    /* ADMINISTRATION */
    Route::prefix('administration')->group(function () {

        /* USERS */
        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', 'CMS\Api\UserCmsApiController@index')->middleware('permission:users.index')->name('index');
            Route::post('/store', 'CMS\Api\UserCmsApiController@store')->middleware('permission:users.store')->name('store');
            Route::post('/{user_id}/update', 'CMS\Api\UserCmsApiController@update')->middleware('permission:users.update')->name('update');
            Route::put('/{user_id}/set-state', 'CMS\Api\UserCmsApiController@setState')->middleware('permission:users.activate|users.deactivate')->name('set-state');
            Route::get('/{user_id}/show', 'CMS\Api\UserCmsApiController@show')->name('show');
            Route::get('/{user_id}/get-permissions', 'CMS\Api\UserCmsApiController@getPermissions')->name('get-permissions');
        });

        /* PERMISSIONS */
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', 'CMS\Api\PermissionCmsApiController@index')->name('index');
            Route::get('/get-all-permissions', 'CMS\Api\PermissionCmsApiController@getAllPermissions')->name('get-all-permissions');
        });

        /* ROLES */
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', 'CMS\Api\RoleCmsApiController@index')->middleware('permission:roles.index')->name('index');
            Route::get('/get-all-roles', 'CMS\Api\RoleCmsApiController@getAllRoles')->name('get-all-roles');
            Route::get('/{role_id}/permissions-by-role', 'CMS\Api\RoleCmsApiController@getPermissionsByRole')->name('get-permissions-by-role');
            Route::post('/store', 'CMS\Api\RoleCmsApiController@store')->middleware('permission:roles.store')->name('store');
            Route::put('/{role_id}/update', 'CMS\Api\RoleCmsApiController@update')->middleware('permission:roles.update')->name('update');
        });
    });

    /* CONFIGURATION */
    Route::prefix('configuration')->group(function () {

        /* CATEGORIES */
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', 'CMS\Api\CategoryCmsApiController@index')->middleware('permission:categories.index')->name('index');
            Route::post('/store', 'CMS\Api\CategoryCmsApiController@store')->middleware('permission:categories.store')->name('store');
            Route::put('/{category_id}/update', 'CMS\Api\CategoryCmsApiController@update')->middleware('permission:categories.update')->name('update');
            Route::get('/get-all-categories', 'CMS\Api\CategoryCmsApiController@getAllCategories')->name('get-categories');
        });

        /* PRODUCT */
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', 'CMS\Api\ProductCmsApiController@index')->middleware('permission:products.index')->name('index');
            Route::post('/store', 'CMS\Api\ProductCmsApiController@store')->middleware('permission:products.store')->name('store');
            Route::put('/{product_id}/update', 'CMS\Api\ProductCmsApiController@update')->middleware('permission:products.update')->name('update');
        });


    });


});


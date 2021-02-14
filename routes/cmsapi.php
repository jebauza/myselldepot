<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['ajax', 'auth'])->name('cmsapi.')->group(function () {

    /* AUTH */
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/login', 'CMS\Api\Auth\LoginCmsApiController@login')->name('login')->withoutMiddleware(['auth']);
        Route::get('/logout', 'CMS\Api\Auth\LoginCmsApiController@logout')->name('logout');
        Route::get('/get-refresh-auth-user', 'CMS\Api\Auth\LoginCmsApiController@refreshUserAuth')->name('get-refresh-auth-user');
    });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/chart/product-sales-ranking', 'CMS\Api\DashboardApiController@getProductSalesRanking')/* ->middleware('permission:products.most-selled') */->name('chart.product-sales-ranking');
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
            Route::get('/auth-user/get-all-permissions', 'CMS\Api\PermissionCmsApiController@authUserAllPermissions')->name('auth-user.get-all-permissions');
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
            Route::get('/get-all-products', 'CMS\Api\ProductCmsApiController@getAllProducts')->name('get-products');
        });
    });

    /* OPERATION */
    Route::prefix('operation')->group(function () {

        /* ORDERS */
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', 'CMS\Api\OrderCmsApiController@index')->middleware('permission:orders.index')->name('index');
            Route::post('/store', 'CMS\Api\OrderCmsApiController@store')->middleware('permission:orders.store')->name('store');
            // Route::put('/{order_id}/update', 'CMS\Api\OrderCmsApiController@update')->middleware('permission:orders.update')->name('update');
            Route::post('/{order_id}/generate-pdf', 'CMS\Api\OrderCmsApiController@generatePDF')->middleware('permission:orders.store')->name('generate-pdf');
            Route::put('/{order_id}/reject', 'CMS\Api\OrderCmsApiController@reject')->middleware('permission:orders.reject')->name('reject');
        });

        /* CUSTOMERS */
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', 'CMS\Api\CustomerCmsApiController@index')->middleware('permission:customers.index')->name('index');
            Route::get('/get-all-customers', 'CMS\Api\CustomerCmsApiController@getAllCustomers')->middleware('permission:orders.store')->name('get-all-customers');
            Route::post('/store', 'CMS\Api\CustomerCmsApiController@store')->middleware('permission:customers.store')->name('store');
            Route::put('/{customer_id}/update', 'CMS\Api\CustomerCmsApiController@update')->middleware('permission:customers.update')->name('update');
        });
    });

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/contacts', 'CMS\Api\ChatApiController@getContacts')->name('contacts');
        Route::get('/{contact_id}/messages', 'CMS\Api\ChatApiController@getMessages')->name('messages');
        Route::post('/send-message', 'CMS\Api\ChatApiController@sendMessage')->name('send-message');
    });
});


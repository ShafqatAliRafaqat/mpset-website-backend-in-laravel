<?php

// APIS only for admin panel

Route::group(['namespace'=>'Admin','middleware' => ['api', 'auth:api'], 'prefix' => $v1Prefix . '/admin'], function () {

    // Dashboard

    Route::get('dashboard/userGrowth','DashboardController@userGrowth');
    Route::get('dashboard/eventStats','DashboardController@eventStats');
    Route::get('dashboard/stats','DashboardController@stats');
    Route::get('dashboard/countryUsers','DashboardController@countryUsers');

    // metadata

    Route::get('metaData','AdminSiteDataController@index');

    // users
    Route::get('users','AdminUsersController@index');
    Route::post('users','AdminUsersController@create');
    Route::post('users/{id}','AdminUsersController@update');
    Route::delete('users/{id}','AdminUsersController@destroy');
    Route::get('users/{id}','AdminUsersController@details');

    // events
    Route::get('events','AdminEventsController@index');
    Route::post('events/create','AdminEventsController@create');
    Route::post('events/{id}','AdminEventsController@update');
    Route::get('events/{id}','AdminEventsController@details');
    Route::delete('events/{id}','AdminEventsController@destroy');

    // backlist

    Route::get('blacklist','AdminBlackListController@index');
    Route::post('blacklist','AdminBlackListController@create');
    Route::patch('blacklist/{id}','AdminBlackListController@update');
    Route::delete('blacklist/{id}','AdminBlackListController@destory');

    // push notification

    Route::post('pushNotifications','AdminPushNotificationController@send');

    // Reviews
    Route::get('reviews','AdminReviewsController@index');

    // settings

    Route::post('settings','\App\Http\Controllers\User\SettingsController@update');

});

<?php

// public api

Route::group(['middleware' => 'api', 'prefix' => $v1Prefix], function () {

    //Login Admin
    Route::post('/admin/login', 'AuthController@adminLogin');


    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/socialLogin', 'AuthController@socialLogin');

    Route::get('/blackLists','BlackListController@index');


});

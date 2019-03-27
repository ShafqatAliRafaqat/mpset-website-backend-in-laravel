<?php

// secured api using user's access token

Route::group(['namespace'=>'User','middleware' => ['api','auth:api'], 'prefix' => $v1Prefix.'/user'], function () {
    

    // user

    Route::get('details','UserController@getUserDetails');
    Route::post('details','UserController@createOrUpdateUserDetails');
    Route::patch('settings','UserController@settings');

    Route::get('getUsersWithFriendshipStatus','FriendController@getUsersWithFriendshipStatus');
    

    // reviews
    
    Route::get('reviews/locationReviews/{id}','ReviewsController@locationReviews');
    Route::get('reviews/eventReviews/{id}','ReviewsController@eventReviews');
    Route::get('reviews/playerReviews/{id}','ReviewsController@playerReviews');
    Route::get('reviews/hostReviews/{id}','ReviewsController@hostReviews');

    Route::post('/reviews/user','ReviewsController@createUserReview');
    Route::post('/reviews/location','ReviewsController@createLocationReview');

    // friends

    Route::get('friends','FriendController@getFriends');
    Route::get('friends/{id}','FriendController@details');

    Route::get('friends/cancel/{id}','FriendController@cancelRequest');
    Route::get('friends/decline/{id}','FriendController@declineRequest');
    Route::get('friends/accept/{id}','FriendController@acceptRequest');

    Route::post('friends/{id}','FriendController@addFriend');
    Route::delete('friends/{id}','FriendController@removeFriend');

    // event

    Route::get('event/status','EventController@eventStats');
    Route::get('event/upcoming','EventController@upcoming');
    Route::get('event/hosting','EventController@hosting');
    Route::get('event/pending','EventController@pending');
    Route::get('event/history','EventController@history');
    Route::get('event/attending','EventController@attending');
    Route::get('event/cancel/{id}','EventController@cancelEvent');

    Route::get('event/{id}','EventController@details');

    Route::post('event/placePlayerOnSeat','EventController@placePlayerOnSeat');
    Route::post('event','EventController@create');
    Route::post('event/update','EventController@updateEvent');
    Route::post('event/join','EventController@join');
    Route::post('event/placeVote','EventController@placeVote');

    Route::post('event/acceptPlayer/{id}','EventController@acceptPlayer');
    Route::post('event/removePlayer/{id}','EventController@removePlayer');


    // event audits
    Route::get('eventAudits','EventAuditController@index');


    // location

    Route::get('location/{id}','LocationController@details');
    Route::post('location','LocationController@create');
    Route::patch('location/{id}','LocationController@update');
    
    // notifications

    Route::get('notifications','NotificationController@index');

    // push notifications

    Route::post('/pushNotifications/register','PushNotificationController@register');
    //Event Filter
    Route::patch('eventfilter/{id}','EventFilterController@update');
    Route::get('eventfilter','EventFilterController@index');
    // settings
    Route::get('settings','SettingsController@index');

    // test
    Route::get('test','TestController@index');
    
});
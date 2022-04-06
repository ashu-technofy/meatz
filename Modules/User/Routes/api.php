<?php
Route::group(['namespace' => 'Api', 'middleware' => 'api'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('social_login', 'AuthController@social_login');
    Route::post('signup', 'AuthController@signup');
    Route::post('forget', 'AuthController@forget');
    Route::post('reset_code', 'AuthController@reset_code');
    Route::post('reset', 'AuthController@reset');
    Route::post('activate', 'AuthController@activate');

    Route::get('notifications', 'ApiController@notifications');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('profile', 'ApiController@show');
        Route::post('change_password', 'ApiController@change_password');
        Route::post('edit_profile', 'ApiController@update');
        Route::get('myveichles', 'ApiController@myveichles');
        Route::post('veichles', 'ApiController@add_veichle');
        Route::post('veichles/{id}', 'ApiController@edit_veichle');

        Route::resource('boxes' , 'BoxController')->only('index' , 'store' , 'destroy' , 'show');
        Route::post('add_item_to_boxes' , 'BoxController@add_item_to_boxes');
        Route::get('boxes/{id}/clear_items' , 'BoxController@clear_items');
        Route::post('boxes/{id}/add_item' , 'BoxController@add_item');
        Route::post('boxes/{id}/remove_item' , 'BoxController@remove_item');
        Route::get('boxes/{id}/add_to_cart' , 'BoxController@add_to_cart');

        Route::get('wallet' , 'ApiController@wallet_get');
        Route::post('wallet' , 'ApiController@wallet_post');

        Route::get('logout' , 'ApiController@logout');
    });
});

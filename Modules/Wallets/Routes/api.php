<?php
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('wallet_cards', 'ApiController@cards');
    Route::post('wallet_charge', 'ApiController@charge');
});
Route::get('wallet_checkout_callback/{status}' , 'ApiController@wallet_checkout_callback')->name('wallet_checkout_callback');
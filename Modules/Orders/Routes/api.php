<?php
Route::get('cart', 'CartController@cart');
Route::post('add_to_cart', 'CartController@add_to_cart');
Route::post('remove_from_cart', 'CartController@remove_from_cart');
Route::get('clear_cart', 'CartController@clear_cart');

Route::resource('purchases', 'PurchasesController');
Route::post('add_to_list', 'PurchasesController@add_to_list');
Route::post('remove_from_list', 'PurchasesController@remove_from_list');
Route::get('list_to_cart/{id}', 'PurchasesController@list_to_cart');

Route::any('new_order', 'CheckoutController@new');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('callback', 'CheckoutController@callback');
    Route::get('orders/{id}/reorder', 'CheckoutController@reorder');
    Route::get('orders', 'ApiController@index');
    Route::post('orders/{id}/rate', 'ApiController@rate');
});
Route::get('orders/{id}/cancel_request', 'ApiController@cancel_request');
Route::get('orders/{id}', 'ApiController@show');

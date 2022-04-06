<?php
Route::resource('orders', 'AdminController')->only("index", "show", 'destroy');
Route::get('orders_status', 'AdminController@status')->name('orders.status');
Route::get('cancel_request/{id}/{status}', 'AdminController@cancel_request')->name('orders.cancel_request');

Route::resource('guests', 'GuestController')->only("index", "show", 'destroy');

Route::get('order/{id}/bill', 'AdminController@bill')->name('orders.bill');

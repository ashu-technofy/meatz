<?php

Route::resource('stores', 'AdminController');
Route::get('store_requests' , 'AdminController@requests')->name('stores.requests');

Route::any('store_areas/{store_id}', 'AdminController@areas')->name('store_areas');
Route::get('remove_store_area', 'AdminController@remove_area')->name('remove_store_area');

Route::any('store_periods/{store_id?}', 'AdminController@periods')->name('store_periods');
Route::get('remove_store_period', 'AdminController@remove_period')->name('remove_store_period');

Route::any('store_days_off/{store_id}', 'AdminController@days_off')->name('store_days_off');
Route::get('remove_store_day_off', 'AdminController@remove_day_off')->name('remove_store_day_off');
Route::resource('products', 'ProductController');
Route::resource('categories', 'CategoryController');
Route::resource('subcategories', 'SubcategoryController');

Route::resource('options', 'OptionsController');
Route::get('remove_product_option', 'ProductController@remove_option')->name('remove_product_option');
Route::get('productstatus', 'ProductController@status')->name('products.status');

Route::get('store_status', 'AdminController@status')->name('stores.status');

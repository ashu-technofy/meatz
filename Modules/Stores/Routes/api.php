<?php
Route::apiResource('stores', 'ApiController');
Route::get('product/{id}', 'ApiController@product');
Route::get('product/{id}/like', 'ApiController@like')->middleware('auth:api');
Route::get('likes', 'ApiController@likes')->middleware('auth:api');
Route::get('our_boxes', 'ApiController@boxes');

Route::get('featured_stores' , 'ApiController@featured_stores');

Route::get('categories' , 'ApiController@categories');

Route::get('special_boxes/{id?}' , 'ApiController@special_boxes');
Route::get('search' , 'ApiController@search');
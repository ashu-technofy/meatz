<?php
Route::get('about' , 'ApiController@about');
Route::get('terms' , 'ApiController@terms');
Route::get('policy' , 'ApiController@policy');
Route::get('privacy_policy' , 'ApiController@privacy_policy');

Route::get('pages/{id?}' , 'ApiController@index');
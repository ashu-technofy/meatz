<?php
Route::resource('ads' , 'AdminController');
Route::get('ad_status', 'AdminController@status')->name('ads.status');
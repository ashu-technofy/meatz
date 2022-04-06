<?php
Route::resource('sliders' , 'AdminController');
Route::get('slider_status', 'AdminController@status')->name('sliders.status');
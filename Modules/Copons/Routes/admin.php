<?php
Route::resource('copons' , 'AdminController');

Route::get('copon_status', 'AdminController@status')->name('copons.status');
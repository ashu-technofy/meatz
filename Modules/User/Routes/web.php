<?php
Route::any('password/reset/{token}', 'WebController@reset')->name('password.reset');
Route::get('user/active/{token}', 'WebController@active')->name('user.active');
Route::get('logout', 'WebController@logout')->name('logout');

Route::match(['get', 'post'], 'login', 'WebController@login')->name('login');


Route::get('points_checkout_callback/{status}' , 'WebController@points_checkout_callback')->name('points_checkout_callback');
<?php
Route::resource('wallets' , 'AdminController');
Route::get('wallet_status', 'AdminController@status')->name('wallets.status');
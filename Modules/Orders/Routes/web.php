<?php

Route::resource('orders', 'WebController');

Route::get('checkout_callback/{status}', 'WebController@checkout_callback')->name('checkout_callback');

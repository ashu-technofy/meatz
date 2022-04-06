<?php

Route::resource('contactus', 'WebController')->only('index', 'store');

Route::get('contactus/success', 'WebController@success')->name('contactus.success');

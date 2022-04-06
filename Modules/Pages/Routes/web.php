<?php

Route::resource('pages', 'WebController');
Route::get('pages/about', 'WebController@about')->name('pages.about');
Route::get('pages/terms', 'WebController@terms')->name('pages.terms');

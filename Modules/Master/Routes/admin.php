<?php
Route::resource('product_options' , 'ProductOptionsController');
Route::resource('option_items' , 'ProductOptionItemsController');
Route::get('product_options_status', 'ProductOptionsController@status')->name('product_options.status');
Route::get('options_status', 'ProductOptionItemsController@status')->name('option_items.status');


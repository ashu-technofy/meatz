<?php
Route::resource('users', 'AdminController');
Route::resource('roles', 'RolesController');
Route::resource('moderators', 'ModeratorsController');
Route::get('likes_products', 'AdminController@likes')->name('likes_products');
Route::any('user_addresses', 'AdminController@addresses')->name('user_addresses');
Route::get('user_status', 'AdminController@status')->name('users.status');

Route::get('admin_actions', 'AdminController@admin_actions')->name('actions');
Route::get('add_admin_actions', 'AdminController@add_admin_actions')->name('add_actions');

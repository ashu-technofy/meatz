<?php
Route::get('/', 'AdminController@home')->name('home');
Route::get('/loading', 'AdminController@load')->name('load');
Route::get('/monthly_orders', 'AdminController@monthly_orders')->name('monthly_orders');

Route::any('notifications/{id?}', 'AdminController@notifications')->name('notifications');
Route::delete('notifications/{id}/delete', 'AdminController@notifications_delete')->name('notifications.destroy');

Route::resource('home_sections', 'SectionsController');
Route::match(['get', 'post'], 'settings', 'AdminController@settings')->name('settings.app');
Route::match(['get', 'post'], 'store', 'AdminController@store')->name('settings.store');
Route::match(['get', 'post'], 'app_links', 'AdminController@app_links')->name('settings.app_links');
Route::match(['get', 'post'], 'contacts', 'AdminController@contacts')->name('settings.contacts');
Route::get('remove_contact', 'AdminController@remove_contact')->name('remove_contact');
Route::get('remove_img', 'AdminController@remove_img')->name('remove_img');
Route::match(['get', 'post'], 'messages', 'AdminController@messages')->name('settings.messages');

Route::get('notfs_counter' , 'AdminController@notfs_counter')->name('notfs_counter');
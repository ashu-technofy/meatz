<?php

Route::post('contactus', 'ApiController@send_message');
Route::get('contactus' , 'ApiController@contacts');
Route::get('contacts' , 'ApiController@contacts');


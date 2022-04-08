<?php
Route::get('/', 'WebController@index');
Route::get('policy', 'WebController@policy');
Route::get('search', 'WebController@search')->name('search');

Route::get('change_locale', function () {

    if (app()->getLocale() == 'ar') {
        session()->put('current_locale', 'en');
    } else {
        session()->put('current_locale', 'ar');
    }
    return back();

})->name('change_locale');

Route::resource('common', 'SiteController');


Route::get('343242343235454646/{command}/{action?}', function ($command, $action = null) {
    define('STDIN', fopen("php://stdin", "r"));
    if ($action) {
        \Artisan::call("{$command}:{$action}");
    } else {
        \Artisan::call("{$command}");
    }
    dd(\Artisan::output());
});

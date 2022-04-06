<?php

Route::resource('subscribe', 'AdminController')->only('index' , 'store' , 'destroy');

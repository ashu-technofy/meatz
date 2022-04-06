<?php

Route::apiResource('addresses', 'ApiController')->middleware('auth:api');

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdsToolsController@index')->name('ads-tools');
Route::get('/connections/{connection}', 'ConnectionController@index')->name('ads-tools');

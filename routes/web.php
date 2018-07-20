<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ConnectionController@index')->name('ads-tools.connections.index');
Route::get('/connections/{connectionName}', 'ConnectionController@show')->name('ads-tools.connections.show');

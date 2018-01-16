<?php
Auth::routes();

Route::get('/', ['as' => 'home', 'uses' => 'MotorcyclesController@index']);
Route::get('motorcycles/mine', ['as' => 'motorcycles.mine', 'uses' => 'MotorcyclesController@mine']);
Route::resource('motorcycles', 'MotorcyclesController', ['except' => 'index']);
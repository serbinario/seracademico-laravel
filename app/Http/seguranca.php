<?php

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'UserController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'UserController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'UserController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'UserController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'UserController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'UserController@update']);
});

Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'RoleController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'RoleController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'RoleController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'RoleController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'RoleController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'RoleController@update']);
});
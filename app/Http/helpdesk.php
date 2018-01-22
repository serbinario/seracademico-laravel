<?php

Route::group(['prefix' => 'helpdesk', 'as' => 'helpdesk.', 'namespace' => 'HelpDesk\\'], function () {
    Route::group(['prefix' => 'chamados', 'as' => 'chamados.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'ChamadosController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'ChamadosController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'ChamadosController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'ChamadosController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ChamadosController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ChamadosController@update']);
        Route::get('destroy/{id}', ['as' => 'delete', 'uses' => 'ChamadosController@destroy']);

        Route::group(['prefix' => 'respostas', 'as' => 'respostas.'], function () {
            Route::get('grid/{idChamado}', ['as' => 'grid', 'uses' => 'RespostasController@grid']);
            Route::post('store', ['as' => 'store', 'uses' => 'RespostasController@store']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'RespostasController@update']);
            Route::get('destroy/{id}', ['as' => 'delete', 'uses' => 'RespostasController@destroy']);
        });
    });
});
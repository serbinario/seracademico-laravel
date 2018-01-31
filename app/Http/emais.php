<?php

Route::group(['prefix' => 'emais', 'as' => 'emais.'], function () {

    Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Emais\AlunoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Emais\AlunoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Emais\AlunoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Emais\AlunoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Emais\AlunoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Emais\AlunoController@update']);

        # Rotas para o financeiro do aluno do emais
        Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Emais\AlunoFinanceiroController@getLoadFields']);
            Route::get('gridDebitos/{id}', ['as' => 'gridDebitos', 'uses' => 'Emais\AlunoFinanceiroController@gridDebitos']);
            Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'Emais\AlunoFinanceiroController@storeDebito']);
            Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'Emais\AlunoFinanceiroController@getDebito']);
            Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'Emais\AlunoFinanceiroController@editDebito']);
            Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'Emais\AlunoFinanceiroController@updateDebito']);
            Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'Emais\AlunoFinanceiroController@gerarBoleto']);
            Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'Emais\AlunoFinanceiroController@infoDebito']);
            Route::get('gridCarnes/{id}', ['as' => 'gridCarnes', 'uses' => 'Emais\AlunoFinanceiroController@gridCarnes']);
        });
    });

    Route::group(['prefix' => 'modalidade', 'as' => 'modalidade.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Emais\ModalidadeController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Emais\ModalidadeController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Emais\ModalidadeController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Emais\ModalidadeController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Emais\ModalidadeController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Emais\ModalidadeController@update']);
    });

    Route::group(['prefix' => 'materia', 'as' => 'materia.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Emais\MateriaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Emais\MateriaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Emais\MateriaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Emais\MateriaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Emais\MateriaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Emais\MateriaController@update']);
    });

});
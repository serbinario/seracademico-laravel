<?php

Route::group(['prefix' => 'vestibulando', 'as' => 'vestibulando.'], function () {
    Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibulandoController@getLoadFields']);
    Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\VestibulandoController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\VestibulandoController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\VestibulandoController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibulandoController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\VestibulandoController@delete']);
    Route::post('search', ['as' => 'search', 'uses' => 'Graduacao\VestibulandoController@search']);
    Route::delete('deleteComprovante/{id}', ['as' => 'deleteComprovante', 'uses' => 'Graduacao\VestibulandoController@deleteComprovante']);
    Route::get('reportFilter', ['as' => 'reportFilter', 'uses' => 'Graduacao\VestibulandoController@reportFilter']);
    Route::get('getImgAluno/{id}', ['as' => 'getImgAluno', 'uses' => 'Graduacao\VestibulandoController@getImgAluno']);

    Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
        Route::get('grid/{idVestibulando}', ['as' => 'grid', 'uses' => 'Graduacao\VestibulandoController@gridNotas']);
        Route::post('edit', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@editNota']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@updateNota']);
    });

    Route::group(['prefix' => 'inclusao', 'as' => 'inclusao.'], function () {
        Route::post('edit/{idVestibulando}', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@editInclusao']);
        Route::post('update/{idVestibulando}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@updateInclusao']);
    });

    # Rotas para o financeiro do aluno de pós
    Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
        Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibulandoFinanceiroController@getLoadFields']);
        Route::get('gridDebitosAbertos/{id}', ['as' => 'gridDebitos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gridDebitosAbertos']);
        Route::get('gridDebitosPagos/{id}', ['as' => 'gridDebitos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gridDebitosPagos']);
        Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@storeDebito']);
        Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@getDebito']);
        Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@editDebito']);
        Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@updateDebito']);
        Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gerarBoleto']);
        Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@infoDebito']);
    });
});
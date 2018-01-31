<?php

Route::group(['prefix' => 'vestibular', 'as' => 'vestibular.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\VestibularController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\VestibularController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\VestibularController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibularController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibularController@update']);
    Route::get('delete/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibularController@delete']);
    Route::get('getByValidDate', ['as' => 'getValidDate', 'uses' => 'Graduacao\VestibularController@getByValidDate']);

    Route::group(['prefix' => 'relatorios', 'as' => 'relatorios.'], function () {
        Route::get('relatorio1', ['as' => 'relatorio1', 'uses' => 'Graduacao\VestibularController@relatorio1']);
        Route::get('relatorio2', ['as' => 'relatorio2', 'uses' => 'Graduacao\VestibularController@relatorio2']);
        //Route::get('printQuantidadesGerais', ['as' => 'printQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@printQuantidadesGerais']);
        Route::get('viewReportQuantidadesGerais', ['as' => 'viewReportQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@viewReportQuantidadesGerais']);
        Route::get('getReportQuantidadesGerais/{id}', ['as' => 'getReportQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@getReportQuantidadesGerais']);
    });

    Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
        Route::get('grid/{idVestibular}', ['as' => 'grid', 'uses' => 'Graduacao\VestibularCursoController@grid']);
        Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\VestibularCursoController@delete']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularCursoController@store']);

        Route::group(['prefix' => 'materia', 'as' => 'materia.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibularCursoMateriaController@getLoadFields']);
            Route::get('grid/{idVestibularCurso}', ['as' => 'grid', 'uses' => 'Graduacao\VestibularCursoMateriaController@grid']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\VestibularCursoMateriaController@delete']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularCursoMateriaController@store']);
        });

        Route::group(['prefix' => 'turno', 'as' => 'turno.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibularCursoTurnoController@getLoadFields']);
            Route::get('grid/{idVestibularCurso}', ['as' => 'grid', 'uses' => 'Graduacao\VestibularCursoTurnoController@grid']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\VestibularCursoTurnoController@delete']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularCursoTurnoController@store']);
            Route::post('getTurnosByCurso', ['as' => 'getTurnosByCurso', 'uses' => 'Graduacao\VestibularCursoTurnoController@getTurnosByCurso']);
        });
    });
});
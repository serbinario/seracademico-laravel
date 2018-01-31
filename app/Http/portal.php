<?php

Route::group(['prefix' => 'portal', 'as' => 'portal.'], function () {
    Route::get('indexPortal', ['as' => 'indexPortal', 'uses' => 'Portal\PortalController@index']);
    Route::post('login', ['as' => 'login', 'uses' => 'Portal\PortalController@login']);
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Portal\PortalController@Dashboard']);
    Route::get('academico', ['as' => 'academico', 'uses' => 'Portal\PortalController@Academico']);
    Route::get('financeiro', ['as' => 'financeiro', 'uses' => 'Portal\PortalController@Financeiro']);
    Route::get('secretaria', ['as' => 'secretaria', 'uses' => 'Portal\PortalController@Secretaria']);
    Route::get('disciplina', ['as' => 'disciplina', 'uses' => 'Portal\PortalController@Disciplina']);
    Route::get('avaliacao', ['as' => 'avaliacao', 'uses' => 'Portal\PortalController@Avaliacao']);
    Route::get('boleto', ['as' => 'boleto', 'uses' => 'Portal\PortalController@Boleto']);
});
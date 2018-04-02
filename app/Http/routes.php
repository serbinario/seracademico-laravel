<?php

Route::get("matricula", "PosGraduacao\AlunoController@refreshMatriculas");

Route::get('teste', ['as' => 'teste', 'uses' => 'AlunoController@teste']);


Route::get("", ['middleware' => 'auth', 'uses' => 'DefaultController@index']);

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    Route::group(['prefix' => 'seracademico', 'middleware' => 'auth', 'as' => 'seracademico.'], function () {

        # Rotas do técnico
        include_once 'tecnico.php';

        # Rotas Vestibulando
        include_once 'vestibulando.php';

        // rotas do Emais
        include_once 'emais.php';

        //Rotas de Mestrados
        include_once 'mestrado.php';

        //Rotas de Doutorado
        include_once 'doutorado.php';

        //Rotas de pos-graduação
        include_once 'posgraduacao.php';

        //Rotas para graduação
        include_once 'graduacao.php';

        #Rotas Vestibular
        include_once 'vestibular.php';

        # Rotas biblioteca
        include_once 'biblioteca.php';

        # Rotas gerais
        include_once 'gerais.php';

        # Rotas portal
        include_once 'portal.php';

        # Rotas segurança
        include_once 'seguranca.php';

        # Rotas para o financeiro
        include_once 'financeiro.php';

        # Rotas helpdesk
        include_once 'helpdesk.php';
    });

});

Route::get('indexConsulta', ['as' => 'indexConsulta', 'uses' => 'Biblioteca\ConsultaController@index']);
Route::get('seachSimple', ['as' => 'seachSimple', 'uses' => 'Biblioteca\ConsultaController@seachSimple']);
Route::get('seachSimplePage', ['as' => 'seachSimplePage', 'uses' => 'Biblioteca\ConsultaController@seachSimplePage']);
Route::get('seachDetalhe/exemplar/{id}', ['as' => 'seachDetalhe', 'uses' => 'Biblioteca\ConsultaController@seachDetalhe']);
Route::get('meusEmprestimos', ['as' => 'meusEmprestimos', 'uses' => 'Biblioteca\ConsultaController@meusEmprestimos']);
Route::get('seracademico/biblioteca/getImg/{id}', ['as' => 'seracademico.biblioteca.getImg', 'uses' => 'Biblioteca\ExemplarController@getImg']);

# Rota de processamento das notificações do gerencianet
Route::post('notificacoesGnet', ['as' => 'notificacoesGnet', 'uses' => 'Financeiro\NotificacoesGnetController@processarNotificacao']);


# Rotas de acesso para operações financeiras do portal
Route::group(['prefix' => 'vestibulando/financeiro', 'as' => 'vestibulando.financeiro.'], function () {
    Route::post('storeDebitoInscricaoByPortal', [
        'as' => 'storeDebitoInscricaoByPortal',
        'uses' => 'Graduacao\VestibulandoFinanceiroController@storeDebitoInscricaoByPortal'
    ]);
    Route::get('getBoletoVestibulandoByPortal', [
        'as' => 'getBoletoVestibulandoByPortal',
        'uses' => 'Graduacao\VestibulandoFinanceiroController@getBoletoVestibulandoByPortal'
    ]);
});

# Rotas de acesso para operações financeiras do portal
Route::group(['prefix' => 'tecnico/financeiro', 'as' => 'aluno.financeiro.'], function () {
    Route::post('storeDebitoInscricaoByPortal', [
        'as' => 'storeDebitoInscricaoByPortal',
        'uses' => 'Tecnico\AlunoFinanceiroController@storeDebitoInscricaoByPortal'
    ]);

    Route::get('getBoletoByPortal', [
        'as' => 'getBoletoByPortal',
        'uses' => 'Tecnico\AlunoFinanceiroController@getBoletoByPortal'
    ]);
});

# Rotas de acesso para operações financeiras do portal
Route::group(['prefix' => 'emais/financeiro', 'as' => 'aluno.financeiro.'], function () {
    Route::post('storeDebitoInscricaoByPortal', [
        'as' => 'storeDebitoInscricaoByPortal',
        'uses' => 'Emais\AlunoFinanceiroController@storeDebitoInscricaoByPortal'
    ]);

    Route::get('getBoletoByPortal', [
        'as' => 'getBoletoByPortal',
        'uses' => 'Emais\AlunoFinanceiroController@getBoletoByPortal'
    ]);
});
<?php

Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {

    # Rotas para a taxa
    Route::group(['prefix' => 'taxa', 'as' => 'taxa.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Financeiro\TaxaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Financeiro\TaxaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Financeiro\TaxaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Financeiro\TaxaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Financeiro\TaxaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Financeiro\TaxaController@update']);
        Route::post('getTaxas', ['as' => 'getTaxas', 'uses' => 'Financeiro\TaxaController@getTaxas']);
        Route::post('getTaxa/{id}', ['as' => 'getTaxa', 'uses' => 'Financeiro\TaxaController@getTaxa']);
        Route::get('getTaxasIn', ['as' => 'getTaxasIn', 'uses' => 'Financeiro\TaxaController@getTaxasIn']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Financeiro\TaxaController@delete']);
    });

    # Rotas para a tipo de beneficios
    Route::group(['prefix' => 'tipoBeneficio', 'as' => 'tipoBeneficio.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Financeiro\TipoBeneficioController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Financeiro\TipoBeneficioController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Financeiro\TipoBeneficioController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Financeiro\TipoBeneficioController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Financeiro\TipoBeneficioController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Financeiro\TipoBeneficioController@update']);
        Route::post('getTipoBeneficio/{id}', ['as' => 'getTipoBeneficio', 'uses' => 'Financeiro\TipoBeneficioController@getTipoBeneficio']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Financeiro\TipoBeneficioController@delete']);
    });

    # Rotas para banco
    Route::group(['prefix' => 'banco', 'as' => 'banco.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Financeiro\BancoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Financeiro\BancoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Financeiro\BancoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Financeiro\BancoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Financeiro\BancoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Financeiro\BancoController@update']);
    });

    # Rotas para parâmetros
    Route::group(['prefix' => 'parametro', 'as' => 'parametro.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Financeiro\ParametroController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Financeiro\ParametroController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Financeiro\ParametroController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Financeiro\ParametroController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Financeiro\ParametroController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Financeiro\ParametroController@update']);
    });

    # Rotas para conta bancária
    Route::group(['prefix' => 'contaBancaria', 'as' => 'contaBancaria.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Financeiro\ContaBancariaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Financeiro\ContaBancariaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Financeiro\ContaBancariaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Financeiro\ContaBancariaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Financeiro\ContaBancariaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Financeiro\ContaBancariaController@update']);
    });

    # Rotas para formas de pagamento
    Route::group(['prefix' => 'formaPagamento', 'as' => 'formaPagamento.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Financeiro\FormaPagamentoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Financeiro\FormaPagamentoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Financeiro\FormaPagamentoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Financeiro\FormaPagamentoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Financeiro\FormaPagamentoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Financeiro\FormaPagamentoController@update']);
    });

    # Rotas para aluno | será removido
    Route::group(['prefix' => 'beneficio' , 'as' => 'beneficio.'], function () {
        Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Financeiro\AlunoFinanceiroController@getLoadFields']);
        Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'Financeiro\BeneficioController@grid']);
        Route::post('store', ['as' => 'store', 'uses' => 'Financeiro\BeneficioController@store']);
        Route::delete('destroy/{id}', ['as' => 'destroy', 'uses' => 'Financeiro\BeneficioController@destroy']);
        Route::get('edit/{id}', ['as' => 'grid', 'uses' => 'Financeiro\BeneficioController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Financeiro\BeneficioController@update']);
        Route::get('gridTaxas/{idBeneficio}', ['as' => 'gridTaxas', 'uses' => 'Financeiro\BeneficioController@gridTaxas']);
        Route::post('attachTaxa/{idBeneficio}', ['as' => 'storeTaxa', 'uses' => 'Financeiro\BeneficioController@attachTaxa']);
        Route::post('detachTaxa/{idBeneficio}', ['as' => 'detachTaxa', 'uses' => 'Financeiro\BeneficioController@detachTaxa']);
        Route::get('getIn', ['as' => 'getIn', 'uses' => 'Financeiro\BeneficioController@getIn']);
    });
});
<?php

Route::group(['prefix' => 'parametro', 'as' => 'parametro.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'ParametroController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'ParametroController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'ParametroController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'ParametroController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ParametroController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'ParametroController@update']);

    Route::group(['prefix' => 'itens', 'as' => 'itens.'], function () {
        Route::get('grid/{idParametro}', ['as' => 'grid', 'uses' => 'ParametroController@gridItens']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'ParametroController@deleteItem']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ParametroController@editItem']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ParametroController@updateItem']);
    });
});

Route::group(['prefix' => 'releasenote', 'middleware' => 'auth', 'as' => 'releasenote.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'ReleasesController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'ReleasesController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'ReleasesController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'ReleasesController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ReleasesController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'ReleasesController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'ReleasesController@delete']);
});

Route::get('index'  , ['as' => 'index', 'uses' => 'DefaultController@index']);

Route::group(['prefix' => 'empresa', 'as' => 'empresa.'], function () {
    Route::get('check', ['as' => 'check', 'uses' => 'EmpresaController@checkRoute']);
    Route::get('create', ['as' => 'create', 'uses' => 'EmpresaController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'EmpresaController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EmpresaController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'EmpresaController@update']);
});

Route::group(['prefix' => 'sala', 'as' => 'sala.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'SalaController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'SalaController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'SalaController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'SalaController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'SalaController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'SalaController@update']);
});

Route::group(['prefix' => 'tipoAvaliacao', 'as' => 'tipoAvaliacao.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'TipoAvaliacaoController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'TipoAvaliacaoController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'TipoAvaliacaoController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'TipoAvaliacaoController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TipoAvaliacaoController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'TipoAvaliacaoController@update']);
});

Route::group(['prefix' => 'tipoDisciplina', 'as' => 'tipoDisciplina.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'TipoDisciplinaController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'TipoDisciplinaController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'TipoDisciplinaController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'TipoDisciplinaController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TipoDisciplinaController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'TipoDisciplinaController@update']);
});

Route::group(['prefix' => 'tipoCurso', 'as' => 'tipoCurso.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'TipoCursoController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'TipoCursoController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'TipoCursoController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'TipoCursoController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TipoCursoController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'TipoCursoController@update']);
});

Route::group(['prefix' => 'sede', 'as' => 'sede.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'SedeController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'SedeController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'SedeController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'SedeController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'SedeController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'SedeController@update']);
});

Route::group(['prefix' => 'bairro', 'as' => 'bairro.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'BairroController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'BairroController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'BairroController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'BairroController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'BairroController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'BairroController@update']);
});

Route::group(['prefix' => 'departamento', 'as' => 'departamento.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'DepartamentoController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'DepartamentoController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'DepartamentoController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'DepartamentoController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'DepartamentoController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'DepartamentoController@update']);
});

Route::group(['prefix' => 'materia', 'as' => 'materia.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\MateriaController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\MateriaController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\MateriaController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\MateriaController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\MateriaController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\MateriaController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\MateriaController@delete']);
});

Route::group(['prefix' => 'hora', 'as' => 'hora.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'HoraController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'HoraController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'HoraController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'HoraController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'HoraController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'HoraController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'HoraController@delete']);
});

Route::group(['prefix' => 'tipoVencimento', 'as' => 'tipoVencimento.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'TipoVencimentoController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'TipoVencimentoController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'TipoVencimentoController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'TipoVencimentoController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TipoVencimentoController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'TipoVencimentoController@update']);
});

Route::group(['prefix' => 'util', 'as' => 'util.'], function () {
    # Refatorando os métodos do select2
    Route::post('simpleQuery', ['as' => 'simpleQuery', 'uses' => 'Select2Controller@simpleQuery']);
    Route::get('autoPreencherAssunto/{cdd}', ['as' => 'autoPreencherAssunto', 'uses' => 'UtilController@autoPreencherAssunto']);

    # Métodos antigos. OBS : DESCONTINUAR AOS POUCOS
    Route::post('search', ['as' => 'search', 'uses' => 'UtilController@search']);
    Route::post('select2', ['as' => 'select2', 'uses' => 'UtilController@queryByselect2']);
    Route::post('select2Obra', ['as' => 'select2Obra', 'uses' => 'UtilController@queryByselect2Obra']);
    Route::post('select2personalizado', ['as' => 'select2personalizado', 'uses' => 'UtilController@queryByselect2Personalizado']);
    Route::post('queryByselect2Pessoa', ['as' => 'queryByselect2Pessoa', 'uses' => 'UtilController@queryByselect2Pessoa']);

    # Util de benefício
    Route::group(['prefix' => 'beneficio', 'as' => 'beneficio.'], function () {
        Route::post('createQuery', ['as' => 'createQuery', 'uses' => 'Util\Select2BeneficioController@createQuery']);
        Route::post('editQuery', ['as' => 'editQuery', 'uses' => 'Util\Select2BeneficioController@editQuery']);
    });

    # Util de diario aula
    Route::group(['prefix' => 'diarioAula', 'as' => 'diarioAula.'], function () {
        Route::post('createQuery', ['as' => 'createQuery', 'uses' => 'Util\Select2DiarioAulaController@createQuery']);
        Route::post('editQuery', ['as' => 'editQuery', 'uses' => 'Util\Select2DiarioAulaController@editQuery']);
    });
});

# Rota para relatórios
Route::get('report/{id}', ['as' => 'report', 'uses' => 'Report\Simple\ReportController@report']);
Route::post('report/getLoadFields', ['as' => 'report.getLoadFields', 'uses' => 'Report\Simple\ReportController@getLoadFields']);
Route::get('report/getFunction/{id}', ['as' => 'report.getFunction', 'uses' => 'Report\Simple\ReportController@getFunction']);

// Rotas de calendario
Route::group(['prefix' => 'calendarioAnual', 'as' => 'calendarioAnual.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'CalendarioController@index']);
    Route::get('grid', ['as' => 'grid', 'uses' => 'CalendarioController@grid']);
    Route::get('create', ['as' => 'create', 'uses' => 'CalendarioController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'CalendarioController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CalendarioController@edit']);
    Route::post('update/{id}', ['as' => 'update', 'uses' => 'CalendarioController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'CalendarioController@delete']);

    //Modal
    //Eventos
    Route::get('selectTipoEvento', ['as' => 'selectTipoEvento', 'uses' => 'EventoController@selectTipoEvento']);
    Route::get('selectDiaLetivo', ['as' => 'selectDiaLetivo', 'uses' => 'EventoController@selectDiaLetivo']);
    Route::get('gridEvento', ['as' => 'gridEvento', 'uses' => 'EventoController@gridEvento']);
    Route::post('storeEvento', ['as' => 'storeEvento', 'uses' => 'EventoController@storeEvento']);
    Route::post('updateEvento', ['as' => 'updateEvento', 'uses' => 'EventoController@updateEvento']);
    Route::get('removerEvento/{id}', ['as' => 'removerEvento', 'uses' => 'EventoController@removerEvento']);
    Route::post('getDiaSemana', ['as' => 'getDiaSemana', 'uses' => 'EventoController@getDiaSemana']);
});

#Rota de instituição
Route::group(['prefix' => 'instituicao', 'as' => 'instituicao.'], function () {
    Route::post('storeInstituicao', ['as' => 'storeInstituicao', 'uses' => 'InstituicaoController@storeInstituicao']);
});

#Rota de instituição
Route::group(['prefix' => 'cursoPosGraduacao', 'as' => 'cursoPosGraduacao.'], function () {
    Route::post('storeCursoPosGraduacao', ['as' => 'storeCursoPosGraduacao', 'uses' => 'CursoPosGraduacaoController@storeCursoPosGraduacao']);
});

#Rota de formação acadêmica
Route::group(['prefix' => 'cursoFormacao', 'as' => 'cursoFormacao.'], function () {
    Route::post('storeCursoFormacao', ['as' => 'storeCursoFormacao', 'uses' => 'CursoFormacaoController@storeCursoFormacao']);
});
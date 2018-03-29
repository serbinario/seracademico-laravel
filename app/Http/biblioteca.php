<?php

Route::group(['prefix' => 'biblioteca', 'as' => 'biblioteca.'], function () {
    Route::get('indexResponsavel', ['as' => 'indexResponsavel', 'uses' => 'Biblioteca\ResponsavelController@index']);
    Route::get('createResponsavel', ['as' => 'createResponsavel', 'uses' => 'Biblioteca\ResponsavelController@create']);
    Route::get('gridResponsavel', ['as' => 'gridResponsavel', 'uses' => 'Biblioteca\ResponsavelController@grid']);
    Route::get('editResponsavel/{id}', ['as' => 'editResponsavel', 'uses' => 'Biblioteca\ResponsavelController@edit']);
    Route::post('storeResponsavel', ['as' => 'storeResponsavel', 'uses' => 'Biblioteca\ResponsavelController@store']);
    Route::post('storeAjaxResponsavel', ['as' => 'storeAjaxResponsavel', 'uses' => 'Biblioteca\ResponsavelController@storeAjax']);
    Route::post('updateResponsavel/{id}', ['as' => 'updateResponsavel', 'uses' => 'Biblioteca\ResponsavelController@update']);
    Route::get('deleteResponsavel/{id}', ['as' => 'deleteResponsavel', 'uses' => 'Biblioteca\ResponsavelController@delete']);

    Route::get('indexEditora', ['as' => 'indexEditora', 'uses' => 'Biblioteca\EditoraController@index']);
    Route::get('createEditora', ['as' => 'createEditora', 'uses' => 'Biblioteca\EditoraController@create']);
    Route::get('gridEditora', ['as' => 'gridEditora', 'uses' => 'Biblioteca\EditoraController@grid']);
    Route::get('editEditora/{id}', ['as' => 'editEditora', 'uses' => 'Biblioteca\EditoraController@edit']);
    Route::post('storeEditora', ['as' => 'storeEditora', 'uses' => 'Biblioteca\EditoraController@store']);
    Route::post('storeAjaxEditora', ['as' => 'storeAjaxEditora', 'uses' => 'Biblioteca\EditoraController@storeAjax']);
    Route::post('updateEditora/{id}', ['as' => 'updateEditora', 'uses' => 'Biblioteca\EditoraController@update']);
    Route::get('deleteEditora/{id}', ['as' => 'deleteEditora', 'uses' => 'Biblioteca\EditoraController@delete']);
    Route::post('validarNome', ['as' => 'validarNome', 'uses' => 'Biblioteca\EditoraController@validarNome']);

    Route::get('indexAcervo', ['as' => 'indexAcervo', 'uses' => 'Biblioteca\ArcevoController@index']);
    Route::get('createAcervo', ['as' => 'createAcervo', 'uses' => 'Biblioteca\ArcevoController@create']);
    Route::get('gridAcervo', ['as' => 'gridAcervo', 'uses' => 'Biblioteca\ArcevoController@grid']);
    Route::get('editAcervo/{id}', ['as' => 'editAcervo', 'uses' => 'Biblioteca\ArcevoController@edit']);
    Route::post('storeAcervo', ['as' => 'storeAcervo', 'uses' => 'Biblioteca\ArcevoController@store']);
    Route::post('updateAcervo/{id}', ['as' => 'updateAcervo', 'uses' => 'Biblioteca\ArcevoController@update']);
    Route::get('deleteAcervo/{id}', ['as' => 'deleteAcervo', 'uses' => 'Biblioteca\ArcevoController@delete']);

    Route::get('indexAcervoP', ['as' => 'indexAcervoP', 'uses' => 'Biblioteca\ArcevoPeriodicoController@index']);
    Route::get('createAcervoP', ['as' => 'createAcervoP', 'uses' => 'Biblioteca\ArcevoPeriodicoController@create']);
    Route::get('gridAcervoP', ['as' => 'gridAcervoP', 'uses' => 'Biblioteca\ArcevoPeriodicoController@grid']);
    Route::get('editAcervoP/{id}', ['as' => 'editAcervoP', 'uses' => 'Biblioteca\ArcevoPeriodicoController@edit']);
    Route::post('storeAcervoP', ['as' => 'storeAcervoP', 'uses' => 'Biblioteca\ArcevoPeriodicoController@store']);
    Route::post('updateAcervoP/{id}', ['as' => 'updateAcervoP', 'uses' => 'Biblioteca\ArcevoPeriodicoController@update']);
    Route::get('deleteAcervoP/{id}', ['as' => 'deleteAcervoP', 'uses' => 'Biblioteca\ArcevoPeriodicoController@delete']);

    Route::get('indexExemplar', ['as' => 'indexExemplar', 'uses' => 'Biblioteca\ExemplarController@index']);
    Route::get('createExemplar', ['as' => 'createExemplar', 'uses' => 'Biblioteca\ExemplarController@create']);
    Route::get('gridExemplar', ['as' => 'gridExemplar', 'uses' => 'Biblioteca\ExemplarController@grid']);
    Route::get('editExemplar/{id}', ['as' => 'editExemplar', 'uses' => 'Biblioteca\ExemplarController@edit']);
    Route::post('storeExemplar', ['as' => 'storeExemplar', 'uses' => 'Biblioteca\ExemplarController@store']);
    Route::post('updateExemplar/{id}', ['as' => 'updateExemplar', 'uses' => 'Biblioteca\ExemplarController@update']);
    Route::get('deleteExemplar/{id}', ['as' => 'deleteExemplar', 'uses' => 'Biblioteca\ExemplarController@delete']);

    Route::get('indexExemplarP', ['as' => 'indexExemplarP', 'uses' => 'Biblioteca\ExemplarPeriodicoController@index']);
    Route::get('createExemplarP', ['as' => 'createExemplarP', 'uses' => 'Biblioteca\ExemplarPeriodicoController@create']);
    Route::get('gridExemplarP', ['as' => 'gridExemplarP', 'uses' => 'Biblioteca\ExemplarPeriodicoController@grid']);
    Route::get('editExemplarP/{id}', ['as' => 'editExemplarP', 'uses' => 'Biblioteca\ExemplarPeriodicoController@edit']);
    Route::post('storeExemplarP', ['as' => 'storeExemplarP', 'uses' => 'Biblioteca\ExemplarPeriodicoController@store']);
    Route::post('updateExemplarP/{id}', ['as' => 'updateExemplarP', 'uses' => 'Biblioteca\ExemplarPeriodicoController@update']);
    Route::get('deleteExemplarP/{id}', ['as' => 'deleteExemplarP', 'uses' => 'Biblioteca\ExemplarPeriodicoController@delete']);


    ## acervos e exemplares monografia/dissertação/teses
    Route::get('indexAcervoMonoDiTe', ['as' => 'indexAcervoMonoDiTe', 'uses' => 'Biblioteca\ArcevoMonoDiTeController@index']);
    Route::get('createAcervoMonoDiTe', ['as' => 'createAcervoMonoDiTe', 'uses' => 'Biblioteca\ArcevoMonoDiTeController@create']);
    Route::get('gridAcervoMonoDiTe', ['as' => 'gridAcervoMonoDiTe', 'uses' => 'Biblioteca\ArcevoMonoDiTeController@grid']);
    Route::get('editAcervoMonoDiTe/{id}', ['as' => 'editAcervoMonoDiTe', 'uses' => 'Biblioteca\ArcevoMonoDiTeController@edit']);
    Route::post('storeAcervoMonoDiTe', ['as' => 'storeAcervoMonoDiTe', 'uses' => 'Biblioteca\ArcevoMonoDiTeController@store']);
    Route::post('updateAcervoMonoDiTe/{id}', ['as' => 'updateAcervoMonoDiTe', 'uses' => 'Biblioteca\ArcevoMonoDiTeController@update']);
    Route::get('deleteAcervoMonoDiTe/{id}', ['as' => 'deleteAcervoMonoDiTe', 'uses' => 'Biblioteca\ArcevoMonoDiTeController@delete']);

    Route::get('indexExemplarMonoDiTe', ['as' => 'indexExemplarMonoDiTe', 'uses' => 'Biblioteca\ExemplarMonoDiTeController@index']);
    Route::get('createExemplarMonoDiTe', ['as' => 'createExemplarMonoDiTe', 'uses' => 'Biblioteca\ExemplarMonoDiTeController@create']);
    Route::get('gridExemplarMonoDiTe', ['as' => 'gridExemplarMonoDiTe', 'uses' => 'Biblioteca\ExemplarMonoDiTeController@grid']);
    Route::get('editExemplarMonoDiTe/{id}', ['as' => 'editExemplarMonoDiTe', 'uses' => 'Biblioteca\ExemplarMonoDiTeController@edit']);
    Route::post('storeExemplarMonoDiTe', ['as' => 'storeExemplarMonoDiTe', 'uses' => 'Biblioteca\ExemplarMonoDiTeController@store']);
    Route::post('updateExemplarMonoDiTe/{id}', ['as' => 'updateExemplarMonoDiTe', 'uses' => 'Biblioteca\ExemplarMonoDiTeController@update']);
    Route::get('deleteExemplarMonoDiTe/{id}', ['as' => 'deleteExemplarMonoDiTe', 'uses' => 'Biblioteca\ExemplarMonoDiTeController@delete']);

    ## acervos e exemplares monografia/dissertação/teses fim rotas

    Route::get('indexParametro', ['as' => 'indexParametro', 'uses' => 'Biblioteca\BibParametroController@index']);
    Route::get('gridParametro', ['as' => 'gridParametro', 'uses' => 'Biblioteca\BibParametroController@grid']);
    Route::get('editParametro/{id}', ['as' => 'editParametro', 'uses' => 'Biblioteca\BibParametroController@edit']);
    Route::post('updateParametro/{id}', ['as' => 'updateParametro', 'uses' => 'Biblioteca\BibParametroController@update']);
    Route::get('diasLetivosBiblioteca', ['as' => 'diasLetivosBiblioteca', 'uses' => 'Biblioteca\BibParametroController@diasLetivosBiblioteca']);
    Route::post('storeDiasLetivosBiblioteca', ['as' => 'storeDiasLetivosBiblioteca', 'uses' => 'Biblioteca\BibParametroController@storeDiasLetivosBiblioteca']);

    Route::get('dashboardBliblioteca', ['as' => 'dashboardBliblioteca', 'uses' => 'DashboardController@dashboardBliblioteca']);

    //Rotas consulta biblioteca portal
    Route::get('indexConsulta', ['as' => 'indexConsulta', 'uses' => 'Biblioteca\ConsultaController@index']);
    Route::post('seachSimple', ['as' => 'seachSimple', 'uses' => 'Biblioteca\ConsultaController@seachSimple']);
    Route::get('seachSimplePage', ['as' => 'seachSimplePage', 'uses' => 'Biblioteca\ConsultaController@seachSimplePage']);
    Route::get('seachDetalhe/exemplar/{id}', ['as' => 'seachDetalhe', 'uses' => 'Biblioteca\ConsultaController@seachDetalhe']);
    Route::get('meusEmprestimos', ['as' => 'meusEmprestimos', 'uses' => 'Biblioteca\ConsultaController@meusEmprestimos']);

    Route::get('indexEmprestimo', ['as' => 'indexEmprestimo', 'uses' => 'Biblioteca\EmprestarController@index']);
    Route::get('gridEmprestimo', ['as' => 'gridEmprestimo', 'uses' => 'Biblioteca\EmprestarController@grid']);
    Route::post('storeEmprestimo', ['as' => 'storeEmprestimo', 'uses' => 'Biblioteca\EmprestarController@store']);
    Route::post('dataDevolucaoEmprestimo', ['as' => 'dataDevolucaoEmprestimo', 'uses' => 'Biblioteca\EmprestarController@dataDevolucao']);
    Route::get('viewDevolucaoEmprestimo', ['as' => 'viewDevolucaoEmprestimo', 'uses' => 'Biblioteca\EmprestarController@viewDevolucao']);
    Route::get('devolucaoEmprestimo', ['as' => 'devolucaoEmprestimo', 'uses' => 'Biblioteca\EmprestarController@gridDevolucao']);
    Route::get('devolucaoEmprestimoPorAluno', ['as' => 'devolucaoEmprestimoPorAluno', 'uses' => 'Biblioteca\EmprestarController@gridDevolucaoPorAluno']);
    Route::get('confirmarDevolucao/{id}', ['as' => 'confirmarDevolucao', 'uses' => 'Biblioteca\EmprestarController@confirmarDevolucao']);
    Route::get('confirmarDevolucaoPorAluno/{id}', ['as' => 'confirmarDevolucaoPorAluno', 'uses' => 'Biblioteca\EmprestarController@confirmarDevolucaoPorAluno']);
    Route::get('renovacao/{id}', ['as' => 'renovacao', 'uses' => 'Biblioteca\EmprestarController@renovacao']);
    Route::get('cartanotificacaoatraso/{id}', ['as' => 'cartanotificacaoatraso', 'uses' => 'Biblioteca\EmprestarController@cartaNotificacaoAtraso']);
    Route::post('findWhereEmprestimo', ['as' => 'findWhereEmprestimo', 'uses' => 'Biblioteca\EmprestarController@findWhereEmprestimo']);
    Route::post('confirmarEmprestimo', ['as' => 'confirmarEmprestimo', 'uses' => 'Biblioteca\EmprestarController@confirmarEmprestimo']);
    Route::get('deleteEmprestimo/{id}/{id2}', ['as' => 'deleteEmprestimo', 'uses' => 'Biblioteca\EmprestarController@deleteEmprestimo']);

    //Cupom de devoluçao
    Route::get('imprimirCupomDevolucao/{id}', ['as' => 'imprimirCupomDevolucao', 'uses' => 'Biblioteca\EmprestarController@imprimirCupomDevolucao']);

    //Cupom de Emprestimo
    Route::get('imprimirCupomEmprestimo/{id}', ['as' => 'imprimirCupomEmprestimo', 'uses' => 'Biblioteca\EmprestarController@imprimirCupomEmprestimo']);

    //baixa pagamento
    Route::get('baixaPagamento/{id}', ['as' => 'baixaPagamento', 'uses' => 'Biblioteca\EmprestarController@baixaPagamento']);
    Route::get('baixaPagamentoPorAluno/{id}', ['as' => 'baixaPagamentoPorAluno', 'uses' => 'Biblioteca\EmprestarController@baixaPagamentoPorAluno']);

    //Termo de biblioteca
    Route::post('validarTermoBiblioteca', ['as' => 'validarTermoBiblioteca', 'uses' => 'Biblioteca\EmprestarController@validarTermoBiblioteca']);
    Route::post('confirmarTermoBiblioteca', ['as' => 'confirmarTermoBiblioteca', 'uses' => 'Biblioteca\EmprestarController@confirmarTermoBiblioteca']);


    // Crud de reservas
    Route::get('indexReserva', ['as' => 'indexReserva', 'uses' => 'Biblioteca\ReservaController@index']);
    Route::get('gridReserva', ['as' => 'gridReserva', 'uses' => 'Biblioteca\ReservaController@grid']);
    Route::post('storeReserva', ['as' => 'storeReserva', 'uses' => 'Biblioteca\ReservaController@store']);
    Route::get('reservados', ['as' => 'reservados', 'uses' => 'Biblioteca\ReservaController@reservados']);
    Route::get('gridReservados', ['as' => 'gridReservados', 'uses' => 'Biblioteca\ReservaController@gridReservados']);
    Route::post('saveEmprestimo', ['as' => 'saveEmprestimo', 'uses' => 'Biblioteca\ReservaController@saveEmprestimo']);
    Route::post('findWhereReserva', ['as' => 'findWhereReserva', 'uses' => 'Biblioteca\ReservaController@findWhereReserva']);
    Route::get('deleteReserva/{id}/{id2}', ['as' => 'deleteReserva', 'uses' => 'Biblioteca\ReservaController@deleteReserva']);
    Route::post('confirmarReserva', ['as' => 'confirmarReserva', 'uses' => 'Biblioteca\ReservaController@confirmarReserva']);
    Route::post('listaPessoasReservas', ['as' => 'listaPessoasReservas', 'uses' => 'Biblioteca\ReservaController@listaPessoasReservas']);


    // Crud de coleção
    Route::get('indexColecao', ['as' => 'indexColecao', 'uses' => 'Biblioteca\ColecaoController@index']);
    Route::get('createColecao', ['as' => 'createColecao', 'uses' => 'Biblioteca\ColecaoController@create']);
    Route::get('gridColecao', ['as' => 'gridColecao', 'uses' => 'Biblioteca\ColecaoController@grid']);
    Route::get('editColecao/{id}', ['as' => 'editColecao', 'uses' => 'Biblioteca\ColecaoController@edit']);
    Route::post('storeColecao', ['as' => 'storeColecao', 'uses' => 'Biblioteca\ColecaoController@store']);
    Route::post('updateColecao/{id}', ['as' => 'updateColecao', 'uses' => 'Biblioteca\ColecaoController@update']);
    Route::get('deleteColecao/{id}', ['as' => 'deleteColecao', 'uses' => 'Biblioteca\ColecaoController@delete']);

    // Crud de série
    Route::get('indexSerie', ['as' => 'indexSerie', 'uses' => 'Biblioteca\SerieController@index']);
    Route::get('createSerie', ['as' => 'createSerie', 'uses' => 'Biblioteca\SerieController@create']);
    Route::get('gridSerie', ['as' => 'gridSerie', 'uses' => 'Biblioteca\SerieController@grid']);
    Route::get('editSerie/{id}', ['as' => 'editSerie', 'uses' => 'Biblioteca\SerieController@edit']);
    Route::post('storeSerie', ['as' => 'storeSerie', 'uses' => 'Biblioteca\SerieController@store']);
    Route::post('updateSerie/{id}', ['as' => 'updateSerie', 'uses' => 'Biblioteca\SerieController@update']);
    Route::get('deleteSerie/{id}', ['as' => 'deleteSerie', 'uses' => 'Biblioteca\SerieController@delete']);

    // Crud de gênero
    Route::get('indexGenero', ['as' => 'indexGenero', 'uses' => 'Biblioteca\GeneroController@index']);
    Route::get('createGenero', ['as' => 'createGenero', 'uses' => 'Biblioteca\GeneroController@create']);
    Route::get('gridGenero', ['as' => 'gridGenero', 'uses' => 'Biblioteca\GeneroController@grid']);
    Route::get('editGenero/{id}', ['as' => 'editGenero', 'uses' => 'Biblioteca\GeneroController@edit']);
    Route::post('storeGenero', ['as' => 'storeGenero', 'uses' => 'Biblioteca\GeneroController@store']);
    Route::post('updateGenero/{id}', ['as' => 'updateGenero', 'uses' => 'Biblioteca\GeneroController@update']);
    Route::get('deleteGenero/{id}', ['as' => 'deleteGenero', 'uses' => 'Biblioteca\GeneroController@delete']);

    // Gerar cutter
    Route::post('getCutter', ['as' => 'getCutter', 'uses' => 'Biblioteca\ArcevoController@getCutter']);

    // Gerar fixas
    Route::get('fixaFrente/{id}', ['as' => 'fixaFrente', 'uses' => 'Biblioteca\ExemplarController@fixaFrente']);
    Route::get('fixaVerso/{id}', ['as' => 'fixaVerso', 'uses' => 'Biblioteca\ExemplarController@fixaVerso']);

    // Relatórios
    Route::get('indexRelatorioLivrosPorCurso', ['as' => 'indexRelatorioLivrosPorCurso', 'uses' => 'Biblioteca\RelatorioController@indexRelatorioLivrosPorCurso']);
    Route::post('relatorioLivrosPorCurso', ['as' => 'relatorioLivrosPorCurso', 'uses' => 'Biblioteca\RelatorioController@relatorioLivrosPorCurso']);

    Route::get('indexRelatorioDeAtividades', ['as' => 'indexRelatorioDeAtividades', 'uses' => 'Biblioteca\RelatorioController@indexRelatorioDeAtividades']);
    Route::get('relatorioDeAtividades', ['as' => 'relatorioDeAtividades', 'uses' => 'Biblioteca\RelatorioController@relatorioDeAtividades']);

    Route::get('indexRelatorioDeEmprestimos', ['as' => 'indexRelatorioDeEmprestimos', 'uses' => 'Biblioteca\RelatorioController@indexRelatorioDeEmprestimos']);
    Route::get('relatorioDeEmprestimos', ['as' => 'relatorioDeEmprestimos', 'uses' => 'Biblioteca\RelatorioController@relatorioDeEmprestimos']);

    Route::get('indexRelatorioDeDevolucao', ['as' => 'indexRelatorioDeDevolucao', 'uses' => 'Biblioteca\RelatorioController@indexRelatorioDeDevolucao']);
    Route::get('relatorioDeDevolucao', ['as' => 'relatorioDeDevolucao', 'uses' => 'Biblioteca\RelatorioController@relatorioDeDevolucao']);

    Route::get('indexEditBiblioteca', ['as' => 'indexEditBiblioteca', 'uses' => 'Biblioteca\RelatorioController@indexEditBiblioteca']);
    Route::get('editBiblioteca', ['as' => 'editBiblioteca', 'uses' => 'Biblioteca\RelatorioController@editBiblioteca']);

});
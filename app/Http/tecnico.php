<?php

Route::group(['prefix' => 'tecnico', 'middleware' => 'auth', 'as' => 'tecnico.'], function () {

    Route::group(['prefix' => 'aluno', 'middleware' => 'auth', 'as' => 'aluno.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\AlunoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\AlunoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\AlunoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\AlunoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\AlunoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\AlunoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\AlunoController@delete']);

        #Rotas de Documentos
        Route::get('gerarDocumento/{tipoDoc}/{idAluno}', ['as' => 'gerarDocumento', 'uses' => 'Tecnico\AlunoDocumentoController@gerarDocumento']);
        Route::get('checkDocumento/{tipoDoc}/{idAluno}', ['as' => 'checkDocumento', 'uses' => 'Tecnico\AlunoDocumentoController@checkDocumento']);

        # Rotas de turmas de técnico
        Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
            Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'Tecnico\AlunoTurmaController@grid']);
            Route::get('gridSituacoes/{idAlunoCurso}', ['as' => 'gridSituacoes', 'uses' => 'Tecnico\AlunoTurmaController@gridSituacoes']);
            Route::get('getCursos', ['as' => 'getCursos', 'uses' => 'Tecnico\AlunoTurmaController@getCursos']);
            Route::get('getTurmas/{idCurriculo}', ['as' => 'getCursos', 'uses' => 'Tecnico\AlunoTurmaController@getTurmas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Tecnico\AlunoTurmaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\AlunoTurmaController@store']);
            Route::delete('destroy/{idAluno}/{idAlunoCurso}', ['as' => 'destroy', 'uses' => 'Tecnico\AlunoTurmaController@destroy']);
            Route::get('getTurmaOrigem/{idAlunoCurso}', ['as' => 'getTurmaOrigem', 'uses' => 'Tecnico\AlunoTurmaController@getTurmaOrigem']);
            Route::delete('destroySituacao/{idSituacao}', ['as' => 'destroySituacao', 'uses' => 'Tecnico\AlunoTurmaController@destroySituacao']);
            Route::post('storeSituacao', ['as' => 'storeSituacao', 'uses' => 'Tecnico\AlunoTurmaController@storeSituacao']);
//                    Route::get('edit/{idAlunoTurma}', ['as' => 'edit', 'uses' => 'PosGraduacao\AlunoTurmaController@edit']);
//                    Route::post('update/{idAlunoTurma}', ['as' => 'update', 'uses' => 'PosGraduacao\AlunoTurmaController@update']);
        });

        Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
            Route::get('gridACursar/{idAluno}', ['as' => 'gridACursar', 'uses' => 'Tecnico\AlunoCurriculoController@gridACursar']);
            Route::get('gridCursadas/{idAluno}', ['as' => 'gridCursadas', 'uses' => 'Tecnico\AlunoCurriculoController@gridCursadas']);
            Route::get('gridDispensadas/{idAluno}', ['as' => 'gridDispensadas', 'uses' => 'Tecnico\AlunoCurriculoController@gridDispensadas']);
            Route::get('gridDisciplinasExtraCurricular/{idAluno}', ['as' => 'gridDisciplinasExtraCurricular', 'uses' => 'Tecnico\AlunoCurriculoController@gridDisciplinasExtraCurricular']);
            Route::get('gridDisciplinasEquivalentes/{idAluno}', ['as' => 'gridDisciplinasEquivalentes', 'uses' => 'Tecnico\AlunoCurriculoController@gridDisciplinasEquivalentes']);
            Route::post('storeDispensada', ['as' => 'storeDispensada', 'uses' => 'Tecnico\AlunoCurriculoController@storeDispensada']);
            Route::get('deleteDispensada/{idDispensada}', ['as' => 'deleteDispensada', 'uses' => 'Tecnico\AlunoCurriculoController@deleteDispensada']);
            Route::get('editDispensada/{idDispensada}', ['as' => 'editDispensada', 'uses' => 'Tecnico\AlunoCurriculoController@editDispensada']);
            Route::post('updateDispensada/{idDispensada}', ['as' => 'updateDispensada', 'uses' => 'Tecnico\AlunoCurriculoController@updateDispensada']);
            Route::post('storeDisciplinaExtraCurricular', ['as' => 'storeDisciplinaExtraCurricular', 'uses' => 'Tecnico\AlunoCurriculoController@storeDisciplinaExtraCurricular']);
            Route::get('deleteDisciplinaExtraCurricular/{idDisciplina}', ['as' => 'deleteDisciplinaExtraCurricular', 'uses' => 'Tecnico\AlunoCurriculoController@deleteDisciplinaExtraCurricular']);
            Route::get('getDisciplinasByCurriculo/{idCurriculo}', ['as' => 'getDisciplinasByCurriculo', 'uses' => 'Tecnico\AlunoCurriculoController@getDisciplinasByCurriculo']);
            Route::post('storeEquivalencia', ['as' => 'storeEquivalencia', 'uses' => 'Tecnico\AlunoCurriculoController@storeEquivalencia']);
            Route::get('deleteEquivalencia/{id}', ['as' => 'deleteEquivalencia', 'uses' => 'Tecnico\AlunoCurriculoController@deleteEquivalencia']);
        });

        # Rotas para o financeiro do aluno
        Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Tecnico\AlunoFinanceiroController@getLoadFields']);
            Route::get('gridDebitos/{id}', ['as' => 'gridDebitos', 'uses' => 'Tecnico\AlunoFinanceiroController@gridDebitos']);
            Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'Tecnico\AlunoFinanceiroController@storeDebito']);
            Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'Tecnico\AlunoFinanceiroController@getDebito']);
            Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'Tecnico\AlunoFinanceiroController@editDebito']);
            Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'Tecnico\AlunoFinanceiroController@updateDebito']);
            Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'Tecnico\AlunoFinanceiroController@gerarBoleto']);
            Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'Tecnico\AlunoFinanceiroController@infoDebito']);
            Route::get('gridCarnes/{id}', ['as' => 'gridCarnes', 'uses' => 'Tecnico\AlunoFinanceiroController@gridCarnes']);
        });
    });

    Route::group(['prefix' => 'professor', 'middleware' => 'auth', 'as' => 'professor.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\ProfessorController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\ProfessorController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\ProfessorController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\ProfessorController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\ProfessorController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\ProfessorController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\ProfessorController@delete']);
    });

    Route::group(['prefix' => 'disciplina', 'middleware' => 'auth', 'as' => 'disciplina.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\DisciplinaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\DisciplinaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\DisciplinaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\DisciplinaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\DisciplinaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\DisciplinaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\DisciplinaController@delete']);
    });

    Route::group(['prefix' => 'curso', 'middleware' => 'auth', 'as' => 'curso.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\CursoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\CursoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\CursoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\CursoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\CursoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\CursoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\CursoController@delete']);
    });

    Route::group(['prefix' => 'curriculo', 'middleware' => 'auth', 'as' => 'curriculo.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\CurriculoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\CurriculoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\CurriculoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\CurriculoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\CurriculoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\CurriculoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\CurriculoController@delete']);

        Route::post('adicionarDisciplinas', ['as' => 'adicionarDisciplinas', 'uses' => 'Tecnico\CurriculoController@adicionarDisciplinas']);
        Route::post('removerDisciplina', ['as' => 'removerDisciplina', 'uses' => 'Tecnico\CurriculoController@removerDisciplina']);
        Route::get('getByCurso/{idCurso}', ['as' => 'getByCurso', 'uses' => 'Tecnico\CurriculoController@getByCurso']);
        Route::get('gridByCurriculo/{id}', ['as' => 'gridByCurriculo', 'uses' => 'Tecnico\CurriculoController@gridByCurriculo']);
        Route::get('get_modulo_by_curriculo/{idCurriculo}', ['as' => 'getByCurso', 'uses' => 'Tecnico\CurriculoController@getModuloByCurriculo']);
    });

    Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\TurmaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\TurmaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\TurmaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\TurmaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\TurmaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\TurmaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\TurmaController@delete']);
        Route::get('getAllByCurso/{idCurso}', ['as' => 'getAllByCurso', 'uses' => 'Tecnico\TurmaController@getAllByCurso']);
        Route::get('getSedeByCurso/{idCurso}', ['as' => 'getSedeByCurso', 'uses' => 'Tecnico\TurmaController@getSedeByCurso']);
        Route::get('getTurmaBySede/{idSede}/{idCurso}', ['as' => 'getTurmaBySede', 'uses' => 'Tecnico\TurmaController@getTurmaBySede']);
        Route::get('getCalendariosByDisciplina/{idTurma}/{idDisciplina}', ['as' => 'getCalendariosByDisciplina', 'uses' => 'Tecnico\TurmaController@getCalendariosByDisciplina']);

        Route::group(['prefix' => 'calendario', 'as' => 'calendario.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Tecnico\CalendarioTurmaController@grid']);
            Route::get('gridCalendario/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Tecnico\CalendarioTurmaController@gridCalendario']);
            Route::get('disciplinas/{idTurma}', ['as' => 'grid', 'uses' => 'Tecnico\CalendarioTurmaController@disciplinasOfCurriculo']);
            Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\CalendarioTurmaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\CalendarioTurmaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\CalendarioTurmaController@update']);
            Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\CalendarioTurmaController@delete']);
            Route::post('incluir', ['as' => 'incluir', 'uses' => 'Tecnico\CalendarioTurmaController@incluirDisciplina']);
            Route::post('remover-disciplina', ['as' => 'removerDisciplina', 'uses' => 'Tecnico\CalendarioTurmaController@removerDisciplina']);
        });

        Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Tecnico\TurmaNotaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Tecnico\TurmaNotaController@getLoadFields']);
            Route::get('edit/{idAlunoNota}', ['as' => 'edit', 'uses' => 'Tecnico\TurmaNotaController@editNota']);
            Route::post('update/{idAlunoNota}', ['as' => 'update', 'uses' => 'Tecnico\TurmaNotaController@updateNota']);
        });

        Route::group(['prefix' => 'frequencias', 'as' => 'frequencias.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Tecnico\TurmaFrequenciaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Tecnico\TurmaFrequenciaController@getLoadFields']);
            Route::put('changeFrequencia/{id}', ['as' => 'changeFrequencia', 'uses' => 'Tecnico\TurmaFrequenciaController@changeFrequencia']);
        });

        Route::group(['prefix' => 'alunos', 'as' => 'alunos.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Tecnico\TurmaAlunoController@grid']);
            Route::get('getAlunosByCurso/{idCurso}/{idTurma}/{idDisciplina}', ['as' => 'getAlunosByCurso', 'uses' => 'Tecnico\TurmaAlunoController@getAlunosByCurso']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Tecnico\TurmaAlunoController@getLoadFields']);
            Route::post('attachAluno', ['as' => 'edit', 'uses' => 'Tecnico\TurmaAlunoController@attachAluno']);
            Route::post('detachAluno', ['as' => 'update', 'uses' => 'Tecnico\TurmaAlunoController@detachAluno']);
        });

        # Rotaas de diários de aulas
        Route::group(['prefix' => 'diarioAula', 'as' => 'diarioAula.'], function () {
            Route::get('grid/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Tecnico\DiarioAulaController@grid']);
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Tecnico\DiarioAulaController@gridDisciplinas']);
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Tecnico\DiarioAulaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\DiarioAulaController@store']);
            Route::get('getConteudosProgramaticos', ['as' => 'getConteudosProgramaticos', 'uses' => 'Tecnico\DiarioAulaController@getConteudosProgramaticos']);
            Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\DiarioAulaController@delete']);
            Route::get('edit/{idDiarioAula}', ['as' => 'edit', 'uses' => 'Tecnico\DiarioAulaController@edit']);
            Route::post('update/{idDiarioAula}', ['as' => 'update', 'uses' => 'Tecnico\DiarioAulaController@update']);
            Route::get('gridConteudoProgramatico/{idDiarioAula}', ['as' => 'grid', 'uses' => 'Tecnico\DiarioAulaController@gridConteudoProgramatico']);
            Route::post('attachConteudo/{idDiarioAula}', ['as' => 'attachConteudo', 'uses' => 'Tecnico\DiarioAulaController@attachConteudo']);
            Route::post('detachConteudo/{idDiarioAula}', ['as' => 'detachConteudo', 'uses' => 'Tecnico\DiarioAulaController@detachConteudo']);
        });
    });

    Route::group(['prefix' => 'planoensino', 'middleware' => 'auth', 'as' => 'planoensino.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\PlanoEnsinoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\PlanoEnsinoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\PlanoEnsinoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\PlanoEnsinoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\PlanoEnsinoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\PlanoEnsinoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\PlanoEnsinoController@delete']);

        # Conteúdo programático
        Route::get('gridConteudoProgramatico/{idPlanoEnsino}', ['as' => 'gridConteudoProgramatico', 'uses' => 'Tecnico\PlanoEnsinoController@gridConteudoProgramatico']);
        Route::post('storeConteudoProgramatico', ['as' => 'storeConteudoProgramatico', 'uses' => 'Tecnico\PlanoEnsinoController@storeConteudoProgramatico']);
        Route::delete('deleteConteudoProgramatico/{id}', ['as' => 'deleteConteudoProgramatico', 'uses' => 'Tecnico\PlanoEnsinoController@deleteConteudoProgramatico']);
    });

    Route::group(['prefix' => 'modulo', 'middleware' => 'auth', 'as' => 'modulo.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\ModuloController@index']);
        Route::get('grid/{id}', ['as' => 'grid', 'uses' => 'Tecnico\ModuloController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\ModuloController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\ModuloController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\ModuloController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\ModuloController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\ModuloController@destroy']);

        Route::post('adicionarMateriais', ['as' => 'adicionarMateriais', 'uses' => 'Tecnico\ModuloController@adicionarMateriais']);
        Route::get('removerMateriais/{id}', ['as' => 'removerMateriais', 'uses' => 'Tecnico\ModuloController@removerMateriais']);
        Route::get('gridByModulo/{id}', ['as' => 'gridByModulo', 'uses' => 'Tecnico\ModuloController@gridByModulo']);
    });

    Route::group(['prefix' => 'agendamento', 'middleware' => 'auth', 'as' => 'agendamento.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@delete']);
        Route::post('getdisciplina', ['as' => 'getdisciplina', 'uses' => 'Tecnico\AgendamentoSegundaChamadaController@getDisciplinas']);
    });

    Route::group(['prefix' => 'agendamentoaluno', 'middleware' => 'auth', 'as' => 'agendamentoaluno.'], function () {
        Route::get('griddisciplina/{id}', ['as' => 'griddisciplina', 'uses' => 'Tecnico\AgendamentoAlunoController@gridDisciplina']);
        Route::get('gridaluno/{id}/{idagenda}', ['as' => 'gridaluno', 'uses' => 'Tecnico\AgendamentoAlunoController@gridAluno']);
        Route::post('getLoadFieldsAluno', ['as' => 'getLoadFieldsAluno', 'uses' => 'Tecnico\AgendamentoAlunoController@getLoadFieldsAluno']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\AgendamentoAlunoController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\AgendamentoAlunoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\AgendamentoAlunoController@delete']);
    });

    Route::group(['prefix' => 'inscricao', 'as' => 'inscricao.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Tecnico\InscricaoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\InscricaoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\InscricaoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\InscricaoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\InscricaoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\InscricaoController@update']);
        Route::get('delete/{id}', ['as' => 'edit', 'uses' => 'Tecnico\InscricaoController@delete']);
        Route::get('getByValidDate', ['as' => 'getValidDate', 'uses' => 'Tecnico\InscricaoController@getByValidDate']);

        /*Route::group(['prefix' => 'relatorios', 'as' => 'relatorios.'], function () {
            Route::get('relatorio1', ['as' => 'relatorio1', 'uses' => 'Graduacao\VestibularController@relatorio1']);
            Route::get('relatorio2', ['as' => 'relatorio2', 'uses' => 'Graduacao\VestibularController@relatorio2']);
            //Route::get('printQuantidadesGerais', ['as' => 'printQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@printQuantidadesGerais']);
            Route::get('viewReportQuantidadesGerais', ['as' => 'viewReportQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@viewReportQuantidadesGerais']);
            Route::get('getReportQuantidadesGerais/{id}', ['as' => 'getReportQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@getReportQuantidadesGerais']);
        });*/

        Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
            Route::get('grid/{idInscricao}', ['as' => 'grid', 'uses' => 'Tecnico\InscricaoCursoController@grid']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'Tecnico\InscricaoCursoController@delete']);
            Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\InscricaoCursoController@store']);

            Route::group(['prefix' => 'turno', 'as' => 'turno.'], function () {
                Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Tecnico\InscricaoCursoTurnoController@getLoadFields']);
                Route::get('grid/{idInscricaoCurso}', ['as' => 'grid', 'uses' => 'Tecnico\InscricaoCursoTurnoController@grid']);
                Route::post('delete', ['as' => 'delete', 'uses' => 'Tecnico\InscricaoCursoTurnoController@delete']);
                Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\InscricaoCursoTurnoController@store']);
                Route::post('getTurnosByCurso', ['as' => 'getTurnosByCurso', 'uses' => 'Tecnico\InscricaoCursoTurnoController@getTurnosByCurso']);
            });
        });
    });

    Route::group(['prefix' => 'relatorios', 'as' => 'relatorios.'], function(){
        Route::get('modulos_disciplinas', ['as' => 'modulos_disciplinas', 'uses' => 'Tecnico\RelatorioController@indexModulosDisciplinas']);
        Route::get('report_modulos_disciplinas', ['as' => 'report_modulos_disciplinas', 'uses' => 'Tecnico\RelatorioController@modulosDisciplinas']);
    });

});
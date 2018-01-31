<?php

Route::group(['prefix' => 'posgraduacao', 'as' => 'posgraduacao.'], function () {
    # Rotas do aluno de posgraduação
    Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'PosGraduacao\AlunoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'PosGraduacao\AlunoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'PosGraduacao\AlunoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\AlunoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\AlunoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'PosGraduacao\AlunoController@update']);
        Route::get('search', ['as' => 'search', 'uses' => 'PosGraduacao\AlunoController@search']);
        Route::get('reportViewGeralAlunoCandidato', ['as' => 'reportViewGeralAlunoCandidato', 'uses' => 'Report\ReportAlunoController@reportViewGeralAlunoCandidato']);
        Route::get('gridReportGeralAlunoCandidato/{tipo}', ['as' => 'gridReportGeralAlunoCandidato', 'uses' => 'Report\ReportAlunoController@gridReportGeralAlunoCandidato']);
        Route::get('graphicBuilderGeral', ['as' => 'graphicBuilderGeral', 'uses' => 'Report\ReportAlunoController@graphicBuilderGeral']);
        Route::get('reportViewPretensao', ['as' => 'reportViewPretensao', 'uses' => 'Report\ReportPretensaoController@reportViewPretensao']);
        Route::get('gridReportPretensao/{tipo}', ['as' => 'gridReportPretensao', 'uses' => 'Report\ReportPretensaoController@gridReportPretensao']);
        Route::get('graphicBuilderGeralPretensao', ['as' => 'graphicBuilderGeralPretensao', 'uses' => 'Report\ReportPretensaoController@graphicBuilderGeral']);
        Route::get('editPretensao/{id}', ['as' => 'editPretensao', 'uses' => 'Report\ReportPretensaoController@editPretensao']);
        Route::post('updatePretensao/{id}', ['as' => 'updatePretensao', 'uses' => 'Report\ReportPretensaoController@updatePretensao']);
        Route::get('getImgAluno/{id}', ['as' => 'getImgAluno', 'uses' => 'PosGraduacao\AlunoController@getImgAluno']);

        #Rotas de Documentos
        Route::get('gerarDocumento/{tipoDoc}/{idAluno}', ['as' => 'gerarDocumento', 'uses' => 'PosGraduacao\AlunoDocumentoController@gerarDocumento']);
        Route::get('checkDocumento/{tipoDoc}/{idAluno}', ['as' => 'checkDocumento', 'uses' => 'PosGraduacao\AlunoDocumentoController@checkDocumento']);

        # Rotas de turmas de pósgraduação
        Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
            Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'PosGraduacao\AlunoTurmaController@grid']);
            Route::get('gridSituacoes/{idAlunoCurso}', ['as' => 'gridSituacoes', 'uses' => 'PosGraduacao\AlunoTurmaController@gridSituacoes']);
            Route::get('getCursos', ['as' => 'getCursos', 'uses' => 'PosGraduacao\AlunoTurmaController@getCursos']);
            Route::get('getTurmas/{idCurriculo}', ['as' => 'getCursos', 'uses' => 'PosGraduacao\AlunoTurmaController@getTurmas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\AlunoTurmaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\AlunoTurmaController@store']);
            Route::delete('destroy/{idAluno}/{idAlunoCurso}', ['as' => 'destroy', 'uses' => 'PosGraduacao\AlunoTurmaController@destroy']);
            Route::get('getTurmaOrigem/{idAlunoCurso}', ['as' => 'getTurmaOrigem', 'uses' => 'PosGraduacao\AlunoTurmaController@getTurmaOrigem']);
            Route::delete('destroySituacao/{idSituacao}', ['as' => 'destroySituacao', 'uses' => 'PosGraduacao\AlunoTurmaController@destroySituacao']);
            Route::post('storeSituacao', ['as' => 'storeSituacao', 'uses' => 'PosGraduacao\AlunoTurmaController@storeSituacao']);
//                    Route::get('edit/{idAlunoTurma}', ['as' => 'edit', 'uses' => 'PosGraduacao\AlunoTurmaController@edit']);
//                    Route::post('update/{idAlunoTurma}', ['as' => 'update', 'uses' => 'PosGraduacao\AlunoTurmaController@update']);
        });

        Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
            Route::get('gridACursar/{idAluno}', ['as' => 'gridACursar', 'uses' => 'PosGraduacao\AlunoCurriculoController@gridACursar']);
            Route::get('gridCursadas/{idAluno}', ['as' => 'gridCursadas', 'uses' => 'PosGraduacao\AlunoCurriculoController@gridCursadas']);
            Route::get('gridDispensadas/{idAluno}', ['as' => 'gridDispensadas', 'uses' => 'PosGraduacao\AlunoCurriculoController@gridDispensadas']);
            Route::get('gridDisciplinasExtraCurricular/{idAluno}', ['as' => 'gridDisciplinasExtraCurricular', 'uses' => 'PosGraduacao\AlunoCurriculoController@gridDisciplinasExtraCurricular']);
            Route::get('gridDisciplinasEquivalentes/{idAluno}', ['as' => 'gridDisciplinasEquivalentes', 'uses' => 'PosGraduacao\AlunoCurriculoController@gridDisciplinasEquivalentes']);
            Route::post('storeDispensada', ['as' => 'storeDispensada', 'uses' => 'PosGraduacao\AlunoCurriculoController@storeDispensada']);
            Route::get('deleteDispensada/{idDispensada}', ['as' => 'deleteDispensada', 'uses' => 'PosGraduacao\AlunoCurriculoController@deleteDispensada']);
            Route::get('editDispensada/{idDispensada}', ['as' => 'editDispensada', 'uses' => 'PosGraduacao\AlunoCurriculoController@editDispensada']);
            Route::post('updateDispensada/{idDispensada}', ['as' => 'updateDispensada', 'uses' => 'PosGraduacao\AlunoCurriculoController@updateDispensada']);
            Route::post('storeDisciplinaExtraCurricular', ['as' => 'storeDisciplinaExtraCurricular', 'uses' => 'PosGraduacao\AlunoCurriculoController@storeDisciplinaExtraCurricular']);
            Route::get('deleteDisciplinaExtraCurricular/{idDisciplina}', ['as' => 'deleteDisciplinaExtraCurricular', 'uses' => 'PosGraduacao\AlunoCurriculoController@deleteDisciplinaExtraCurricular']);
            Route::get('getDisciplinasByCurriculo/{idCurriculo}', ['as' => 'getDisciplinasByCurriculo', 'uses' => 'PosGraduacao\AlunoCurriculoController@getDisciplinasByCurriculo']);
            Route::get('getDisciplinasByCurriculoWithNota/{idAluno}/{idCurriculo}', ['as' => 'getDisciplinasByCurriculoWithNota', 'uses' => 'PosGraduacao\AlunoCurriculoController@getDisciplinasByCurriculoWithNota']);
            Route::get('getNota', ['as' => 'getNota', 'uses' => 'PosGraduacao\AlunoCurriculoController@getNota']);
            Route::post('storeEquivalencia', ['as' => 'storeEquivalencia', 'uses' => 'PosGraduacao\AlunoCurriculoController@storeEquivalencia']);
            Route::get('deleteEquivalencia/{id}', ['as' => 'deleteEquivalencia', 'uses' => 'PosGraduacao\AlunoCurriculoController@deleteEquivalencia']);
        });

        # Rotas para o financeiro do aluno de pós
        Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\AlunoFinanceiroController@getLoadFields']);
            Route::get('gridDebitos/{id}', ['as' => 'gridDebitos', 'uses' => 'PosGraduacao\AlunoFinanceiroController@gridDebitos']);
            Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'PosGraduacao\AlunoFinanceiroController@storeDebito']);
            Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'PosGraduacao\AlunoFinanceiroController@getDebito']);
            Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'PosGraduacao\AlunoFinanceiroController@editDebito']);
            Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'PosGraduacao\AlunoFinanceiroController@updateDebito']);
            Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'PosGraduacao\AlunoFinanceiroController@gerarBoleto']);
            Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'PosGraduacao\AlunoFinanceiroController@infoDebito']);
            Route::get('gridCarnes/{id}', ['as' => 'gridCarnes', 'uses' => 'PosGraduacao\AlunoFinanceiroController@gridCarnes']);
        });
    });

    Route::group(['prefix' => 'professor', 'as' => 'professor.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'ProfessorController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'ProfessorController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'ProfessorController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'ProfessorController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProfessorController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ProfessorController@update']);
        Route::get('contrato/{id}', ['as' => 'contrato', 'uses' => 'ProfessorController@contrato']);
        Route::get('getImg/{id}', ['as' => 'getImg', 'uses' => 'ProfessorController@getImg']);

        //Declaração de vinculo
        Route::post('getProfessor', ['as' => 'getProfessor', 'uses' => 'PosGraduacao\ProfessorPosController@getProfessor']);
        Route::post('getDisciplina/{idProfessor}', ['as' => 'getDisciplina', 'uses' => 'PosGraduacao\ProfessorPosController@getDisciplina']);
    });

    Route::group(['prefix' => 'professorpos', 'as' => 'professorpos.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'PosGraduacao\ProfessorPosController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'PosGraduacao\ProfessorPosController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'PosGraduacao\ProfessorPosController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\ProfessorPosController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\ProfessorPosController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'PosGraduacao\ProfessorPosController@update']);
        Route::get('contrato/{id}', ['as' => 'contrato', 'uses' => 'PosGraduacao\ProfessorPosController@contrato']);
        Route::get('getImg/{id}', ['as' => 'getImg', 'uses' => 'PosGraduacao\ProfessorPosController@getImg']);
        Route::get('visualizarAnexo/{id}/{tipo}', ['as' => 'visualizarAnexo', 'uses' => 'PosGraduacao\ProfessorPosController@visualizarAnexo']);
        Route::post('instituicao', ['as' => 'instituicao', 'uses' => 'PosGraduacao\ProfessorPosController@createInstituicao']);
    });

    Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'PosGraduacao\DisciplinaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'PosGraduacao\DisciplinaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'PosGraduacao\DisciplinaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\DisciplinaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\DisciplinaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'PosGraduacao\DisciplinaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'PosGraduacao\DisciplinaController@delete']);
    });

    Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'PosGraduacao\CursoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'PosGraduacao\CursoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'PosGraduacao\CursoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\CursoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\CursoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'PosGraduacao\CursoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'PosGraduacao\CursoController@delete']);
    });

    Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
        Route::post('getLoadFields', ['as' => 'grid', 'uses' => 'PosGraduacao\CurriculoController@getLoadFields']);
        Route::get('index', ['as' => 'index', 'uses' => 'PosGraduacao\CurriculoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'PosGraduacao\CurriculoController@grid']);
        Route::get('gridByCurriculo/{id}', ['as' => 'gridByCurriculo', 'uses' => 'PosGraduacao\CurriculoController@gridByCurriculo']);
        Route::get('create', ['as' => 'create', 'uses' => 'PosGraduacao\CurriculoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\CurriculoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\CurriculoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'PosGraduacao\CurriculoController@update']);
//                Route::post('adicionarDisciplinas', ['as' => 'adicionarDisciplinas', 'uses' => 'PosGraduacao\CurriculoController@adicionarDisciplinas']);
//                Route::post('removerDisciplina', ['as' => 'removerDisciplina', 'uses' => 'PosGraduacao\CurriculoController@removerDisciplina']);
//                Route::get('getByCurso/{idCurso}', ['as' => 'getByCurso', 'uses' => 'PosGraduacao\CurriculoController@getByCurso']);

        # Disciplinas
        Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
            Route::get('get/{idDisciplina}', ['as' => 'edit', 'uses' => 'PosGraduacao\CurriculoController@getDisciplina']);
            Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\CurriculoController@disciplinaStore']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'PosGraduacao\CurriculoController@disciplinaDelete']);
            Route::get('edit/{idDisciplina}/{idCurriculo}', ['as' => 'edit', 'uses' => 'PosGraduacao\CurriculoController@disciplinaEdit']);
            Route::post('update/{idDisciplina}/{idCurriculo}', ['as' => 'update', 'uses' => 'PosGraduacao\CurriculoController@disciplinaUpdate']);
        });

    });

    Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'PosGraduacao\TurmaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'PosGraduacao\TurmaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'PosGraduacao\TurmaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\TurmaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\TurmaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'PosGraduacao\TurmaController@update']);
        Route::get('getAllByCurso/{idCurso}', ['as' => 'getAllByCurso', 'uses' => 'PosGraduacao\TurmaController@getAllByCurso']);
        Route::get('getSedeByCurso/{idCurso}', ['as' => 'getSedeByCurso', 'uses' => 'PosGraduacao\TurmaController@getSedeByCurso']);
        Route::get('getTurmaBySede/{idSede}/{idCurso}', ['as' => 'getTurmaBySede', 'uses' => 'PosGraduacao\TurmaController@getTurmaBySede']);
        Route::get('getCalendariosByDisciplina/{idTurma}/{idDisciplina}', ['as' => 'getCalendariosByDisciplina', 'uses' => 'PosGraduacao\TurmaController@getCalendariosByDisciplina']);

        Route::group(['prefix' => 'calendario', 'as' => 'calendario.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'PosGraduacao\CalendarioTurmaController@grid']);
            Route::get('gridCalendario/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'PosGraduacao\CalendarioTurmaController@gridCalendario']);
            Route::get('disciplinas/{idTurma}', ['as' => 'grid', 'uses' => 'PosGraduacao\CalendarioTurmaController@disciplinasOfCurriculo']);
            Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\CalendarioTurmaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\CalendarioTurmaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'PosGraduacao\CalendarioTurmaController@update']);
            Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'PosGraduacao\CalendarioTurmaController@delete']);
            Route::post('incluir', ['as' => 'incluir', 'uses' => 'PosGraduacao\CalendarioTurmaController@incluirDisciplina']);
            Route::post('remover-disciplina', ['as' => 'removerDisciplina', 'uses' => 'PosGraduacao\CalendarioTurmaController@removerDisciplina']);
        });

        Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'PosGraduacao\TurmaNotaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\TurmaNotaController@getLoadFields']);
            Route::get('edit/{idAlunoNota}', ['as' => 'edit', 'uses' => 'PosGraduacao\TurmaNotaController@editNota']);
            Route::post('update/{idAlunoNota}', ['as' => 'update', 'uses' => 'PosGraduacao\TurmaNotaController@updateNota']);
            Route::get('delete/{idAlunoNota}', ['as' => 'delete', 'uses' => 'PosGraduacao\TurmaNotaController@deleteNota']);

        });

        Route::group(['prefix' => 'frequencias', 'as' => 'frequencias.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'PosGraduacao\TurmaFrequenciaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\TurmaFrequenciaController@getLoadFields']);
            Route::put('changeFrequencia/{id}', ['as' => 'changeFrequencia', 'uses' => 'PosGraduacao\TurmaFrequenciaController@changeFrequencia']);
        });

        Route::group(['prefix' => 'alunos', 'as' => 'alunos.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'PosGraduacao\TurmaAlunoController@grid']);
            Route::get('getAlunosByCurso/{idCurso}/{idTurma}/{idDisciplina}', ['as' => 'getAlunosByCurso', 'uses' => 'PosGraduacao\TurmaAlunoController@getAlunosByCurso']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\TurmaAlunoController@getLoadFields']);
            Route::post('attachAluno', ['as' => 'edit', 'uses' => 'PosGraduacao\TurmaAlunoController@attachAluno']);
            Route::post('detachAluno', ['as' => 'update', 'uses' => 'PosGraduacao\TurmaAlunoController@detachAluno']);
        });

        # Rotaas de diários de aulas
        Route::group(['prefix' => 'diarioAula', 'as' => 'diarioAula.'], function () {
            Route::get('grid/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'PosGraduacao\DiarioAulaController@grid']);
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'PosGraduacao\DiarioAulaController@gridDisciplinas']);
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\DiarioAulaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\DiarioAulaController@store']);
            Route::get('getConteudosProgramaticos', ['as' => 'getConteudosProgramaticos', 'uses' => 'PosGraduacao\DiarioAulaController@getConteudosProgramaticos']);
            Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'PosGraduacao\DiarioAulaController@delete']);
            Route::get('edit/{idDiarioAula}', ['as' => 'edit', 'uses' => 'PosGraduacao\DiarioAulaController@edit']);
            Route::post('update/{idDiarioAula}', ['as' => 'update', 'uses' => 'PosGraduacao\DiarioAulaController@update']);
            Route::get('gridConteudoProgramatico/{idDiarioAula}', ['as' => 'grid', 'uses' => 'PosGraduacao\DiarioAulaController@gridConteudoProgramatico']);
            Route::post('attachConteudo/{idDiarioAula}', ['as' => 'attachConteudo', 'uses' => 'PosGraduacao\DiarioAulaController@attachConteudo']);
            Route::post('detachConteudo/{idDiarioAula}', ['as' => 'detachConteudo', 'uses' => 'PosGraduacao\DiarioAulaController@detachConteudo']);
        });

        # Rotaas de planos de ensino
        Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'PosGraduacao\TurmaPlanoEnsinoController@gridDisciplinas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\TurmaPlanoEnsinoController@getLoadFields']);
            Route::post('attachPlanoEnsino', ['as' => 'attachPlanoEnsino', 'uses' => 'PosGraduacao\TurmaPlanoEnsinoController@attachPlanoEnsino']);

        });
    });

    # Plano de Ensino
    Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
        Route::get('grid', ['as' => 'grid', 'uses' => 'PosGraduacao\PlanoEnsinoController@grid']);
        Route::get('index', ['as' => 'index', 'uses' => 'PosGraduacao\PlanoEnsinoController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'PosGraduacao\PlanoEnsinoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\PlanoEnsinoController@store']);
        Route::get('edit/{idplanoEnsino}', ['as' => 'edit', 'uses' => 'PosGraduacao\PlanoEnsinoController@edit']);
        Route::post('update/{idplanoEnsino}', ['as' => 'update', 'uses' => 'PosGraduacao\PlanoEnsinoController@update']);
        Route::delete('deleteAnexo/{idplanoEnsino}', ['as' => 'deleteAnexo', 'uses' => 'PosGraduacao\PlanoEnsinoController@deleteAnexo']);

        # Conteúdo programático
        Route::get('gridConteudoProgramatico/{idPlanoEnsino}', ['as' => 'gridConteudoProgramatico', 'uses' => 'PosGraduacao\PlanoEnsinoController@gridConteudoProgramatico']);
        Route::post('storeConteudoProgramatico', ['as' => 'storeConteudoProgramatico', 'uses' => 'PosGraduacao\PlanoEnsinoController@storeConteudoProgramatico']);
        Route::delete('deleteConteudoProgramatico/{id}', ['as' => 'deleteConteudoProgramatico', 'uses' => 'PosGraduacao\PlanoEnsinoController@deleteConteudoProgramatico']);

        # Planos de aula
        Route::group(['prefix' => 'planoAula', 'as' => 'planoAula.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'PosGraduacao\PlanoAulaController@getLoadFields']);
            Route::get('grid/{idPlanoEnsino}', ['as' => 'grid', 'uses' => 'PosGraduacao\PlanoAulaController@grid']);
            Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\PlanoAulaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PosGraduacao\PlanoAulaController@edit']);
            Route::post('update/{id}', ['update' => 'edit', 'uses' => 'PosGraduacao\PlanoAulaController@update']);
            Route::delete('delete/{id}', ['delete' => 'edit', 'uses' => 'PosGraduacao\PlanoAulaController@delete']);
            Route::get('getConteudosIn', ['as' => 'getConteudosIn', 'uses' => 'PosGraduacao\PlanoAulaController@getConteudosIn']);
            Route::get('gridConteudos/{idPlanoAula}', ['as' => 'gridConteudos', 'uses' => 'PosGraduacao\PlanoAulaController@gridConteudos']);
            Route::post('attachConteudo/{idPlanoAula}', ['as' => 'attachConteudo', 'uses' => 'PosGraduacao\PlanoAulaController@attachConteudo']);
            Route::post('detachConteudo/{idPlanoAula}', ['as' => 'detachConteudo', 'uses' => 'PosGraduacao\PlanoAulaController@detachConteudo']);

        });
    });
    Route::group(['prefix' => 'selectProfissao', 'as' => 'selectProfissao.'], function () {
        Route::post('store', ['as' => 'store', 'uses' => 'PosGraduacao\AlunoController@storeProfissao']);
        Route::get('find', ['as' => 'find', 'uses' => 'PosGraduacao\AlunoController@findProfissao']);
    });
});
<?php

Route::group(['prefix' => 'mestrado', 'as' => 'mestrado.'], function () {

    # Rotas do aluno de mestrado
    Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Mestrado\AlunoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Mestrado\AlunoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Mestrado\AlunoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\AlunoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\AlunoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Mestrado\AlunoController@update']);
        Route::get('search', ['as' => 'search', 'uses' => 'Mestrado\AlunoController@search']);
        Route::get('getImgAluno/{id}', ['as' => 'getImgAluno', 'uses' => 'Mestrado\AlunoController@getImgAluno']);

        #Rotas de Documentos
        Route::get('gerarDocumento/{tipoDoc}/{idAluno}', ['as' => 'gerarDocumento', 'uses' => 'Mestrado\AlunoDocumentoController@gerarDocumento']);
        Route::get('checkDocumento/{tipoDoc}/{idAluno}', ['as' => 'checkDocumento', 'uses' => 'Mestrado\AlunoDocumentoController@checkDocumento']);

        # Rotas de turmas de pósgraduação
        Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
            Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'Mestrado\AlunoTurmaController@grid']);
            Route::get('gridSituacoes/{idAlunoCurso}', ['as' => 'gridSituacoes', 'uses' => 'Mestrado\AlunoTurmaController@gridSituacoes']);
            Route::get('getCursos', ['as' => 'getCursos', 'uses' => 'Mestrado\AlunoTurmaController@getCursos']);
            Route::get('getTurmas/{idCurriculo}', ['as' => 'getCursos', 'uses' => 'Mestrado\AlunoTurmaController@getTurmas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\AlunoTurmaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\AlunoTurmaController@store']);
            Route::delete('destroy/{idAluno}/{idAlunoCurso}', ['as' => 'destroy', 'uses' => 'Mestrado\AlunoTurmaController@destroy']);
            Route::get('getTurmaOrigem/{idAlunoCurso}', ['as' => 'getTurmaOrigem', 'uses' => 'Mestrado\AlunoTurmaController@getTurmaOrigem']);
            Route::delete('destroySituacao/{idSituacao}', ['as' => 'destroySituacao', 'uses' => 'Mestrado\AlunoTurmaController@destroySituacao']);
            Route::post('storeSituacao', ['as' => 'storeSituacao', 'uses' => 'Mestrado\AlunoTurmaController@storeSituacao']);
//                    Route::get('edit/{idAlunoTurma}', ['as' => 'edit', 'uses' => 'PosGraduacao\AlunoTurmaController@edit']);
//                    Route::post('update/{idAlunoTurma}', ['as' => 'update', 'uses' => 'PosGraduacao\AlunoTurmaController@update']);
        });

        Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
            Route::get('gridACursar/{idAluno}', ['as' => 'gridACursar', 'uses' => 'Mestrado\AlunoCurriculoController@gridACursar']);
            Route::get('gridCursadas/{idAluno}', ['as' => 'gridCursadas', 'uses' => 'Mestrado\AlunoCurriculoController@gridCursadas']);
            Route::get('gridDispensadas/{idAluno}', ['as' => 'gridDispensadas', 'uses' => 'Mestrado\AlunoCurriculoController@gridDispensadas']);
            Route::get('gridDisciplinasExtraCurricular/{idAluno}', ['as' => 'gridDisciplinasExtraCurricular', 'uses' => 'Mestrado\AlunoCurriculoController@gridDisciplinasExtraCurricular']);
            Route::get('gridDisciplinasEquivalentes/{idAluno}', ['as' => 'gridDisciplinasEquivalentes', 'uses' => 'Mestrado\AlunoCurriculoController@gridDisciplinasEquivalentes']);
            Route::post('storeDispensada', ['as' => 'storeDispensada', 'uses' => 'Mestrado\AlunoCurriculoController@storeDispensada']);
            Route::get('deleteDispensada/{idDispensada}', ['as' => 'deleteDispensada', 'uses' => 'Mestrado\AlunoCurriculoController@deleteDispensada']);
            Route::get('editDispensada/{idDispensada}', ['as' => 'editDispensada', 'uses' => 'Mestrado\AlunoCurriculoController@editDispensada']);
            Route::post('updateDispensada/{idDispensada}', ['as' => 'updateDispensada', 'uses' => 'Mestrado\AlunoCurriculoController@updateDispensada']);
            Route::post('storeDisciplinaExtraCurricular', ['as' => 'storeDisciplinaExtraCurricular', 'uses' => 'Mestrado\AlunoCurriculoController@storeDisciplinaExtraCurricular']);
            Route::get('deleteDisciplinaExtraCurricular/{idDisciplina}', ['as' => 'deleteDisciplinaExtraCurricular', 'uses' => 'Mestrado\AlunoCurriculoController@deleteDisciplinaExtraCurricular']);
            Route::get('getDisciplinasByCurriculo/{idCurriculo}', ['as' => 'getDisciplinasByCurriculo', 'uses' => 'Mestrado\AlunoCurriculoController@getDisciplinasByCurriculo']);
            Route::post('storeEquivalencia', ['as' => 'storeEquivalencia', 'uses' => 'Mestrado\AlunoCurriculoController@storeEquivalencia']);
            Route::get('deleteEquivalencia/{id}', ['as' => 'deleteEquivalencia', 'uses' => 'Mestrado\AlunoCurriculoController@deleteEquivalencia']);
        });

        # Rotas para o financeiro do aluno de pós
        Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\AlunoFinanceiroController@getLoadFields']);
            Route::get('gridDebitos/{id}', ['as' => 'gridDebitos', 'uses' => 'Mestrado\AlunoFinanceiroController@gridDebitos']);
            Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'Mestrado\AlunoFinanceiroController@storeDebito']);
            Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'Mestrado\AlunoFinanceiroController@getDebito']);
            Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'Mestrado\AlunoFinanceiroController@editDebito']);
            Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'Mestrado\AlunoFinanceiroController@updateDebito']);
            Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'Mestrado\AlunoFinanceiroController@gerarBoleto']);
            Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'Mestrado\AlunoFinanceiroController@infoDebito']);
            Route::get('gridCarnes/{id}', ['as' => 'gridCarnes', 'uses' => 'Mestrado\AlunoFinanceiroController@gridCarnes']);
        });
    });

    #Rotas de professores
    Route::group(['prefix' => 'professor', 'as' => 'professor.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Mestrado\ProfessorController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Mestrado\ProfessorController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Mestrado\ProfessorController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\ProfessorController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\ProfessorController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Mestrado\ProfessorController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\ProfessorController@delete']);

        #Rotas de Documentos
        Route::get('gerarDocumento/{tipoDoc}/{idProfessor}', ['as' => 'gerarDocumento', 'uses' => 'Mestrado\ProfessorDocumentoController@gerarDocumento']);
        Route::get('checkDocumento/{tipoDoc}/{idProfessor}', ['as' => 'checkDocumento', 'uses' => 'Mestrado\ProfessorDocumentoController@checkDocumento']);
        Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\ProfessorController@getLoadFields']);
        Route::post('getProfessor', ['as' => 'getProfessor', 'uses' => 'Mestrado\ProfessorController@getProfessor']);
        Route::post('getDisciplina/{idProfessor}', ['as' => 'getDisciplina', 'uses' => 'Mestrado\ProfessorController@getDisciplina']);
    });

    # Rotas de disciplinas
    Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Mestrado\DisciplinaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Mestrado\DisciplinaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Mestrado\DisciplinaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\DisciplinaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\DisciplinaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Mestrado\DisciplinaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\DisciplinaController@delete']);
    });

    # Rotas de cursos
    Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Mestrado\CursoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Mestrado\CursoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Mestrado\CursoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\CursoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\CursoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Mestrado\CursoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\CursoController@delete']);
    });

    # Rotas de curriculo
    Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Mestrado\CurriculoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Mestrado\CurriculoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Mestrado\CurriculoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\CurriculoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\CurriculoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Mestrado\CurriculoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\CurriculoController@delete']);

        Route::post('adicionarDisciplinas', ['as' => 'adicionarDisciplinas', 'uses' => 'Mestrado\CurriculoController@adicionarDisciplinas']);
        Route::post('removerDisciplina', ['as' => 'removerDisciplina', 'uses' => 'Mestrado\CurriculoController@removerDisciplina']);
        Route::get('getByCurso/{idCurso}', ['as' => 'getByCurso', 'uses' => 'Mestrado\CurriculoController@getByCurso']);
        Route::get('gridByCurriculo/{id}', ['as' => 'gridByCurriculo', 'uses' => 'Mestrado\CurriculoController@gridByCurriculo']);
    });

    # Rotas de turma
    Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Mestrado\TurmaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Mestrado\TurmaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Mestrado\TurmaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\TurmaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\TurmaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Mestrado\TurmaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\TurmaController@delete']);
        Route::get('getAllByCurso/{idCurso}', ['as' => 'getAllByCurso', 'uses' => 'Mestrado\TurmaController@getAllByCurso']);
        Route::get('getSedeByCurso/{idCurso}', ['as' => 'getSedeByCurso', 'uses' => 'Mestrado\TurmaController@getSedeByCurso']);
        Route::get('getTurmaBySede/{idSede}/{idCurso}', ['as' => 'getTurmaBySede', 'uses' => 'Mestrado\TurmaController@getTurmaBySede']);
        Route::get('getCalendariosByDisciplina/{idTurma}/{idDisciplina}', ['as' => 'getCalendariosByDisciplina', 'uses' => 'Mestrado\TurmaController@getCalendariosByDisciplina']);

        Route::group(['prefix' => 'calendario', 'as' => 'calendario.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Mestrado\CalendarioTurmaController@grid']);
            Route::get('gridCalendario/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Mestrado\CalendarioTurmaController@gridCalendario']);
            Route::get('disciplinas/{idTurma}', ['as' => 'grid', 'uses' => 'Mestrado\CalendarioTurmaController@disciplinasOfCurriculo']);
            Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\CalendarioTurmaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\CalendarioTurmaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Mestrado\CalendarioTurmaController@update']);
            Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\CalendarioTurmaController@delete']);
            Route::post('incluir', ['as' => 'incluir', 'uses' => 'Mestrado\CalendarioTurmaController@incluirDisciplina']);
            Route::post('remover-disciplina', ['as' => 'removerDisciplina', 'uses' => 'Mestrado\CalendarioTurmaController@removerDisciplina']);
        });

        Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Mestrado\TurmaNotaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\TurmaNotaController@getLoadFields']);
            Route::get('edit/{idAlunoNota}', ['as' => 'edit', 'uses' => 'Mestrado\TurmaNotaController@editNota']);
            Route::post('update/{idAlunoNota}', ['as' => 'update', 'uses' => 'Mestrado\TurmaNotaController@updateNota']);
            Route::get('delete/{idAlunoNota}', ['as' => 'delete', 'uses' => 'Mestrado\TurmaNotaController@deleteNota']);
        });

        Route::group(['prefix' => 'frequencias', 'as' => 'frequencias.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Mestrado\TurmaFrequenciaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\TurmaFrequenciaController@getLoadFields']);
            Route::put('changeFrequencia/{id}', ['as' => 'changeFrequencia', 'uses' => 'Mestrado\TurmaFrequenciaController@changeFrequencia']);
        });

        Route::group(['prefix' => 'alunos', 'as' => 'alunos.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Mestrado\TurmaAlunoController@grid']);
            Route::get('getAlunosByCurso/{idCurso}/{idTurma}/{idDisciplina}', ['as' => 'getAlunosByCurso', 'uses' => 'Mestrado\TurmaAlunoController@getAlunosByCurso']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\TurmaAlunoController@getLoadFields']);
            Route::post('attachAluno', ['as' => 'edit', 'uses' => 'Mestrado\TurmaAlunoController@attachAluno']);
            Route::post('detachAluno', ['as' => 'update', 'uses' => 'Mestrado\TurmaAlunoController@detachAluno']);
        });

        # Rotaas de diários de aulas
        Route::group(['prefix' => 'diarioAula', 'as' => 'diarioAula.'], function () {
            Route::get('grid/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Mestrado\DiarioAulaController@grid']);
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Mestrado\DiarioAulaController@gridDisciplinas']);
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\DiarioAulaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\DiarioAulaController@store']);
            Route::get('getConteudosProgramaticos', ['as' => 'getConteudosProgramaticos', 'uses' => 'Mestrado\DiarioAulaController@getConteudosProgramaticos']);
            Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\DiarioAulaController@delete']);
            Route::get('edit/{idDiarioAula}', ['as' => 'edit', 'uses' => 'Mestrado\DiarioAulaController@edit']);
            Route::post('update/{idDiarioAula}', ['as' => 'update', 'uses' => 'Mestrado\DiarioAulaController@update']);
            Route::get('gridConteudoProgramatico/{idDiarioAula}', ['as' => 'grid', 'uses' => 'Mestrado\DiarioAulaController@gridConteudoProgramatico']);
            Route::post('attachConteudo/{idDiarioAula}', ['as' => 'attachConteudo', 'uses' => 'Mestrado\DiarioAulaController@attachConteudo']);
            Route::post('detachConteudo/{idDiarioAula}', ['as' => 'detachConteudo', 'uses' => 'Mestrado\DiarioAulaController@detachConteudo']);
        });

        # Rotaas de planos de ensino
        Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Mestrado\TurmaPlanoEnsinoController@gridDisciplinas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\TurmaPlanoEnsinoController@getLoadFields']);
            Route::post('attachPlanoEnsino', ['as' => 'attachPlanoEnsino', 'uses' => 'Mestrado\TurmaPlanoEnsinoController@attachPlanoEnsino']);

        });
    });

    # Plano de Ensino
    Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
        Route::get('grid', ['as' => 'grid', 'uses' => 'Mestrado\PlanoEnsinoController@grid']);
        Route::get('index', ['as' => 'index', 'uses' => 'Mestrado\PlanoEnsinoController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'Mestrado\PlanoEnsinoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\PlanoEnsinoController@store']);
        Route::get('edit/{idplanoEnsino}', ['as' => 'edit', 'uses' => 'Mestrado\PlanoEnsinoController@edit']);
        Route::post('update/{idplanoEnsino}', ['as' => 'update', 'uses' => 'Mestrado\PlanoEnsinoController@update']);
        Route::delete('deleteAnexo/{idplanoEnsino}', ['as' => 'deleteAnexo', 'uses' => 'Mestrado\PlanoEnsinoController@deleteAnexo']);

        # Conteúdo programático
        Route::get('gridConteudoProgramatico/{idPlanoEnsino}', ['as' => 'gridConteudoProgramatico', 'uses' => 'Mestrado\PlanoEnsinoController@gridConteudoProgramatico']);
        Route::post('storeConteudoProgramatico', ['as' => 'storeConteudoProgramatico', 'uses' => 'Mestrado\PlanoEnsinoController@storeConteudoProgramatico']);
        Route::delete('deleteConteudoProgramatico/{id}', ['as' => 'deleteConteudoProgramatico', 'uses' => 'Mestrado\PlanoEnsinoController@deleteConteudoProgramatico']);

        # Planos de aula
        Route::group(['prefix' => 'planoAula', 'as' => 'planoAula.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\PlanoAulaController@getLoadFields']);
            Route::get('grid/{idPlanoEnsino}', ['as' => 'grid', 'uses' => 'Mestrado\PlanoAulaController@grid']);
            Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\PlanoAulaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Mestrado\PlanoAulaController@edit']);
            Route::post('update/{id}', ['update' => 'edit', 'uses' => 'Mestrado\PlanoAulaController@update']);
            Route::delete('delete/{id}', ['delete' => 'edit', 'uses' => 'Mestrado\PlanoAulaController@delete']);
            Route::get('getConteudosIn', ['as' => 'getConteudosIn', 'uses' => 'Mestrado\PlanoAulaController@getConteudosIn']);
            Route::get('gridConteudos/{idPlanoAula}', ['as' => 'gridConteudos', 'uses' => 'Mestrado\PlanoAulaController@gridConteudos']);
            Route::post('attachConteudo/{idPlanoAula}', ['as' => 'attachConteudo', 'uses' => 'Mestrado\PlanoAulaController@attachConteudo']);
            Route::post('detachConteudo/{idPlanoAula}', ['as' => 'detachConteudo', 'uses' => 'Mestrado\PlanoAulaController@detachConteudo']);

        });
    });

    /*# Rotaas de diários de aulas
    Route::group(['prefix' => 'diarioAula', 'as' => 'diarioAula.'], function () {
        Route::get('grid/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Mestrado\DiarioAulaController@grid']);
        Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Mestrado\DiarioAulaController@gridDisciplinas']);
        Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\DiarioAulaController@getLoadFields']);
        Route::post('store', ['as' => 'store', 'uses' => 'Mestrado\DiarioAulaController@store']);
        Route::get('getConteudosProgramaticos', ['as' => 'getConteudosProgramaticos', 'uses' => 'Mestrado\DiarioAulaController@getConteudosProgramaticos']);
        Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'Mestrado\DiarioAulaController@delete']);
        Route::get('edit/{idDiarioAula}', ['as' => 'edit', 'uses' => 'Mestrado\DiarioAulaController@edit']);
        Route::post('update/{idDiarioAula}', ['as' => 'update', 'uses' => 'Mestrado\DiarioAulaController@update']);
        Route::get('gridConteudoProgramatico/{idDiarioAula}', ['as' => 'grid', 'uses' => 'Mestrado\DiarioAulaController@gridConteudoProgramatico']);
        Route::post('attachConteudo/{idDiarioAula}', ['as' => 'attachConteudo', 'uses' => 'Mestrado\DiarioAulaController@attachConteudo']);
        Route::post('detachConteudo/{idDiarioAula}', ['as' => 'detachConteudo', 'uses' => 'Mestrado\DiarioAulaController@detachConteudo']);
    });

    # Rotaas de planos de ensino
    Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
        Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Mestrado\TurmaPlanoEnsinoController@gridDisciplinas']);
        Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Mestrado\TurmaPlanoEnsinoController@getLoadFields']);
        Route::post('attachPlanoEnsino', ['as' => 'attachPlanoEnsino', 'uses' => 'Mestrado\TurmaPlanoEnsinoController@attachPlanoEnsino']);

    });*/
});
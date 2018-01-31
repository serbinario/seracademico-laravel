<?php

Route::group(['prefix' => 'doutorado', 'as' => 'doutorado.'], function () {
    # Rotas do aluno de doutorado
    Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Doutorado\AlunoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Doutorado\AlunoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Doutorado\AlunoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\AlunoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\AlunoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Doutorado\AlunoController@update']);
        Route::get('search', ['as' => 'search', 'uses' => 'Doutorado\AlunoController@search']);
        Route::get('getImgAluno/{id}', ['as' => 'getImgAluno', 'uses' => 'Doutorado\AlunoController@getImgAluno']);

        #Rotas de Documentos
        Route::get('gerarDocumento/{tipoDoc}/{idAluno}', ['as' => 'gerarDocumento', 'uses' => 'Doutorado\AlunoDocumentoController@gerarDocumento']);
        Route::get('checkDocumento/{tipoDoc}/{idAluno}', ['as' => 'checkDocumento', 'uses' => 'Doutorado\AlunoDocumentoController@checkDocumento']);

        # Rotas de turmas de pósgraduação
        Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
            Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'Doutorado\AlunoTurmaController@grid']);
            Route::get('gridSituacoes/{idAlunoCurso}', ['as' => 'gridSituacoes', 'uses' => 'Doutorado\AlunoTurmaController@gridSituacoes']);
            Route::get('getCursos', ['as' => 'getCursos', 'uses' => 'Doutorado\AlunoTurmaController@getCursos']);
            Route::get('getTurmas/{idCurriculo}', ['as' => 'getCursos', 'uses' => 'Doutorado\AlunoTurmaController@getTurmas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\AlunoTurmaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\AlunoTurmaController@store']);
            Route::delete('destroy/{idAluno}/{idAlunoCurso}', ['as' => 'destroy', 'uses' => 'Doutorado\AlunoTurmaController@destroy']);
            Route::get('getTurmaOrigem/{idAlunoCurso}', ['as' => 'getTurmaOrigem', 'uses' => 'Doutorado\AlunoTurmaController@getTurmaOrigem']);
            Route::delete('destroySituacao/{idSituacao}', ['as' => 'destroySituacao', 'uses' => 'Doutorado\AlunoTurmaController@destroySituacao']);
            Route::post('storeSituacao', ['as' => 'storeSituacao', 'uses' => 'Doutorado\AlunoTurmaController@storeSituacao']);
//                    Route::get('edit/{idAlunoTurma}', ['as' => 'edit', 'uses' => 'PosGraduacao\AlunoTurmaController@edit']);
//                    Route::post('update/{idAlunoTurma}', ['as' => 'update', 'uses' => 'PosGraduacao\AlunoTurmaController@update']);
        });

        Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
            Route::get('gridACursar/{idAluno}', ['as' => 'gridACursar', 'uses' => 'Doutorado\AlunoCurriculoController@gridACursar']);
            Route::get('gridCursadas/{idAluno}', ['as' => 'gridCursadas', 'uses' => 'Doutorado\AlunoCurriculoController@gridCursadas']);
            Route::get('gridDispensadas/{idAluno}', ['as' => 'gridDispensadas', 'uses' => 'Doutorado\AlunoCurriculoController@gridDispensadas']);
            Route::get('gridDisciplinasExtraCurricular/{idAluno}', ['as' => 'gridDisciplinasExtraCurricular', 'uses' => 'Doutorado\AlunoCurriculoController@gridDisciplinasExtraCurricular']);
            Route::get('gridDisciplinasEquivalentes/{idAluno}', ['as' => 'gridDisciplinasEquivalentes', 'uses' => 'Doutorado\AlunoCurriculoController@gridDisciplinasEquivalentes']);
            Route::post('storeDispensada', ['as' => 'storeDispensada', 'uses' => 'Doutorado\AlunoCurriculoController@storeDispensada']);
            Route::get('deleteDispensada/{idDispensada}', ['as' => 'deleteDispensada', 'uses' => 'Doutorado\AlunoCurriculoController@deleteDispensada']);
            Route::get('editDispensada/{idDispensada}', ['as' => 'editDispensada', 'uses' => 'Doutorado\AlunoCurriculoController@editDispensada']);
            Route::post('updateDispensada/{idDispensada}', ['as' => 'updateDispensada', 'uses' => 'Doutorado\AlunoCurriculoController@updateDispensada']);
            Route::post('storeDisciplinaExtraCurricular', ['as' => 'storeDisciplinaExtraCurricular', 'uses' => 'Doutorado\AlunoCurriculoController@storeDisciplinaExtraCurricular']);
            Route::get('deleteDisciplinaExtraCurricular/{idDisciplina}', ['as' => 'deleteDisciplinaExtraCurricular', 'uses' => 'Doutorado\AlunoCurriculoController@deleteDisciplinaExtraCurricular']);
            Route::get('getDisciplinasByCurriculo/{idCurriculo}', ['as' => 'getDisciplinasByCurriculo', 'uses' => 'Doutorado\AlunoCurriculoController@getDisciplinasByCurriculo']);
            Route::post('storeEquivalencia', ['as' => 'storeEquivalencia', 'uses' => 'Doutorado\AlunoCurriculoController@storeEquivalencia']);
            Route::get('deleteEquivalencia/{id}', ['as' => 'deleteEquivalencia', 'uses' => 'Doutorado\AlunoCurriculoController@deleteEquivalencia']);
        });

        # Rotas para o financeiro do aluno
        Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\AlunoFinanceiroController@getLoadFields']);
            Route::get('gridDebitos/{id}', ['as' => 'gridDebitos', 'uses' => 'Doutorado\AlunoFinanceiroController@gridDebitos']);
            Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'Doutorado\AlunoFinanceiroController@storeDebito']);
            Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'Doutorado\AlunoFinanceiroController@getDebito']);
            Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'Doutorado\AlunoFinanceiroController@editDebito']);
            Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'Doutorado\AlunoFinanceiroController@updateDebito']);
            Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'Doutorado\AlunoFinanceiroController@gerarBoleto']);
            Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'Doutorado\AlunoFinanceiroController@infoDebito']);
            Route::get('gridCarnes/{id}', ['as' => 'gridCarnes', 'uses' => 'Doutorado\AlunoFinanceiroController@gridCarnes']);
        });
    });

    Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Doutorado\CursoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Doutorado\CursoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Doutorado\CursoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\CursoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\CursoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Doutorado\CursoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Doutorado\CursoController@delete']);
    });

    # Rotas de turma
    Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Doutorado\TurmaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Doutorado\TurmaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Doutorado\TurmaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\TurmaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\TurmaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Doutorado\TurmaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Doutorado\TurmaController@delete']);
        Route::get('getAllByCurso/{idCurso}', ['as' => 'getAllByCurso', 'uses' => 'Doutorado\TurmaController@getAllByCurso']);
        Route::get('getSedeByCurso/{idCurso}', ['as' => 'getSedeByCurso', 'uses' => 'Doutorado\TurmaController@getSedeByCurso']);
        Route::get('getTurmaBySede/{idSede}/{idCurso}', ['as' => 'getTurmaBySede', 'uses' => 'Doutorado\TurmaController@getTurmaBySede']);
        Route::get('getCalendariosByDisciplina/{idTurma}/{idDisciplina}', ['as' => 'getCalendariosByDisciplina', 'uses' => 'Doutorado\TurmaController@getCalendariosByDisciplina']);

        Route::group(['prefix' => 'calendario', 'as' => 'calendario.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Doutorado\CalendarioTurmaController@grid']);
            Route::get('gridCalendario/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Doutorado\CalendarioTurmaController@gridCalendario']);
            Route::get('disciplinas/{idTurma}', ['as' => 'grid', 'uses' => 'Doutorado\CalendarioTurmaController@disciplinasOfCurriculo']);
            Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\CalendarioTurmaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\CalendarioTurmaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Doutorado\CalendarioTurmaController@update']);
            Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'Doutorado\CalendarioTurmaController@delete']);
            Route::post('incluir', ['as' => 'incluir', 'uses' => 'Doutorado\CalendarioTurmaController@incluirDisciplina']);
            Route::post('remover-disciplina', ['as' => 'removerDisciplina', 'uses' => 'Doutorado\CalendarioTurmaController@removerDisciplina']);
        });

        Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Doutorado\TurmaNotaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\TurmaNotaController@getLoadFields']);
            Route::get('edit/{idAlunoNota}', ['as' => 'edit', 'uses' => 'Doutorado\TurmaNotaController@editNota']);
            Route::post('update/{idAlunoNota}', ['as' => 'update', 'uses' => 'Doutorado\TurmaNotaController@updateNota']);
            Route::get('delete/{idAlunoNota}', ['as' => 'delete', 'uses' => 'Doutorado\TurmaNotaController@deleteNota']);
        });

        Route::group(['prefix' => 'frequencias', 'as' => 'frequencias.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Doutorado\TurmaFrequenciaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\TurmaFrequenciaController@getLoadFields']);
            Route::put('changeFrequencia/{id}', ['as' => 'changeFrequencia', 'uses' => 'Doutorado\TurmaFrequenciaController@changeFrequencia']);
        });

        Route::group(['prefix' => 'alunos', 'as' => 'alunos.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Doutorado\TurmaAlunoController@grid']);
            Route::get('getAlunosByCurso/{idCurso}/{idTurma}/{idDisciplina}', ['as' => 'getAlunosByCurso', 'uses' => 'Doutorado\TurmaAlunoController@getAlunosByCurso']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\TurmaAlunoController@getLoadFields']);
            Route::post('attachAluno', ['as' => 'edit', 'uses' => 'Doutorado\TurmaAlunoController@attachAluno']);
            Route::post('detachAluno', ['as' => 'update', 'uses' => 'Doutorado\TurmaAlunoController@detachAluno']);
        });

        # Rotaas de diários de aulas
        Route::group(['prefix' => 'diarioAula', 'as' => 'diarioAula.'], function () {
            Route::get('grid/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Doutorado\DiarioAulaController@grid']);
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Doutorado\DiarioAulaController@gridDisciplinas']);
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\DiarioAulaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\DiarioAulaController@store']);
            Route::get('getConteudosProgramaticos', ['as' => 'getConteudosProgramaticos', 'uses' => 'Doutorado\DiarioAulaController@getConteudosProgramaticos']);
            Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'Doutorado\DiarioAulaController@delete']);
            Route::get('edit/{idDiarioAula}', ['as' => 'edit', 'uses' => 'Doutorado\DiarioAulaController@edit']);
            Route::post('update/{idDiarioAula}', ['as' => 'update', 'uses' => 'Doutorado\DiarioAulaController@update']);
            Route::get('gridConteudoProgramatico/{idDiarioAula}', ['as' => 'grid', 'uses' => 'Doutorado\DiarioAulaController@gridConteudoProgramatico']);
            Route::post('attachConteudo/{idDiarioAula}', ['as' => 'attachConteudo', 'uses' => 'Doutorado\DiarioAulaController@attachConteudo']);
            Route::post('detachConteudo/{idDiarioAula}', ['as' => 'detachConteudo', 'uses' => 'Doutorado\DiarioAulaController@detachConteudo']);
        });

        # Rotaas de planos de ensino
        Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Doutorado\TurmaPlanoEnsinoController@gridDisciplinas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\TurmaPlanoEnsinoController@getLoadFields']);
            Route::post('attachPlanoEnsino', ['as' => 'attachPlanoEnsino', 'uses' => 'Doutorado\TurmaPlanoEnsinoController@attachPlanoEnsino']);

        });
    });

    #Rotas de professores
    Route::group(['prefix' => 'professor', 'as' => 'professor.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Doutorado\ProfessorController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Doutorado\ProfessorController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Doutorado\ProfessorController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\ProfessorController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\ProfessorController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Doutorado\ProfessorController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Doutorado\ProfessorController@delete']);

        #Rotas de Documentos
        Route::get('gerarDocumento/{tipoDoc}/{idProfessor}', ['as' => 'gerarDocumento', 'uses' => 'Doutorado\ProfessorDocumentoController@gerarDocumento']);
        Route::get('checkDocumento/{tipoDoc}/{idProfessor}', ['as' => 'checkDocumento', 'uses' => 'Doutorado\ProfessorDocumentoController@checkDocumento']);
        Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\ProfessorController@getLoadFields']);
        Route::post('getProfessor', ['as' => 'getProfessor', 'uses' => 'Doutorado\ProfessorController@getProfessor']);
        Route::post('getDisciplina/{idProfessor}', ['as' => 'getDisciplina', 'uses' => 'Doutorado\ProfessorController@getDisciplina']);
    });

    # Rotas de disciplinas
    Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Doutorado\DisciplinaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Doutorado\DisciplinaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Doutorado\DisciplinaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\DisciplinaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\DisciplinaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Doutorado\DisciplinaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Doutorado\DisciplinaController@delete']);
    });

    # Rotas de curriculo
    Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Doutorado\CurriculoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Doutorado\CurriculoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Doutorado\CurriculoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\CurriculoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\CurriculoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Doutorado\CurriculoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Doutorado\CurriculoController@delete']);

        Route::post('adicionarDisciplinas', ['as' => 'adicionarDisciplinas', 'uses' => 'Doutorado\CurriculoController@adicionarDisciplinas']);
        Route::post('removerDisciplina', ['as' => 'removerDisciplina', 'uses' => 'Doutorado\CurriculoController@removerDisciplina']);
        Route::get('getByCurso/{idCurso}', ['as' => 'getByCurso', 'uses' => 'Doutorado\CurriculoController@getByCurso']);
        Route::get('gridByCurriculo/{id}', ['as' => 'gridByCurriculo', 'uses' => 'Doutorado\CurriculoController@gridByCurriculo']);
    });

    # Plano de Ensino
    Route::group(['prefix' => 'planoensino', 'as' => 'planoensino.'], function () {
        Route::get('grid', ['as' => 'grid', 'uses' => 'Doutorado\PlanoEnsinoController@grid']);
        Route::get('index', ['as' => 'index', 'uses' => 'Doutorado\PlanoEnsinoController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'Doutorado\PlanoEnsinoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\PlanoEnsinoController@store']);
        Route::get('edit/{idplanoEnsino}', ['as' => 'edit', 'uses' => 'Doutorado\PlanoEnsinoController@edit']);
        Route::post('update/{idplanoEnsino}', ['as' => 'update', 'uses' => 'Doutorado\PlanoEnsinoController@update']);
        Route::delete('deleteAnexo/{idplanoEnsino}', ['as' => 'deleteAnexo', 'uses' => 'Doutorado\PlanoEnsinoController@deleteAnexo']);

        # Conteúdo programático
        Route::get('gridConteudoProgramatico/{idPlanoEnsino}', ['as' => 'gridConteudoProgramatico', 'uses' => 'Doutorado\PlanoEnsinoController@gridConteudoProgramatico']);
        Route::post('storeConteudoProgramatico', ['as' => 'storeConteudoProgramatico', 'uses' => 'Doutorado\PlanoEnsinoController@storeConteudoProgramatico']);
        Route::delete('deleteConteudoProgramatico/{id}', ['as' => 'deleteConteudoProgramatico', 'uses' => 'Doutorado\PlanoEnsinoController@deleteConteudoProgramatico']);

        # Planos de aula
        Route::group(['prefix' => 'planoAula', 'as' => 'planoAula.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Doutorado\PlanoAulaController@getLoadFields']);
            Route::get('grid/{idPlanoEnsino}', ['as' => 'grid', 'uses' => 'Doutorado\PlanoAulaController@grid']);
            Route::post('store', ['as' => 'store', 'uses' => 'Doutorado\PlanoAulaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Doutorado\PlanoAulaController@edit']);
            Route::post('update/{id}', ['update' => 'edit', 'uses' => 'Doutorado\PlanoAulaController@update']);
            Route::delete('delete/{id}', ['delete' => 'edit', 'uses' => 'Doutorado\PlanoAulaController@delete']);
            Route::get('getConteudosIn', ['as' => 'getConteudosIn', 'uses' => 'Doutorado\PlanoAulaController@getConteudosIn']);
            Route::get('gridConteudos/{idPlanoAula}', ['as' => 'gridConteudos', 'uses' => 'Doutorado\PlanoAulaController@gridConteudos']);
            Route::post('attachConteudo/{idPlanoAula}', ['as' => 'attachConteudo', 'uses' => 'Doutorado\PlanoAulaController@attachConteudo']);
            Route::post('detachConteudo/{idPlanoAula}', ['as' => 'detachConteudo', 'uses' => 'Doutorado\PlanoAulaController@detachConteudo']);
        });
    });
});
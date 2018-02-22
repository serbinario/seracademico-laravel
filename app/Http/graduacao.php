<?php

Route::group(['prefix' => 'matricula', 'as' => 'matricula.'], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\MatriculaAlunoController@index']);
    Route::get('gridAluno', ['as' => 'gridAluno', 'uses' => 'Graduacao\MatriculaAlunoController@gridAluno']);
    Route::get('gridDisciplina/{idAluno}', ['as' => 'gridDisciplina', 'uses' => 'Graduacao\MatriculaAlunoController@gridDisciplina']);
    Route::get('gridHorario/{idAluno}', ['as' => 'gridHorario', 'uses' => 'Graduacao\MatriculaAlunoController@gridHorario']);
    Route::post('getTurmas', ['as' => 'getTurmas', 'uses' => 'Graduacao\MatriculaAlunoController@getTurmas']);
    Route::post('adicionarHorarioAluno', ['as' => 'adicionarHorarioAluno', 'uses' => 'Graduacao\MatriculaAlunoController@adicionarHorarioAluno']);
    Route::post('finalizarMatricula', ['as' => 'finalizarMatricula', 'uses' => 'Graduacao\MatriculaAlunoController@finalizarMatricula']);
    Route::post('getDisciplinas', ['as' => 'getDisciplinas', 'uses' => 'Graduacao\MatriculaAlunoController@getDisciplinas']);
    Route::post('removerHorario', ['as' => 'removerHorario', 'uses' => 'Graduacao\MatriculaAlunoController@removerHorario']);
    Route::get('validarPreRequisito', ['as' => 'validarPreRequisito', 'uses' => 'Graduacao\MatriculaAlunoController@validarPreRequisito']);
});

Route::group(['prefix' => 'graduacao', 'middleware' => 'auth', 'as' => 'graduacao.'], function () {
    Route::group(['prefix' => 'professor', 'as' => 'professor.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'ProfessorController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'ProfessorController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'ProfessorController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'ProfessorController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProfessorController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ProfessorController@update']);
        Route::get('contrato/{id}', ['as' => 'contrato', 'uses' => 'ProfessorController@contrato']);
        Route::get('getImg/{id}', ['as' => 'getImg', 'uses' => 'ProfessorController@getImg']);
    });

    Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\AlunoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\AlunoController@grid']);
        Route::get('search', ['as' => 'search', 'uses' => 'Graduacao\AlunoController@search']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\AlunoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\AlunoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\AlunoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\AlunoController@update']);
        Route::get('contrato/{id}', ['as' => 'contrato', 'uses' => 'Graduacao\AlunoController@contrato']);
        Route::get('reportFilter', ['as' => 'reportFilter', 'uses' => 'Graduacao\AlunoController@reportFilter']);
        Route::get('getImgAluno/{id}', ['as' => 'getImgAluno', 'uses' => 'Graduacao\AlunoController@getImgAluno']);

        #Rotas de Documentos
        Route::get('gerarDocumento/{tipoDoc}/{idAluno}', ['as' => 'gerarDocumento', 'uses' => 'Graduacao\AlunoDocumentoController@gerarDocumento']);
        Route::get('checkDocumento/{tipoDoc}/{idAluno}', ['as' => 'checkDocumento', 'uses' => 'Graduacao\AlunoDocumentoController@checkDocumento']);

        // Histórico do aluno
        Route::group(['prefix' => 'historico', 'as' => 'historico.'], function () {
            Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'Graduacao\HistoricoAlunoController@gridHistorico']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\HistoricoAlunoController@getLoadFields']);
            Route::post('save/{idAluno}', ['as' => 'save', 'uses' => 'Graduacao\HistoricoAlunoController@saveHistorico']);
            Route::post('delete/{idAlunoSemestre}', ['as' => 'save', 'uses' => 'Graduacao\HistoricoAlunoController@deleteHistorico']);
            Route::post('updatePeriodo', ['as' => 'updatePeriodo', 'uses' => 'Graduacao\HistoricoAlunoController@updatePeriodo']);

            // Situações do histórico
            Route::group(['prefix' => 'situacao', 'as' => 'situacao.'], function () {
                Route::get('grid/{idAlunoSemestre}', ['as' => 'grid', 'uses' => 'Graduacao\HistoricoAlunoController@gridSituacao']);
                Route::post('delete/{idAlunoSituacao}', ['as' => 'save', 'uses' => 'Graduacao\HistoricoAlunoController@deleteSituacao']);
                Route::post('save/{idSemestre}', ['as' => 'save', 'uses' => 'Graduacao\HistoricoAlunoController@saveSituacao']);
            });
        });

        // Currículo do aluno
        Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\CurriculoAlunoController@getLoadFields']);
            Route::get('gridACursar/{idAluno}', ['as' => 'gridACursar', 'uses' => 'Graduacao\CurriculoAlunoController@gridACursar']);
            Route::get('gridCursando/{idAluno}', ['as' => 'gridCursando', 'uses' => 'Graduacao\CurriculoAlunoController@gridCursando']);
            Route::get('gridCursadas/{idAluno}', ['as' => 'gridCursadas', 'uses' => 'Graduacao\CurriculoAlunoController@gridCursadas']);
            Route::get('gridDispensadas/{idAluno}', ['as' => 'gridDispensadas', 'uses' => 'Graduacao\CurriculoAlunoController@gridDispensadas']);
            Route::get('gridExtraCurricular/{idAluno}', ['as' => 'gridExtraCurricular', 'uses' => 'Graduacao\CurriculoAlunoController@gridExtraCurricular']);
            Route::get('gridEletiva/{idAluno}', ['as' => 'gridEletiva', 'uses' => 'Graduacao\CurriculoAlunoController@gridEletiva']);
            Route::get('gridEquivalencia/{idAluno}', ['as' => 'gridEquivalencia', 'uses' => 'Graduacao\CurriculoAlunoController@gridEquivalencia']);
            Route::post('storeDispensada', ['as' => 'storeDispensada', 'uses' => 'Graduacao\CurriculoAlunoController@storeDispensada']);
            Route::get('deleteDispensada/{id}', ['as' => 'deleteDispensada', 'uses' => 'Graduacao\CurriculoAlunoController@deleteDispensada']);
            Route::get('editDispensada/{id}', ['as' => 'editDispensada', 'uses' => 'Graduacao\CurriculoAlunoController@editDispensada']);
            Route::post('updateDispensada/{id}', ['as' => 'updateDispensada', 'uses' => 'Graduacao\CurriculoAlunoController@updateDispensada']);
            Route::post('storeDisciplinaExtraCurricular', ['as' => 'storeDisciplinaExtraCurricular', 'uses' => 'Graduacao\CurriculoAlunoController@storeDisciplinaExtraCurricular']);
            Route::post('storeDisciplinaEletiva', ['as' => 'storeDisciplinaEletiva', 'uses' => 'Graduacao\CurriculoAlunoController@storeDisciplinaEletiva']);
            Route::get('getDisciplinasByCurriculo/{idCurriculo}', ['as' => 'getDisciplinasByCurriculo', 'uses' => 'Graduacao\CurriculoAlunoController@getDisciplinasByCurriculo']);
            Route::get('deleteDisciplinaExtraCurricular/{id}', ['as' => 'deleteDisciplinaExtraCurricular', 'uses' => 'Graduacao\CurriculoAlunoController@deleteDisciplinaExtraCurricular']);
            Route::get('deleteDisciplinaEletiva/{id}', ['as' => 'deleteDisciplinaEletiva', 'uses' => 'Graduacao\CurriculoAlunoController@deleteDisciplinaEletiva']);
            Route::post('storeEquivalencia', ['as' => 'storeEquivalencia', 'uses' => 'Graduacao\CurriculoAlunoController@storeEquivalencia']);
            Route::get('deleteEquivalencia/{id}', ['as' => 'deleteEquivalencia', 'uses' => 'Graduacao\CurriculoAlunoController@deleteEquivalencia']);
        });

        // Semestre do aluno
        Route::group(['prefix' => 'semestre', 'as' => 'semestre.'], function () {
            Route::get('getTurmas/{idAluno}/{idSemestre}', ['as' => 'gridHorario', 'uses' => 'Graduacao\SemestreAlunoController@getTurmas']);
            Route::get('gridHorario/{idAluno}/{idSemestre}', ['as' => 'gridHorario', 'uses' => 'Graduacao\SemestreAlunoController@gridHorario']);
            Route::get('gridNotas/{idAluno}/{idSemestre}', ['as' => 'gridNotas', 'uses' => 'Graduacao\SemestreAlunoController@gridNotas']);
            Route::get('gridFaltas/{idAluno}/{idSemestre}', ['as' => 'gridFaltas', 'uses' => 'Graduacao\SemestreAlunoController@gridFaltas']);
            Route::get('gridDisciplina/{idAluno}', ['as' => 'gridDisciplina', 'uses' => 'Graduacao\DisciplinaAlunoController@gridDisciplina']);
            Route::post('getTurmasHorarios/{idSemestre}', ['as' => 'getTurmasHorarios', 'uses' => 'Graduacao\DisciplinaAlunoController@getTurmas']);
            Route::post('adicionarHorarioAluno/{idSemestre}', ['as' => 'adicionarHorarioAluno', 'uses' => 'Graduacao\DisciplinaAlunoController@adicionarHorarioAluno']);
            Route::post('getDisciplinas', ['as' => 'getDisciplinas', 'uses' => 'Graduacao\DisciplinaAlunoController@getDisciplinas']);
            Route::post('removerHorario', ['as' => 'removerHorario', 'uses' => 'Graduacao\DisciplinaAlunoController@removerHorario']);
        });

        Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\AlunoTurmaController@getLoadFields']);
        });

        # Rotas para o financeiro do aluno de pós
        Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\AlunoFinanceiroController@getLoadFields']);
            Route::get('gridDebitos/{id}', ['as' => 'gridDebitos', 'uses' => 'Graduacao\AlunoFinanceiroController@gridDebitos']);
            Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'Graduacao\AlunoFinanceiroController@storeDebito']);
            Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'Graduacao\AlunoFinanceiroController@getDebito']);
            Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'Graduacao\AlunoFinanceiroController@editDebito']);
            Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'Graduacao\AlunoFinanceiroController@updateDebito']);
            Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'Graduacao\AlunoFinanceiroController@gerarBoleto']);
            Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'Graduacao\AlunoFinanceiroController@infoDebito']);
            Route::get('gridCarnes/{id}', ['as' => 'gridCarnes', 'uses' => 'Graduacao\AlunoFinanceiroController@gridCarnes']);
            Route::get('getDadosDebito/{id}', ['as' => 'getDadosDebito', 'uses' => 'Graduacao\AlunoFinanceiroController@getDadosDebito']);
            Route::get('deleteDebito/{id}', ['as' => 'deleteDebito', 'uses' => 'Graduacao\AlunoFinanceiroController@delete']);
            Route::get('deleteCarne/{id}', ['as' => 'deleteCarne', 'uses' => 'Graduacao\AlunoFinanceiroController@deleteCarne']);
        });
    });

    // Motivo
    Route::group(['prefix' => 'motivo', 'as' => 'motivo.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\MotivoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\MotivoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\MotivoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\MotivoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\MotivoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\MotivoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\MotivoController@delete']);
    });

    Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\DisciplinaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\DisciplinaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\DisciplinaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\DisciplinaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\DisciplinaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\DisciplinaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\DisciplinaController@delete']);
    });

    Route::group(['prefix' => 'semestre', 'as' => 'semestre.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\SemestreController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\SemestreController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\SemestreController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\SemestreController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\SemestreController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\SemestreController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\SemestreController@delete']);
    });

    Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\CursoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\CursoController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\CursoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\CursoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\CursoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\CursoController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\CursoController@delete']);
        Route::post('getByVestibular', ['as' => 'getByVestibular', 'uses' => 'Graduacao\CursoController@getByVestibular']);

        Route::group(['prefix' => 'precos', 'as' => 'precos.'], function () {
            Route::get('grid/{idCurso}', ['as' => 'grid', 'uses' => 'Graduacao\TabelaPrecoCursoController@grid']);
            Route::post('getLoadFields', ['as' => 'grid', 'uses' => 'Graduacao\TabelaPrecoCursoController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\TabelaPrecoCursoController@store']);
            Route::post('delete', ['as' => 'store', 'uses' => 'Graduacao\TabelaPrecoCursoController@delete']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\TabelaPrecoCursoController@update']);
            Route::get('edit/{idPrecoCurso}', ['as' => 'edit', 'uses' => 'Graduacao\TabelaPrecoCursoController@edit']);

            Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
                Route::get('grid/{idPrecoCurso}', ['as' => 'grid', 'uses' => 'Graduacao\PrecoDisciplinaCursoController@grid']);
                Route::post('getLoadFields', ['as' => 'grid', 'uses' => 'Graduacao\PrecoDisciplinaCursoController@getLoadFields']);
                Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\PrecoDisciplinaCursoController@store']);
                Route::post('delete', ['as' => 'store', 'uses' => 'Graduacao\PrecoDisciplinaCursoController@delete']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\PrecoDisciplinaCursoController@update']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\PrecoDisciplinaCursoController@edit']);
            });
        });
    });

    Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
        Route::post('getLoadFields', ['as' => 'grid', 'uses' => 'Graduacao\CurriculoController@getLoadFields']);
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\CurriculoController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\CurriculoController@grid']);
        Route::get('gridByCurriculo/{id}', ['as' => 'gridByCurriculo', 'uses' => 'Graduacao\CurriculoController@gridByCurriculo']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\CurriculoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\CurriculoController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\CurriculoController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\CurriculoController@update']);
        Route::get('getByCurso/{idCurso}', ['as' => 'getByCurso', 'uses' => 'Graduacao\CurriculoController@getByCurso']);

        # Disciplinas
        Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
            Route::get('get/{idDisciplina}', ['as' => 'edit', 'uses' => 'Graduacao\CurriculoController@getDisciplina']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\CurriculoController@disciplinaStore']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\CurriculoController@disciplinaDelete']);
            Route::get('edit/{idDisciplina}/{idCurriculo}', ['as' => 'edit', 'uses' => 'Graduacao\CurriculoController@disciplinaEdit']);
            Route::post('update/{idDisciplina}/{idCurriculo}', ['as' => 'update', 'uses' => 'Graduacao\CurriculoController@disciplinaUpdate']);
        });

        # Disciplinas Eletivas
        Route::group(['prefix' => 'eletiva', 'as' => 'eletiva.'], function () {
            Route::get('grid/{idCurriculo}', ['as' => 'edit', 'uses' => 'Graduacao\CurriculoEletivaController@grid']);
            Route::get('gridOpcoesEletivas/{idCurriculoDisciplinaEletiva}', ['as' => 'edit', 'uses' => 'Graduacao\CurriculoEletivaController@gridOpcoesEletivas']);
            Route::post('storeOpcaoEletiva', ['as' => 'storeOpcaoEletiva', 'uses' => 'Graduacao\CurriculoEletivaController@storeOpcaoEletiva']);
            Route::get('deleteOpcaoEletiva/{id}', ['as' => 'deleteOpcaoEletiva', 'uses' => 'Graduacao\CurriculoEletivaController@deleteOpcaoEletiva']);
        });

        # Rotas de relatórios
        Route::get('reportView', ['as' => 'reportView', 'uses' => 'Graduacao\CurriculoController@reportView']);
        Route::get('reportById/{id}', ['as' => 'reportById', 'uses' => 'Graduacao\CurriculoController@reportById']);
    });

    Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\TurmaController@index']);
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\TurmaController@grid']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\TurmaController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\TurmaController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\TurmaController@edit']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\TurmaController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\TurmaController@delete']);

        Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\TurmaDisciplinaController@getLoadFields']);
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Graduacao\TurmaDisciplinaController@grid']);
            Route::post('store', ['as' => 'incluir', 'uses' => 'Graduacao\TurmaDisciplinaController@store']);
            Route::post('delete', ['as' => 'removerDisciplina', 'uses' => 'Graduacao\TurmaDisciplinaController@delete']);
        });

        Route::group(['prefix' => 'horario', 'as' => 'horario.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\HorarioTurmaController@getLoadFields']);
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Graduacao\HorarioTurmaController@grid']);
            Route::post('horasDisponiveis', ['as' => 'delete', 'uses' => 'Graduacao\HorarioTurmaController@horasDisponiveis']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\HorarioTurmaController@delete']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\HorarioTurmaController@store']);
            Route::get('edit/{idTurma}/{idHora}/{idDia}', ['as' => 'grid', 'uses' => 'Graduacao\HorarioTurmaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\HorarioTurmaController@update']);
            Route::get('eJuncao', ['as' => 'eJuncao', 'uses' => 'Graduacao\HorarioTurmaController@eJuncao']);

//                    Route::get('disciplinas/{idTurma}', ['as' => 'grid', 'uses' => 'CalendarioTurmaController@disciplinasOfCurriculo']);
//                    Route::post('store', ['as' => 'store', 'uses' => 'CalendarioTurmaController@store']);
//                    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CalendarioTurmaController@edit']);
//                    Route::post('update/{id}', ['as' => 'update', 'uses' => 'CalendarioTurmaController@update']);
//                    Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'CalendarioTurmaController@delete']);
        });

        Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Graduacao\TurmaNotaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\TurmaNotaController@getLoadFields']);
            Route::get('edit/{idAlunoNota}', ['as' => 'edit', 'uses' => 'Graduacao\TurmaNotaController@editNota']);
            Route::post('update/{idAlunoNota}', ['as' => 'update', 'uses' => 'Graduacao\TurmaNotaController@updateNota']);
        });

        Route::group(['prefix' => 'frequencias', 'as' => 'frequencias.'], function () {
            Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'Graduacao\TurmaFrequenciaController@grid']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\TurmaFrequenciaController@getLoadFields']);
            Route::get('edit/{idAlunoFrequencia}', ['as' => 'edit', 'uses' => 'Graduacao\TurmaFrequenciaController@editFrequencia']);
            Route::post('update/{idAlunoFrequencia}', ['as' => 'update', 'uses' => 'Graduacao\TurmaFrequenciaController@updateFrequencia']);
        });

        # Rotaas de diários de aulas
        Route::group(['prefix' => 'diarioAula', 'as' => 'diarioAula.'], function () {
            Route::get('grid/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'Graduacao\DiarioAulaController@grid']);
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Graduacao\DiarioAulaController@gridDisciplinas']);
            Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\DiarioAulaController@getLoadFields']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\DiarioAulaController@store']);
            Route::get('getConteudosProgramaticos', ['as' => 'getConteudosProgramaticos', 'uses' => 'Graduacao\DiarioAulaController@getConteudosProgramaticos']);
            Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\DiarioAulaController@delete']);
            Route::get('edit/{idDiarioAula}', ['as' => 'edit', 'uses' => 'Graduacao\DiarioAulaController@edit']);
            Route::post('update/{idDiarioAula}', ['as' => 'update', 'uses' => 'Graduacao\DiarioAulaController@update']);
            Route::get('gridConteudoProgramatico/{idDiarioAula}', ['as' => 'grid', 'uses' => 'Graduacao\DiarioAulaController@gridConteudoProgramatico']);
            Route::post('attachConteudo/{idDiarioAula}', ['as' => 'attachConteudo', 'uses' => 'Graduacao\DiarioAulaController@attachConteudo']);
            Route::post('detachConteudo/{idDiarioAula}', ['as' => 'detachConteudo', 'uses' => 'Graduacao\DiarioAulaController@detachConteudo']);
        });

        # Rotaas de planos de ensino
        Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
            Route::get('gridDisciplinas/{idTurma}', ['as' => 'gridDisciplinas', 'uses' => 'Graduacao\TurmaPlanoEnsinoController@gridDisciplinas']);
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\TurmaPlanoEnsinoController@getLoadFields']);
            Route::post('attachPlanoEnsino', ['as' => 'attachPlanoEnsino', 'uses' => 'Graduacao\TurmaPlanoEnsinoController@attachPlanoEnsino']);

        });
    });

    Route::group(['prefix' => 'planoEnsino', 'as' => 'planoEnsino.'], function () {
        Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\PlanoEnsinoController@grid']);
        Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\PlanoEnsinoController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\PlanoEnsinoController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\PlanoEnsinoController@store']);
        Route::get('edit/{idplanoEnsino}', ['as' => 'edit', 'uses' => 'Graduacao\PlanoEnsinoController@edit']);
        Route::post('update/{idplanoEnsino}', ['as' => 'update', 'uses' => 'Graduacao\PlanoEnsinoController@update']);
        Route::delete('deleteAnexo/{idplanoEnsino}', ['as' => 'deleteAnexo', 'uses' => 'Graduacao\PlanoEnsinoController@deleteAnexo']);

        # Conteúdo programático
        Route::get('gridConteudoProgramatico/{idPlanoEnsino}', ['as' => 'gridConteudoProgramatico', 'uses' => 'Graduacao\PlanoEnsinoController@gridConteudoProgramatico']);
        Route::post('storeConteudoProgramatico', ['as' => 'storeConteudoProgramatico', 'uses' => 'Graduacao\PlanoEnsinoController@storeConteudoProgramatico']);
        Route::delete('deleteConteudoProgramatico/{id}', ['as' => 'deleteConteudoProgramatico', 'uses' => 'Graduacao\PlanoEnsinoController@deleteConteudoProgramatico']);

        # Planos de aula
        Route::group(['prefix' => 'planoAula', 'as' => 'planoAula.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\PlanoAulaController@getLoadFields']);
            Route::get('grid/{idPlanoEnsino}', ['as' => 'grid', 'uses' => 'Graduacao\PlanoAulaController@grid']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\PlanoAulaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\PlanoAulaController@edit']);
            Route::post('update/{id}', ['update' => 'edit', 'uses' => 'Graduacao\PlanoAulaController@update']);
            Route::delete('delete/{id}', ['delete' => 'edit', 'uses' => 'Graduacao\PlanoAulaController@delete']);
            Route::get('getConteudosIn', ['as' => 'getConteudosIn', 'uses' => 'Graduacao\PlanoAulaController@getConteudosIn']);
            Route::get('gridConteudos/{idPlanoAula}', ['as' => 'gridConteudos', 'uses' => 'Graduacao\PlanoAulaController@gridConteudos']);
            Route::post('attachConteudo/{idPlanoAula}', ['as' => 'attachConteudo', 'uses' => 'Graduacao\PlanoAulaController@attachConteudo']);
            Route::post('detachConteudo/{idPlanoAula}', ['as' => 'detachConteudo', 'uses' => 'Graduacao\PlanoAulaController@detachConteudo']);
        });
    });

    Route::group(['prefix' => 'relatorios', 'as' => 'relatorios.'], function () {
        Route::get('quantitativoAlunos', ['as' => 'quantitativoAlunos', 'uses' => 'Graduacao\AlunoController@quantitativoAlunos']);
        Route::get('getDadosReportQuantitativoAlunos/{idVestibular}', ['as' => 'getDadosReportQuantitativoAlunos', 'uses' => 'Graduacao\AlunoController@getDadosReportQuantitativoAlunos']);
    });
});
<?php

Route::get("", ['middleware' => 'auth', 'uses' => 'DefaultController@index']);

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    Route::group(['prefix' => 'seracademico', 'middleware' => 'auth', 'as' => 'seracademico.'], function () {

        //INICIO DE ROTAS DO MODULO CURSO TÉCNICO
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
                Route::get('grid', ['as' => 'grid', 'uses' => 'Tecnico\ModuloController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'Tecnico\ModuloController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'Tecnico\ModuloController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Tecnico\ModuloController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Tecnico\ModuloController@update']);
                Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Tecnico\ModuloController@delete']);
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
        });
        //FIM TÉCNICO

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

        Route::group(['prefix' => 'vestibulando', 'as' => 'vestibulando.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibulandoController@getLoadFields']);
            Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\VestibulandoController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\VestibulandoController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\VestibulandoController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibulandoController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'Graduacao\VestibulandoController@delete']);
            Route::post('search', ['as' => 'search', 'uses' => 'Graduacao\VestibulandoController@search']);
            Route::delete('deleteComprovante/{id}', ['as' => 'deleteComprovante', 'uses' => 'Graduacao\VestibulandoController@deleteComprovante']);
            Route::get('reportFilter', ['as' => 'reportFilter', 'uses' => 'Graduacao\VestibulandoController@reportFilter']);
            Route::get('getImgAluno/{id}', ['as' => 'getImgAluno', 'uses' => 'Graduacao\VestibulandoController@getImgAluno']);

            Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
                Route::get('grid/{idVestibulando}', ['as' => 'grid', 'uses' => 'Graduacao\VestibulandoController@gridNotas']);
                Route::post('edit', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@editNota']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@updateNota']);
            });

            Route::group(['prefix' => 'inclusao', 'as' => 'inclusao.'], function () {
                Route::post('edit/{idVestibulando}', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@editInclusao']);
                Route::post('update/{idVestibulando}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@updateInclusao']);
            });

            # Rotas para o financeiro do aluno de pós
            Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
                Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibulandoFinanceiroController@getLoadFields']);
                Route::get('gridDebitosAbertos/{id}', ['as' => 'gridDebitos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gridDebitosAbertos']);
                Route::get('gridDebitosPagos/{id}', ['as' => 'gridDebitos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gridDebitosPagos']);
                Route::post('storeDebito/{id}', ['as' => 'storeDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@storeDebito']);
                Route::get('getDebito/{idDebito}', ['as' => 'getDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@getDebito']);
                Route::get('editDebito/{idDebito}', ['as' => 'editDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@editDebito']);
                Route::post('updateDebito/{idDebito}', ['as' => 'updateDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@updateDebito']);
                Route::get('gerarBoleto/{idDebito}', ['as' => 'gerarBoleto', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gerarBoleto']);
                Route::get('infoDebito/{idDebito}', ['as' => 'infoDebito', 'uses' => 'Graduacao\VestibulandoFinanceiroController@infoDebito']);
            });
        });

        //Rotas de Doutorado
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

        //Rotas de Doutorado
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

        //Rotas de pos-graduação
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

        //Rotas para graduação
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
                    Route::get('getMensalidade/{id}', ['as' => 'getMensalidade', 'uses' => 'Graduacao\AlunoFinanceiroController@getMensalidade']);
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
        });


        //Rotas gerais
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

        Route::group(['prefix' => 'vestibular', 'as' => 'vestibular.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\VestibularController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\VestibularController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\VestibularController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibularController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibularController@update']);
            Route::get('delete/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibularController@delete']);
            Route::get('getByValidDate', ['as' => 'getValidDate', 'uses' => 'Graduacao\VestibularController@getByValidDate']);

            Route::group(['prefix' => 'relatorios', 'as' => 'relatorios.'], function () {
                Route::get('relatorio1', ['as' => 'relatorio1', 'uses' => 'Graduacao\VestibularController@relatorio1']);
                Route::get('relatorio2', ['as' => 'relatorio2', 'uses' => 'Graduacao\VestibularController@relatorio2']);
                //Route::get('printQuantidadesGerais', ['as' => 'printQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@printQuantidadesGerais']);
                Route::get('viewReportQuantidadesGerais', ['as' => 'viewReportQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@viewReportQuantidadesGerais']);
                Route::get('getReportQuantidadesGerais/{id}', ['as' => 'getReportQuantidadesGerais', 'uses' => 'Graduacao\VestibularController@getReportQuantidadesGerais']);
            });

            Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
                Route::get('grid/{idVestibular}', ['as' => 'grid', 'uses' => 'Graduacao\VestibularCursoController@grid']);
                Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\VestibularCursoController@delete']);
                Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularCursoController@store']);

                Route::group(['prefix' => 'materia', 'as' => 'materia.'], function () {
                    Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibularCursoMateriaController@getLoadFields']);
                    Route::get('grid/{idVestibularCurso}', ['as' => 'grid', 'uses' => 'Graduacao\VestibularCursoMateriaController@grid']);
                    Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\VestibularCursoMateriaController@delete']);
                    Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularCursoMateriaController@store']);
                });

                Route::group(['prefix' => 'turno', 'as' => 'turno.'], function () {
                    Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibularCursoTurnoController@getLoadFields']);
                    Route::get('grid/{idVestibularCurso}', ['as' => 'grid', 'uses' => 'Graduacao\VestibularCursoTurnoController@grid']);
                    Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\VestibularCursoTurnoController@delete']);
                    Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularCursoTurnoController@store']);
                    Route::post('getTurnosByCurso', ['as' => 'getTurnosByCurso', 'uses' => 'Graduacao\VestibularCursoTurnoController@getTurnosByCurso']);
                });
            });
        });


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
            Route::post('findWhereEmprestimo', ['as' => 'findWhereEmprestimo', 'uses' => 'Biblioteca\EmprestarController@findWhereEmprestimo']);
            Route::post('confirmarEmprestimo', ['as' => 'confirmarEmprestimo', 'uses' => 'Biblioteca\EmprestarController@confirmarEmprestimo']);
            Route::get('deleteEmprestimo/{id}/{id2}', ['as' => 'deleteEmprestimo', 'uses' => 'Biblioteca\EmprestarController@deleteEmprestimo']);
            
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

            Route::get('indexEditBiblioteca', ['as' => 'indexEditBiblioteca', 'uses' => 'Biblioteca\RelatorioController@indexEditBiblioteca']);
            Route::get('editBiblioteca', ['as' => 'editBiblioteca', 'uses' => 'Biblioteca\RelatorioController@editBiblioteca']);
            
        });

        //Rotas para componentes de segurança
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

        //Rotas para componentes de segurança
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'UserController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'UserController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'UserController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'UserController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'UserController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'UserController@update']);
        });

        Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'RoleController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'RoleController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'RoleController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'RoleController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'RoleController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'RoleController@update']);
        });

        //Rotas de utilitários
        Route::group(['prefix' => 'util', 'as' => 'util.'], function () {
            # Refatorando os métodos do select2
            Route::post('simpleQuery', ['as' => 'simpleQuery', 'uses' => 'Select2Controller@simpleQuery']);

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

        # Rotas para o financeiro
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
            Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
                Route::get('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Financeiro\AlunoFinanceiroController@getLoadFields']);
                Route::get('gridDebitosAbertos/{idAluno}', ['as' => 'gridDebitosAbertos', 'uses' => 'Financeiro\AlunoFinanceiroController@gridDebitosAbertos']);
                Route::get('gridFechamentos/{idAluno}', ['as' => 'gridDebitosAbertos', 'uses' => 'Financeiro\AlunoFinanceiroController@gridFechamentos']);
                Route::get('gridBoletos/{idAluno}', ['as' => 'gridBoletos', 'uses' => 'Financeiro\AlunoFinanceiroController@gridBoletos']);
                Route::post('storeDebitoAberto', ['as' => 'storeDebitoAberto', 'uses' => 'Financeiro\AlunoFinanceiroController@storeDebitoAberto']);
                Route::post('storeFechamento', ['as' => 'storeFechamento', 'uses' => 'Financeiro\AlunoFinanceiroController@storeFechamento']);
                Route::post('getDebitoAberto/{id}', ['as' => 'getDebitoAberto', 'uses' => 'Financeiro\AlunoFinanceiroController@getDebitoAberto']);
                Route::get('gerarBoleto/{id}', ['as' => 'gerarBoleto', 'uses' => 'Financeiro\AlunoFinanceiroController@gerarBoleto']);
                Route::post('storeBoleto', ['as' => 'storeBoleto', 'uses' => 'Financeiro\AlunoFinanceiroController@storeBoleto']);

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
        });

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



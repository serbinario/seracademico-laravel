<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    Route::group(['prefix' => 'seracademico', 'middleware' => 'auth', 'as' => 'seracademico.'], function () {
        Route::group(['prefix' => 'matricula', 'as' => 'matricula.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\MatriculaAlunoController@index']);
            Route::get('gridAluno', ['as' => 'gridAluno', 'uses' => 'Graduacao\MatriculaAlunoController@gridAluno']);
            Route::get('gridDisciplina/{idAluno}', ['as' => 'gridDisciplina', 'uses' => 'Graduacao\MatriculaAlunoController@gridDisciplina']);
            Route::get('gridHorario/{idAluno}', ['as' => 'gridHorario', 'uses' => 'Graduacao\MatriculaAlunoController@gridHorario']);
            Route::post('getTurmas', ['as' => 'getTurmas', 'uses' => 'Graduacao\MatriculaAlunoController@getTurmas']);
            Route::post('adicionarHorarioAluno', ['as' => 'adicionarHorarioAluno', 'uses' => 'Graduacao\MatriculaAlunoController@adicionarHorarioAluno']);
            Route::post('finalizarMatricula', ['as' => 'finalizarMatricula', 'uses' => 'Graduacao\MatriculaAlunoController@finalizarMatricula']);
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

        Route::group(['prefix' => 'vestibulando', 'as' => 'vestibulando.'], function () {
            Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibulandoController@getLoadFields']);
            Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\VestibulandoController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\VestibulandoController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\VestibulandoController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibulandoController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@update']);
            Route::post('search', ['as' => 'search', 'uses' => 'Graduacao\VestibulandoController@search']);

            Route::group(['prefix' => 'notas', 'as' => 'notas.'], function () {
                Route::get('grid/{idVestibulando}', ['as' => 'grid', 'uses' => 'Graduacao\VestibulandoController@gridNotas']);
                Route::post('edit', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@editNota']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@updateNota']);
            });

            Route::group(['prefix' => 'inclusao', 'as' => 'inclusao.'], function () {
                Route::post('edit/{idVestibulando}', ['as' => 'edit', 'uses' => 'Graduacao\VestibulandoController@editInclusao']);
                Route::post('update/{idVestibulando}', ['as' => 'update', 'uses' => 'Graduacao\VestibulandoController@updateInclusao']);
            });

            Route::group(['prefix' => 'financeiro', 'as' => 'financeiro.'], function () {
                Route::get('gridDebitosAbertos/{idVestibulando}', ['as' => 'gridDebitosAbertos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gridDebitosAbertos']);
                Route::get('gridDebitosPagos/{idVestibulando}', ['as' => 'gridDebitosPagos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@gridDebitosPagos']);
                Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\VestibulandoFinanceiroController@getLoadFields']);
                Route::post('storeDebitosAbertos', ['as' => 'storeDebitosAbertos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@storeDebitosAbertos']);
                Route::get('editDebitosAbertos/{id}', ['as' => 'editDebitosAbertos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@editDebitosAbertos']);
                Route::post('updateDebitosAbertos/{id}', ['as' => 'updateDebitosAbertos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@updateDebitosAbertos']);
                Route::get('deleteDebitosAbertos/{id}', ['as' => 'deleteDebitosAbertos', 'uses' => 'Graduacao\VestibulandoFinanceiroController@deleteDebitosAbertos']);
            });
        });

        //Rotas de pos-graduação
        Route::group(['prefix' => 'posgraduacao', 'as' => 'posgraduacao.'], function () {

            Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'AlunoController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'AlunoController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'AlunoController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'AlunoController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'AlunoController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'AlunoController@update']);
                Route::get('contrato/{id}', ['as' => 'contrato', 'uses' => 'AlunoController@contrato']);

                Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
                    Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'AlunoTurmaController@grid']);
                    Route::get('gridACursar/{idAlunoTurma}', ['as' => 'gridACursar', 'uses' => 'AlunoTurmaController@gridACursar']);
                    Route::get('gridCursadas/{idAlunoTurma}', ['as' => 'gridCursadas', 'uses' => 'AlunoTurmaController@gridCursadas']);
                    Route::get('gridDispensadas/{idAlunoTurma}', ['as' => 'gridDispensadas', 'uses' => 'AlunoTurmaController@gridDispensadas']);
                    Route::get('getCursos', ['as' => 'getCursos', 'uses' => 'AlunoTurmaController@getCursos']);
                    Route::get('getTurmas/{idCurriculo}', ['as' => 'getCursos', 'uses' => 'AlunoTurmaController@getTurmas']);
                    Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'AlunoTurmaController@getLoadFields']);
                    Route::post('store', ['as' => 'store', 'uses' => 'AlunoTurmaController@store']);
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
            });

            Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'DisciplinaController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'DisciplinaController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'DisciplinaController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'DisciplinaController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'DisciplinaController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'DisciplinaController@update']);
                Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'DisciplinaController@delete']);
            });

            Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'CursoController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'CursoController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'CursoController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'CursoController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CursoController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'CursoController@update']);
                Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'CursoController@delete']);
            });

            Route::group(['prefix' => 'curriculo', 'as' => 'curriculo.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'CurriculoController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'CurriculoController@grid']);
                Route::get('gridByCurriculo/{id}', ['as' => 'gridByCurriculo', 'uses' => 'CurriculoController@gridByCurriculo']);
                Route::get('create', ['as' => 'create', 'uses' => 'CurriculoController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'CurriculoController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CurriculoController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'CurriculoController@update']);
                Route::post('adicionarDisciplinas', ['as' => 'adicionarDisciplinas', 'uses' => 'CurriculoController@adicionarDisciplinas']);
                Route::post('removerDisciplina', ['as' => 'removerDisciplina', 'uses' => 'CurriculoController@removerDisciplina']);
            });

            Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'TurmaController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'TurmaController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'TurmaController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'TurmaController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TurmaController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'TurmaController@update']);

                Route::group(['prefix' => 'calendario', 'as' => 'calendario.'], function () {
                    Route::get('grid/{idTurma}', ['as' => 'grid', 'uses' => 'CalendarioTurmaController@grid']);
                    Route::get('gridCalendario/{idTurmaDisciplina}', ['as' => 'grid', 'uses' => 'CalendarioTurmaController@gridCalendario']);
                    Route::get('disciplinas/{idTurma}', ['as' => 'grid', 'uses' => 'CalendarioTurmaController@disciplinasOfCurriculo']);
                    Route::post('store', ['as' => 'store', 'uses' => 'CalendarioTurmaController@store']);
                    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CalendarioTurmaController@edit']);
                    Route::post('update/{id}', ['as' => 'update', 'uses' => 'CalendarioTurmaController@update']);
                    Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'CalendarioTurmaController@delete']);
                    Route::post('incluir', ['as' => 'incluir', 'uses' => 'CalendarioTurmaController@incluirDisciplina']);
                    Route::post('remover-disciplina', ['as' => 'removerDisciplina', 'uses' => 'CalendarioTurmaController@removerDisciplina']);
                });

            });

        });

        //Rotas para graduação
        Route::group(['prefix' => 'graduacao', 'middleware' => 'auth', 'as' => 'graduacao.'], function () {
            Route::group(['prefix' => 'aluno', 'as' => 'aluno.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\AlunoController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\AlunoController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\AlunoController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\AlunoController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\AlunoController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\AlunoController@update']);
                Route::get('contrato/{id}', ['as' => 'contrato', 'uses' => 'Graduacao\AlunoController@contrato']);

                // Histórico do aluno
                Route::group(['prefix' => 'historico', 'as' => 'historico.'], function () {
                    Route::get('grid/{idAluno}', ['as' => 'grid', 'uses' => 'Graduacao\HistoricoAlunoController@gridHistorico']);
                    Route::post('getLoadFields', ['as' => 'getLoadFields', 'uses' => 'Graduacao\HistoricoAlunoController@getLoadFields']);
                    Route::post('save/{idAluno}', ['as' => 'save', 'uses' => 'Graduacao\HistoricoAlunoController@saveHistorico']);
                    Route::post('delete/{idAlunoSemestre}', ['as' => 'save', 'uses' => 'Graduacao\HistoricoAlunoController@deleteHistorico']);

                    // Situações do histórico
                    Route::group(['prefix' => 'situacao', 'as' => 'situacao.'], function () {
                        Route::get('grid/{idAlunoSemestre}', ['as' => 'grid', 'uses' => 'Graduacao\HistoricoAlunoController@gridSituacao']);
                        Route::post('delete/{idAlunoSituacao}', ['as' => 'save', 'uses' => 'Graduacao\HistoricoAlunoController@deleteSituacao']);
                    });
                });
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
                Route::post('getTurnosByCurso', ['as' => 'getTurnosByCurso', 'uses' => 'Graduacao\CursoController@getTurnosByCurso']);

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

                Route::group(['prefix' => 'disciplina', 'as' => 'disciplina.'], function () {
                    Route::get('get/{idDisciplina}', ['as' => 'edit', 'uses' => 'Graduacao\CurriculoController@getDisciplina']);
                    Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\CurriculoController@disciplinaStore']);
                    Route::post('delete', ['as' => 'delete', 'uses' => 'Graduacao\CurriculoController@disciplinaDelete']);
                    Route::get('edit/{idDisciplina}/{idCurriculo}', ['as' => 'edit', 'uses' => 'Graduacao\CurriculoController@disciplinaEdit']);
                    Route::post('update/{idDisciplina}/{idCurriculo}', ['as' => 'update', 'uses' => 'Graduacao\CurriculoController@disciplinaUpdate']);
                });

            });

            Route::group(['prefix' => 'turma', 'as' => 'turma.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\TurmaController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\TurmaController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\TurmaController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\TurmaController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\TurmaController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\TurmaController@update']);

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
//                    Route::get('disciplinas/{idTurma}', ['as' => 'grid', 'uses' => 'CalendarioTurmaController@disciplinasOfCurriculo']);
//                    Route::post('store', ['as' => 'store', 'uses' => 'CalendarioTurmaController@store']);
//                    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CalendarioTurmaController@edit']);
//                    Route::post('update/{id}', ['as' => 'update', 'uses' => 'CalendarioTurmaController@update']);
//                    Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'CalendarioTurmaController@delete']);
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
        });

        Route::group(['prefix' => 'banco', 'as' => 'banco.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'BancoController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'BancoController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'BancoController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'BancoController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'BancoController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'BancoController@update']);
        });

        Route::group(['prefix' => 'tipoVencimento', 'as' => 'tipoVencimento.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'TipoVencimentoController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'TipoVencimentoController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'TipoVencimentoController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'TipoVencimentoController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TipoVencimentoController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'TipoVencimentoController@update']);
        });

        Route::group(['prefix' => 'taxa', 'as' => 'taxa.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'TaxaController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'TaxaController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'TaxaController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'TaxaController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TaxaController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'TaxaController@update']);
            Route::post('getTaxas', ['as' => 'getTaxas', 'uses' => 'TaxaController@getTaxas']);
        });

        Route::group(['prefix' => 'vestibular', 'as' => 'vestibular.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'Graduacao\VestibularController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'Graduacao\VestibularController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'Graduacao\VestibularController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'Graduacao\VestibularController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibularController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'Graduacao\VestibularController@update']);
            Route::get('delete/{id}', ['as' => 'edit', 'uses' => 'Graduacao\VestibularController@delete']);

            Route::group(['prefix' => 'relatorios', 'as' => 'relatorios.'], function () {
                Route::get('relatorio1', ['as' => 'relatorio1', 'uses' => 'Graduacao\VestibularController@relatorio1']);
                Route::get('relatorio2', ['as' => 'relatorio2', 'uses' => 'Graduacao\VestibularController@relatorio2']);
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

            Route::get('indexExemplar', ['as' => 'indexExemplar', 'uses' => 'Biblioteca\ExemplarController@index']);
            Route::get('createExemplar', ['as' => 'createExemplar', 'uses' => 'Biblioteca\ExemplarController@create']);
            Route::get('gridExemplar', ['as' => 'gridExemplar', 'uses' => 'Biblioteca\ExemplarController@grid']);
            Route::get('editExemplar/{id}', ['as' => 'editExemplar', 'uses' => 'Biblioteca\ExemplarController@edit']);
            Route::post('storeExemplar', ['as' => 'storeExemplar', 'uses' => 'Biblioteca\ExemplarController@store']);
            Route::post('updateExemplar/{id}', ['as' => 'updateExemplar', 'uses' => 'Biblioteca\ExemplarController@update']);
            Route::get('deleteExemplar/{id}', ['as' => 'deleteExemplar', 'uses' => 'Biblioteca\ExemplarController@delete']);

            Route::get('dashboardBliblioteca', ['as' => 'dashboardBliblioteca', 'uses' => 'DashboardController@dashboardBliblioteca']);

            
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
            Route::get('confirmarDevolucao/{id}', ['as' => 'confirmarDevolucao', 'uses' => 'Biblioteca\EmprestarController@confirmarDevolucao']);
            Route::get('renovacao/{id}', ['as' => 'renovacao', 'uses' => 'Biblioteca\EmprestarController@renovacao']);


            Route::get('indexReserva', ['as' => 'indexReserva', 'uses' => 'Biblioteca\ReservaController@index']);
            Route::get('gridReserva', ['as' => 'gridReserva', 'uses' => 'Biblioteca\ReservaController@grid']);
            Route::post('storeReserva', ['as' => 'storeReserva', 'uses' => 'Biblioteca\ReservaController@store']);
            Route::get('reservados', ['as' => 'reservados', 'uses' => 'Biblioteca\ReservaController@reservados']);
            Route::get('gridReservados', ['as' => 'gridReservados', 'uses' => 'Biblioteca\ReservaController@gridReservados']);
            Route::post('saveEmprestimo', ['as' => 'saveEmprestimo', 'uses' => 'Biblioteca\ReservaController@saveEmprestimo']);
            
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
            Route::post('search', ['as' => 'search', 'uses' => 'UtilController@search']);
            Route::post('select2', ['as' => 'select2', 'uses' => 'UtilController@queryByselect2']);
            Route::post('select2Obra', ['as' => 'select2Obra', 'uses' => 'UtilController@queryByselect2Obra']);
            Route::post('select2personalizado', ['as' => 'select2personalizado', 'uses' => 'UtilController@queryByselect2Personalizado']);
        });
    });

    Route::get('indexConsulta', ['as' => 'indexConsulta', 'uses' => 'Biblioteca\ConsultaController@index']);
    Route::post('seachSimple', ['as' => 'seachSimple', 'uses' => 'Biblioteca\ConsultaController@seachSimple']);
    Route::get('seachSimplePage', ['as' => 'seachSimplePage', 'uses' => 'Biblioteca\ConsultaController@seachSimplePage']);
    Route::get('seachDetalhe/exemplar/{id}', ['as' => 'seachDetalhe', 'uses' => 'Biblioteca\ConsultaController@seachDetalhe']);
    Route::get('meusEmprestimos', ['as' => 'meusEmprestimos', 'uses' => 'Biblioteca\ConsultaController@meusEmprestimos']);
});
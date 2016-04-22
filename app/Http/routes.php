<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    Route::group(['prefix' => 'seracademico', 'middleware' => 'auth', 'as' => 'seracademico.'], function () {
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
            });

            Route::group(['prefix' => 'curso', 'as' => 'curso.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'CursoController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'CursoController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'CursoController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'CursoController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CursoController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'CursoController@update']);
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
                    Route::post('store', ['as' => 'store', 'uses' => 'CalendarioTurmaController@store']);
                    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CalendarioTurmaController@edit']);
                    Route::post('update/{id}', ['as' => 'update', 'uses' => 'CalendarioTurmaController@update']);
                    Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'CalendarioTurmaController@delete']);
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

        Route::group(['prefix' => 'biblioteca', 'as' => 'biblioteca.'], function () {
            Route::get('indexResponsavel', ['as' => 'indexResponsavel', 'uses' => 'ResponsavelController@index']);
            Route::get('createResponsavel', ['as' => 'createResponsavel', 'uses' => 'ResponsavelController@create']);
            Route::get('gridResponsavel', ['as' => 'gridResponsavel', 'uses' => 'ResponsavelController@grid']);
            Route::get('editResponsavel/{id}', ['as' => 'editResponsavel', 'uses' => 'ResponsavelController@edit']);
            Route::post('storeResponsavel', ['as' => 'storeResponsavel', 'uses' => 'ResponsavelController@store']);
            Route::post('updateResponsavel/{id}', ['as' => 'updateResponsavel', 'uses' => 'ResponsavelController@update']);

            Route::get('indexEditora', ['as' => 'indexEditora', 'uses' => 'EditoraController@index']);
            Route::get('createEditora', ['as' => 'createEditora', 'uses' => 'EditoraController@create']);
            Route::get('gridEditora', ['as' => 'gridEditora', 'uses' => 'EditoraController@grid']);
            Route::get('editEditora/{id}', ['as' => 'editEditora', 'uses' => 'EditoraController@edit']);
            Route::post('storeEditora', ['as' => 'storeEditora', 'uses' => 'EditoraController@store']);
            Route::post('updateEditora/{id}', ['as' => 'updateEditora', 'uses' => 'EditoraController@update']);

            Route::get('indexAcervo', ['as' => 'indexAcervo', 'uses' => 'ArcevoController@index']);
            Route::get('createAcervo', ['as' => 'createAcervo', 'uses' => 'ArcevoController@create']);
            Route::get('gridAcervo', ['as' => 'gridAcervo', 'uses' => 'ArcevoController@grid']);
            Route::get('editAcervo/{id}', ['as' => 'editAcervo', 'uses' => 'ArcevoController@edit']);
            Route::post('storeAcervo', ['as' => 'storeAcervo', 'uses' => 'ArcevoController@store']);
            Route::post('updateAcervo/{id}', ['as' => 'updateAcervo', 'uses' => 'ArcevoController@update']);

            Route::get('indexExemplar', ['as' => 'indexExemplar', 'uses' => 'ExemplarController@index']);
            Route::get('createExemplar', ['as' => 'createExemplar', 'uses' => 'ExemplarController@create']);
            Route::get('gridExemplar', ['as' => 'gridExemplar', 'uses' => 'ExemplarController@grid']);
            Route::get('editExemplar/{id}', ['as' => 'editExemplar', 'uses' => 'ExemplarController@edit']);
            Route::post('storeExemplar', ['as' => 'storeExemplar', 'uses' => 'ExemplarController@store']);
            Route::post('updateExemplar/{id}', ['as' => 'updateExemplar', 'uses' => 'ExemplarController@update']);
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
        });
    });
});
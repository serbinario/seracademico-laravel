<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use DB;

class UtilController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        try {
            #recuperando os dados da requisição
            $table = $request->get('table');
            $filed = $request->get('field_search');
            $value = $request->get('value_search');

            #Validando os parametros
            if($table == null || $filed == null || $value == null) {
                throw new \Exception('Parametros inválidos');
            }

            #executando a consulta e retornando os dados
            return DB::table($table)->select('*')->orderBy('nome', 'asc')->where($filed, $value)->get();
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function queryByselect2(Request $request)
    {
        try {
            #variável de retorno
            $result = array();

            #recuperando os dados da requisição
            $searchValue = $request->get('search');
            $tableName   = $request->get('tableName');
            $fieldName   = $request->get('fieldName');
            $pageValue   = $request->get('page');
            $fieldWhere  = $request->get('fieldWhere');
            $valueWhere  = $request->get('valueWhere');
            $columnSelect = $request->get('columnSelect');

            //consulta para not in que precisarão de outra tabela para recuperar os dados
            $tableNotIn     = $request->get('tableNotIn');
            $columnNotWhere = $request->get('columnNotWhere');
            $culmnNotGet    = $request->get('culmnNotGet');
            $columnWhere    = $request->get('columnWhere');
            $valueNotWhere  = $request->get('valueNotWhere');

//            #Validando os parametros
//            if($searchValue == null || $tableName == null || $fieldName == null || $pageValue == null) {
//                throw new \Exception('Parametros inválidos');
//            }

            if(isset($columnSelect) && $columnSelect != null) {
                #preparando a consulta
                $qb = DB::table($tableName)->select('id', $columnSelect);
                $qb->skip($pageValue);
                $qb->take(10);
                $qb->orderBy($columnSelect, 'asc');
                $qb->where($fieldName,'like', "%$searchValue%");
            } else {
                #preparando a consulta
                $qb = DB::table($tableName)->select('id', $fieldName);
                $qb->skip($pageValue);
                $qb->take(10);
                $qb->orderBy($fieldName, 'asc');
                $qb->where($fieldName,'like', "%$searchValue%");
            }

            #Validando os campos de where
            if($fieldWhere != null && $valueWhere != null) {
                $qb->where($fieldWhere, "$valueWhere");
            }

            #Fazendo validações not in
            if($tableNotIn != null && $columnNotWhere != null && $culmnNotGet != null) {
                $dadosNoIn = \DB::table($tableNotIn)->distinct()->select($culmnNotGet)->where($columnWhere, "$valueNotWhere")->get();

                #Tratando o retorno dos dados not in
                $arrayId   = [];
                foreach ($dadosNoIn as $rowNotIN) {
                   $arrayId[] =  $rowNotIN->$culmnNotGet;
               }

               $qb->whereNotIn($columnNotWhere, $arrayId);
           }

            #executando a consulta e recuperando os dados
           $resultTotal = $qb->get();

           $pageValue = $pageValue == 1 ? 0 : ($pageValue * 5) - 5;

           $qb->skip($pageValue);
           $qb->take(100);

           $resultItems = $qb->get();

           if(isset($columnSelect) && $columnSelect != null) {
                #criando o array de retorno
            foreach($resultItems as $item) {
                $result[] = [
                    "id" => $item->id,
                    "text" => $item->$columnSelect
                ];
            }
        } else {
                #criando o array de retorno
            foreach($resultItems as $item) {
                $result[] = [
                    "id" => $item->id,
                    "text" => $item->$fieldName
                ];
            }
        }

        $resultRetorno = [
            'data' => $result,
            'more' => ($pageValue + 5) < count($resultTotal)
        ];

            #retorno
        return $resultRetorno;
    } catch (\Throwable $e) {
        return \Illuminate\Support\Facades\Response::json([
            'error' => $e->getMessage()
        ]);
    }
}

    /**
     * @param Request $request
     * @return mixed
     */
    public function queryByselect2Personalizado(Request $request)
    {
        try {
            #variável de retorno
            $result = array();

            #recuperando os dados da requisição
            $searchValue = $request->get('search');
            $tableName   = $request->get('tableName');
            $fieldName   = $request->get('fieldName');
            $pageValue   = $request->get('page');
            $fieldWhere  = $request->get('fieldWhere');
            $valueWhere  = $request->get('valueWhere');
            $columnSelect = $request->get('columnSelect');

            //consulta para not in que precisarão de outra tabela para recuperar os dados
            $tableNotIn     = $request->get('tableNotIn');
            $columnNotWhere = $request->get('columnNotWhere');
            $culmnNotGet    = $request->get('culmnNotGet');
            $columnWhere    = $request->get('columnWhere');
            $valueNotWhere  = $request->get('valueNotWhere');

//            #Validando os parametros
//            if($searchValue == null || $tableName == null || $fieldName == null || $pageValue == null) {
//                throw new \Exception('Parametros inválidos');
//            }

            if(isset($columnSelect) && $columnSelect != null) {
                #preparando a consulta
                $qb = DB::table($tableName)->select('id', $columnSelect, 'sobrenome');
                $qb->skip($pageValue);
                $qb->take(10);
                $qb->orderBy($columnSelect, 'asc');
                $qb->where($fieldName,'like', "%$searchValue%");
                $qb->orWhere('sobrenome','like', "%$searchValue%");
            } else {
                #preparando a consulta
                $qb = DB::table($tableName)->select('id', 'nome', 'sobrenome');
                $qb->skip($pageValue);
                $qb->take(10);
                $qb->orderBy('nome', 'asc');
                $qb->where($fieldName,'like', "%$searchValue%");
                $qb->orWhere('sobrenome','like', "%$searchValue%");
            }

            #Validando os campos de where
            if($fieldWhere != null && $valueWhere != null) {
                $qb->where($fieldWhere, "$valueWhere");
            }

            #Fazendo validações not in
            if($tableNotIn != null && $columnNotWhere != null && $culmnNotGet != null) {
                $dadosNoIn = \DB::table($tableNotIn)->distinct()->select($culmnNotGet)->where($columnWhere, "$valueNotWhere")->get();

                #Tratando o retorno dos dados not in
                $arrayId   = [];
                foreach ($dadosNoIn as $rowNotIN) {
                    $arrayId[] =  $rowNotIN->disciplina_id;
                }

                $qb->whereNotIn($columnNotWhere, $arrayId);
            }

            #executando a consulta e recuperando os dados
            $resultTotal = $qb->get();

            $pageValue = $pageValue == 1 ? 0 : ($pageValue * 5) - 5;

            $qb->skip($pageValue);
            $qb->take(100);

            $resultItems = $qb->get();

            if(isset($columnSelect) && $columnSelect != null) {
                #criando o array de retorno
                foreach($resultItems as $item) {
                    $result[] = [
                        "id" => $item->id,
                        "name" => $item->sobrenome.', '.$item->$columnSelect,
                    ];
                }
            } else {
                #criando o array de retorno
                foreach($resultItems as $item) {
                    $result[] = [
                        "id" => $item->id,
                        "name" => $item->sobrenome.', '.$item->nome,
                    ];
                }
            }

            $resultRetorno = [
                'data' => $result,
                'more' => ($pageValue + 5) < count($resultTotal)
            ];

            #retorno
            return $resultRetorno;
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function queryByselect2Obra(Request $request)
    {
        try {
            #variável de retorno
            $result = array();

            #recuperando os dados da requisição
            $searchValue = $request->get('search');
            $tableName   = $request->get('tableName');
            $fieldName   = $request->get('fieldName');
            $pageValue   = $request->get('page');
            $fieldWhere  = $request->get('fieldWhere');
            $valueWhere  = $request->get('valueWhere');
            $columnSelect = $request->get('columnSelect');

            //consulta para not in que precisarão de outra tabela para recuperar os dados
            $tableNotIn     = $request->get('tableNotIn');
            $columnNotWhere = $request->get('columnNotWhere');
            $culmnNotGet    = $request->get('culmnNotGet');
            $columnWhere    = $request->get('columnWhere');
            $valueNotWhere  = $request->get('valueNotWhere');

//            #Validando os parametros
//            if($searchValue == null || $tableName == null || $fieldName == null || $pageValue == null) {
//                throw new \Exception('Parametros inválidos');
//            }

            #preparando a consulta
            $qb = DB::table($tableName)->select([
                'bib_arcevos.id as id',
                'bib_arcevos.'.$columnSelect . ' as ' . $columnSelect,
                'bib_arcevos.subtitulo as subtitulo',
                \DB::raw('CONCAT (responsaveis.sobrenome, ", ", responsaveis.nome) as autor')
            ]);
            $qb->leftJoin(\DB::raw('(SELECT arcevos_id, id, responsaveis_id FROM primeira_entrada GROUP BY arcevos_id)entrada'), function ($join) {
                $join->on('entrada.arcevos_id', '=', 'bib_arcevos.id');
            });
            $qb->leftJoin('responsaveis', 'responsaveis.id', '=', 'entrada.responsaveis_id');
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy($columnSelect, 'asc');
            $qb->where($fieldName,'like', "%$searchValue%");

            #Validando os campos de where
            if($fieldWhere != null && $valueWhere != null) {
                $qb->where($fieldWhere, "$valueWhere");
            }

            #Fazendo validações not in
            if($tableNotIn != null && $columnNotWhere != null && $culmnNotGet != null) {
                $dadosNoIn = \DB::table($tableNotIn)->distinct()->select($culmnNotGet)->where($columnWhere, "$valueNotWhere")->get();

                #Tratando o retorno dos dados not in
                $arrayId   = [];
                foreach ($dadosNoIn as $rowNotIN) {
                    $arrayId[] =  $rowNotIN->disciplina_id;
                }

                $qb->whereNotIn($columnNotWhere, $arrayId);
            }

            #executando a consulta e recuperando os dados
            $resultTotal = $qb->get();

            $pageValue = $pageValue == 1 ? 0 : ($pageValue * 5) - 5;

            $qb->skip($pageValue);
            $qb->take(100);

            $resultItems = $qb->get();

            #criando o array de retorno
            foreach($resultItems as $item) {
                $result[] = [
                    "id" => $item->id,
                    "titulo" => $item->$columnSelect,
                    'subtitulo' => $item->subtitulo,
                    'autor' => $item->autor,
                ];
            }

            $resultRetorno = [
                'data' => $result,
                'more' => ($pageValue + 5) < count($resultTotal)
            ];

            #retorno
            return $resultRetorno;
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function queryByselect2Pessoa(Request $request)
    {
        try {
            #variável de retorno
            $result = array();

            #recuperando os dados da requisição
            $searchValue = $request->get('search');
            $tableName   = $request->get('tableName');
            $fieldName   = $request->get('fieldName');
            $pageValue   = $request->get('page');
            $fieldWhere  = $request->get('fieldWhere');
            $valueWhere  = $request->get('valueWhere');
            $parametro   = $request->get('parametro');

            //consulta para not in que precisarão de outra tabela para recuperar os dados
            $tableNotIn     = $request->get('tableNotIn');
            $columnNotWhere = $request->get('columnNotWhere');
            $culmnNotGet    = $request->get('culmnNotGet');
            $columnWhere    = $request->get('columnWhere');
            $valueNotWhere  = $request->get('valueNotWhere');

           #Validando os parametros
           /*if($searchValue == null || $tableName == null || $fieldName == null || $pageValue == null) {
                throw new \Exception('Parametros inválidos');
            }*/

            #preparando a consulta
            /*$qb = DB::table($tableName)->select('id', 'nome');
            $qb->leftJoin(\DB::raw('fac_alunos'), function ($join) {
                $join->on('fac_alunos.pessoa_id', '=', 'pessoas.id')
                ;
            });
            $qb->leftJoin(\DB::raw('pos_alunos'), function ($join) {
                $join->on('pos_alunos.pessoa_id', '=', 'pessoas.id')
                ;
            });*/

            #preparando a consulta
            $qb = DB::table($tableName);
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy('nome', 'asc');
            $qb->where('pessoas.' . $fieldName, 'like', "%$searchValue%");

            # tratando as consulta de acordo com o tipo de pessoa
            if($parametro == '1') {
                $qb = $this->whereGraduacao($qb);
                $qb->join(\DB::raw('fac_alunos'), function ($join) {
                    $join->on('fac_alunos.pessoa_id', '=', 'pessoas.id')
                    ;
                });
                $qb->orWhere('fac_alunos.matricula', 'like', "%$searchValue%");
                $qb->select('pessoas.id as pessoa_id',
                    'pessoas.nome as nome', 'pessoas.cpf as cpf',
                    'fac_alunos.id as id_graduacao', 'fac_alunos.matricula as matricula');
            } else if ($parametro == '2' || $parametro == '3' || $parametro == '4') {
                $qb = $this->wherePosMestrado($parametro, $qb);
                $qb->join(\DB::raw('pos_alunos'), function ($join) {
                    $join->on('pos_alunos.pessoa_id', '=', 'pessoas.id')
                    ;
                });
                $qb->orWhere('pos_alunos.matricula', 'like', "%$searchValue%");
                $qb->select('pessoas.id as pessoa_id',
                    'pessoas.nome as nome', 'pessoas.cpf as cpf', 'pos_alunos.matricula as matricula',
                    'pos_alunos.id as id_pos');
            } else if ($parametro == '5') {
                $qb = $this->whereProfessor($qb);
                $qb->join(\DB::raw('fac_professores'), function ($join) {
                    $join->on('fac_professores.pessoa_id', '=', 'pessoas.id')
                    ;
                });
                $qb->select('pessoas.id as pessoa_id',
                    'pessoas.nome as nome', 'pessoas.cpf as cpf',
                    'fac_professores.id as id_professor');
            }


            #Validando os campos de where
            if($fieldWhere != null && $valueWhere != null) {
                $qb->where($fieldWhere, "$valueWhere");
            }

            #Fazendo validações not in
            if($tableNotIn != null && $columnNotWhere != null && $culmnNotGet != null) {
                $dadosNoIn = \DB::table($tableNotIn)->distinct()->select($culmnNotGet)->where($columnWhere, "$valueNotWhere")->get();

                #Tratando o retorno dos dados not in
                $arrayId   = [];
                foreach ($dadosNoIn as $rowNotIN) {
                    $arrayId[] =  $rowNotIN->$culmnNotGet;
                }

                $qb->whereNotIn($columnNotWhere, $arrayId);
            }

            #executando a consulta e recuperando os dados
            $resultTotal = $qb->get();


            $pageValue = $pageValue == 1 ? 0 : ($pageValue * 5) - 5;

            $qb->skip($pageValue);
            $qb->take(100);

            $resultItems = $qb->get();
            #criando o array de retorno
            foreach ($resultItems as $item) {
                if($parametro == '1') {
                    $result[] = [
                        "id" => $item->pessoa_id,
                        "text" => $item->nome . " CPF. " . $item->cpf . " MAT. " . $item->matricula,
                        "matricula" => $item->matricula,
                        "cpf" => $item->cpf,
                        'id_graduacao' => $item->id_graduacao,
                    ];
                } else if ($parametro == '2' || $parametro == '3' || $parametro == '4') {
                    $result[] = [
                        "id" => $item->pessoa_id,
                        "text" => $item->nome . " CPF. " . $item->cpf . " MAT. " . $item->matricula,
                        "matricula" => $item->matricula,
                        "cpf" => $item->cpf,
                        'id_pos' => $item->id_pos
                    ];
                } else if ($parametro == '5') {
                    $result[] = [
                        "id" => $item->pessoa_id,
                        "text" => $item->nome,
                        'id_professor' => $item->id_professor
                    ];
                } else {
                    $result[] = [
                        "id" => $item->pessoa_id,
                        "text" => $item->nome,
                    ];
                }
            }

            $resultRetorno = [
                'data' => $result,
                'more' => ($pageValue + 5) < count($resultTotal)
            ];

            #retorno
            return $resultRetorno;
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Where de graduação
     */
    private function whereGraduacao($query)
    {
        $query->whereExists(function ($query) {
            $query->select(\DB::raw("fac_alunos.id", "fac_alunos.matricula"))
            ->from('fac_alunos')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.aluno_id', '=', 'fac_alunos.id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->join('fac_alunos_situacoes', function ($join) {
                $join->on(
                    'fac_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_secundaria.id FROM fac_alunos_situacoes as situacao_secundaria 
                        where situacao_secundaria.aluno_semestre_id = fac_alunos_semestres.id ORDER BY situacao_secundaria.id DESC LIMIT 1)')
                );
            })
            ->join('fac_situacao', 'fac_situacao.id', '=', 'fac_alunos_situacoes.situacao_id')
            ->whereRaw('fac_alunos.pessoa_id = pessoas.id')
            ->where('fac_situacao.id', '=', '2');
        });

        return $query;
    }

    /**
     * Consulra para alunos de pós-graduação e mestrado
     */
    private function wherePosMestrado($tipo, $query)
    {
        $query->whereExists(function ($query) {
            $query->select(
                \DB::raw("pos_alunos.id"))
            ->from('pos_alunos')
            ->leftJoin('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('pos_alunos_turmas', function ($join) {
                $join->on(
                    'pos_alunos_turmas.id', '=',
                    \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('pos_alunos_situacoes', function ($join) {
                $join->on(
                    'pos_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                        where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->leftJoin('fac_situacao', 'fac_situacao.id', '=', 'pos_alunos_situacoes.situacao_id')
            ->leftJoin('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
            ->leftJoin('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                //->where('pos_alunos.tipo_aluno_id', null)
            ->whereRaw('pos_alunos.pessoa_id = pessoas.id');
        });

        /*if($tipo == '2') {
            $query->where('pos_alunos.tipo_aluno_id', 3);
        } else if ($tipo == '3') {
            $query->where('pos_alunos.tipo_aluno_id', 3);
        }*/

        return $query;
    }

    /**
     * Consulta para professores
     */
    private function whereProfessor($query)
    {
        $query->whereExists(function ($query) {
            $query->select(\DB::raw("fac_professores.id"))
            ->from('fac_professores')
            ->join('pessoas', 'fac_professores.pessoa_id', '=', 'pessoas.id');
                //->whereRaw('fac_professores.pessoa_id = pessoas.id');
               // ->join('tipo_nivel_sistema', 'fac_professores.tipo_nivel_sistema_id', '=', 'tipo_nivel_sistema.id');
                //->where('tipo_nivel_sistema.id', '=' , 1)
                //->orWhere('fac_professores.pos_e_graduacao', '=' , 1)
                //->where('fac_professores.pessoa_id = pessoas.id');
        });

        return $query;
    }

    public function autoPreencherAssuntoCdd(Request $request){

        if(isset($request->cdd)){
            $query = DB::table('bib_arcevos')->select('assunto')->where('cdd','=', "$request->cdd")->first();
        }else{
            $query = DB::table('bib_arcevos')->select('cdd')->where('assunto','=', "$request->assunto")->first();
        }


           return \Illuminate\Support\Facades\Response::json($query);

       } 

/*  public function autoPreencherCdd(Request $request){

        $query = DB::table('bib_arcevos')->select('cdd')->where('assunto','=', "$request->assunto")->first();



     return \Illuminate\Support\Facades\Response::json($query);

 } */

}

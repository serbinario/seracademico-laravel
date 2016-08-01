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
            return DB::table($table)->select('id', 'nome')->orderBy('nome', 'asc')->where($filed, $value)->get();
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
                $qb = DB::table($tableName)->select('id', 'nome');
                $qb->skip($pageValue);
                $qb->take(10);
                $qb->orderBy('nome', 'asc');
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
                        "text" => $item->nome
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
            $qb = DB::table($tableName)->select('id', 'nome');
            $qb->leftJoin(\DB::raw('fac_alunos'), function ($join) {
                $join->on('fac_alunos.pessoa_id', '=', 'pessoas.id')/*->where('fac_alunos.id', '!=', "")
                ->where('fac_alunos.situacao_id', '=', "2")*/
                ;
            });
            #preparando a consulta
            $qb = DB::table($tableName)->select('pessoas.id as pessoa_id', 'pessoas.nome as nome');
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy('nome', 'asc');
            $qb->where('pessoas.' . $fieldName, 'like', "%$searchValue%");
            $qb->whereExists(function ($query) {
                $query->select(\DB::raw("fac_alunos.id"))
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
                $result[] = [
                    "id" => $item->pessoa_id,
                    "text" => $item->nome
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
}

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

            //Consulta para not in que precisarão de outra tabela para recuperar os dados
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
                   $arrayId[] =  $rowNotIN->disciplina_id;
                }

                $qb->whereNotIn($columnNotWhere, $arrayId);
            }

            #executando a consulta e recuperando os dados
            $resultTotal = $qb->get();

            $pageValue = $pageValue == 1 ? 0 : ($pageValue * 5) - 5;

            $qb->skip($pageValue);
            $qb->take(5);

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

            //Consulta para not in que precisarão de outra tabela para recuperar os dados
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
            $qb->take(5);

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

            //Consulta para not in que precisarão de outra tabela para recuperar os dados
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
            $qb = DB::table($tableName)->select('id', $columnSelect, 'subtitulo');
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
            $qb->take(5);

            $resultItems = $qb->get();

            #criando o array de retorno
            foreach($resultItems as $item) {
                $result[] = [
                    "id" => $item->id,
                    "titulo" => $item->$columnSelect,
                    'subtitulo' => $item->subtitulo,
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

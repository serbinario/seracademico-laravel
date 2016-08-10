<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use DB;

class Select2Controller extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function simpleQuery(Request $request)
    {
        try {
            #variável de retorno
            $result = array();

            #recuperando os dados da requisição
            $searchValue = $request->get('search');
            $tableName   = $request->get('tableName');
            $displayFieldName  = $request->get('displayfieldName');
            $searchFieldsNames = $request->get('searchFieldsNames');
            $pageValue   = $request->get('page');

            #preparando a consulta
            $qb = DB::table($tableName)->select('id', $displayFieldName);
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy($displayFieldName, 'asc');

            # Percorrendo os campos para pesquisar
            foreach ($searchFieldsNames as $field) {
                $qb->orWhere($field,'like', "%$searchValue%");
            }

            #executando a consulta e recuperando os dados
            $resultTotal = $qb->get();

            #Calculando a paginação
            $pageValue = $pageValue == 1 ? 0 : ($pageValue * 5) - 5;
            $qb->skip($pageValue);
            $qb->take(100);

            # Recuperando os itens paginados
            $resultItems = $qb->get();

            #criando o array de retorno
            foreach($resultItems as $item) {
                $result[] = [
                    "id" => $item->id,
                    "text" => $item->$displayFieldName
                ];
            }

            # Array de retorno
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

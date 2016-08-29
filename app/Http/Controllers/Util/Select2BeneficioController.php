<?php

namespace Seracademico\Http\Controllers\Util;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use DB;

class Select2BeneficioController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function createQuery(Request $request)
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
            $taxas = $request->get('taxas');

            #preparando a consulta
            $qb = DB::table($tableName)->select('id', $displayFieldName);
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy($displayFieldName, 'asc');

            # Vendo se foi informado alguma taxa
            if(count($taxas) > 0) {
                $qb->whereNotIn('id', $taxas);
            }

            # Percorrendo os campos para pesquisar
            $qb->where(function ($query) use ($searchFieldsNames, $searchValue) {
                foreach ($searchFieldsNames as $field) {
                    $query->orWhere($field,'like', "%$searchValue%");
                }
            });

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



    /**
     * @param Request $request
     * @return mixed
     */
    public function editQuery(Request $request)
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
            $idBeneficio = $request->get('idBeneficio');
   
            #preparando a consulta
            $qb = DB::table($tableName)->select('id', $displayFieldName);
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy($displayFieldName, 'asc');
            $qb->whereNotIn('id', function ($query) use ($idBeneficio) {
                $query->from('fin_beneficios_taxas')
                    ->select('fin_beneficios_taxas.taxa_id')
                    ->where('fin_beneficios_taxas.beneficio_id', $idBeneficio)->get();
            });

            # Percorrendo os campos para pesquisar
            $qb->where(function ($query) use ($searchFieldsNames, $searchValue) {
                foreach ($searchFieldsNames as $field) {
                    $query->orWhere($field,'like', "%$searchValue%");
                }
            });

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

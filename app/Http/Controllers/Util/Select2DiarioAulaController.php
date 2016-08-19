<?php

namespace Seracademico\Http\Controllers\Util;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use DB;

class Select2DiarioAulaController extends Controller
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
            $conteudos = $request->get('conteudos');
            $idPlanoEnsino = $request->get('planoEnsinoId');

            #preparando a consulta
            $qb = DB::table($tableName)->select('id', $displayFieldName);
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy($displayFieldName, 'asc');
            $qb->where('plano_ensino_id', $idPlanoEnsino);

            # Vendo se foi informado alguma taxa
            if(count($conteudos) > 0) {
                $qb->whereNotIn('id', $conteudos);
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
            $idDiarioAula = $request->get('idDiarioAula');
            $idPlanoEnsino = $request->get('planoEnsinoId');
   
            #preparando a consulta
            $qb = DB::table($tableName)->select('id', $displayFieldName);
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy($displayFieldName, 'asc');
            $qb->where('plano_ensino_id', $idPlanoEnsino);
            $qb->whereNotIn('id', function ($query) use ($idDiarioAula) {
                $query->from('fac_diarios_aulas_conteudos_programaticos')
                    ->select('fac_diarios_aulas_conteudos_programaticos.conteudo_programatico_id')
                    ->where('fac_diarios_aulas_conteudos_programaticos.diario_aula_id', $idDiarioAula)->get();
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

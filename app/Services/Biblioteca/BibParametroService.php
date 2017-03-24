<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Repositories\Biblioteca\BibParametroRepository;
use Seracademico\Entities\Biblioteca\BibParametro;
//use Carbon\Carbon;

class BibParametroService
{
    /**
     * @var BibParametroRepository
     */
    private $repository;

    /**
     * @param BibParametroRepository $repository
     */
    public function __construct(BibParametroRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $bibParametro = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$bibParametro) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $bibParametro;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : BibParametro
    {
        #Salvando o registro pincipal
        $bibParametro =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$bibParametro) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $bibParametro;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : BibParametro
    {
        #Atualizando no banco de dados
        $bibParametro = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$bibParametro) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $bibParametro;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function storeDiasLetivosBiblioteca(array $data)
    {

        // Atualizando os parâmetros
        if(isset($data['dias_letivos']) && count($data['dias_letivos']) > 0) {
            foreach ($data['dias_letivos'] as $dias) {
                \DB::table('bib_dias_letivos_emprestimo')->where('id', $dias)->update(['ativo' => '1']);
            }
            \DB::table('bib_dias_letivos_emprestimo')->whereNotIn('id', $data['dias_letivos'])->update(['ativo' => '0']);
        } else {
            \DB::table('bib_dias_letivos_emprestimo')->update(['ativo' => '0']);
        }

        #Retorno
        return true;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
    {
         #Declarando variáveis de uso
         $result    = [];
         $expressao = [];

         #Criando e executando as consultas
         foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            if(count($expressao) > 1) {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
            } else {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::lists('nome', 'id');
            }

            # Limpando a expressão
            $expressao = [];
         }

         #retorno
         return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array &$data) : array
    {
         #tratando as datas
         //$data[''] = $data[''] ? Carbon::createFromFormat("d/m/Y", $data['']) : "";

         #retorno
         return $data;
    }

}
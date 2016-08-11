<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\ConteudoProgramatico;
use Seracademico\Repositories\Graduacao\ConteudoProgramaticoRepository;
use Seracademico\Repositories\Graduacao\PlanoEnsinoRepository;
use Seracademico\Entities\Graduacao\PlanoEnsino;
//use Carbon\Carbon;

class PlanoEnsinoService
{
    /**
     * @var PlanoEnsinoRepository
     */
    private $repository;

    /**
     * @var ConteudoProgramaticoRepository
     */
    private $conteudoProgramaticoRepository;

    /**
     * PlanoEnsinoService constructor.
     * @param PlanoEnsinoRepository $repository
     * @param ConteudoProgramaticoRepository $conteudoProgramaticoRepository
     */
    public function __construct(PlanoEnsinoRepository $repository, ConteudoProgramaticoRepository $conteudoProgramaticoRepository)
    {
        $this->repository = $repository;
        $this->conteudoProgramaticoRepository = $conteudoProgramaticoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $planoEnsino = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$planoEnsino) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $planoEnsino;
    }

    /**
     * @param array $data
     * @return PlanoEnsino
     * @throws \Exception
     */
    public function store(array $data) : PlanoEnsino
    {
        #Salvando o registro pincipal
        $planoEnsino =  $this->repository->create($data);

        # salvando os conteúdos programáticos
        $planoEnsino->conteudoProgramatico()->saveMany($this->tratamentoConteudosProgramaticos($data));

        #Verificando se foi criado no banco de dados
        if(!$planoEnsino) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $planoEnsino;
    }

    /**
     * @param array $data
     * @param int $id
     * @return PlanoEnsino
     * @throws \Exception
     */
    public function update(array $data, int $id) : PlanoEnsino
    {
        #Atualizando no banco de dados
        $planoEnsino = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$planoEnsino) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $planoEnsino;
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
     * @return array
     */
    public function tratamentoConteudosProgramaticos(array $data)
    {
        # Array de retorno
        $arrayResult = [];

        # Recuperado e removendo do array o conteúdo programático
        $conteudos = explode(',', $data['conteudo_programatico']);
        unset($data['conteudo_programatico']);

        # Criando o array de retorno
        foreach ($conteudos as $conteudo) {
            $arrayResult[] = new ConteudoProgramatico(['nome' => $conteudo]);
        }
 
        # Retorno
        return $arrayResult;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function storeConteudoProgramatico(array $data)
    {
        #Salvando o registro pincipal
        $conteudo =  $this->conteudoProgramaticoRepository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$conteudo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $conteudo;
    }


    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteConteudoProgramatico(int $id)
    {
        # Recuperando o registor on banco de dados
        $conteudo = $this->conteudoProgramaticoRepository->find($id);

        #Verificando se foi atualizado no banco de dados
        if(!$conteudo) {
            throw new \Exception('Conteúdo não encontrado!');
        }

        # Removendo do banco
        $this->conteudoProgramaticoRepository->delete($id);

        #Retorno
        return true;
    }
}
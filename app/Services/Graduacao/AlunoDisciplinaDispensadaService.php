<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\AlunoDisciplinaDispensadaRepository;
use Seracademico\Entities\Graduacao\AlunoDisciplinaDispensada;
use Seracademico\Repositories\Graduacao\AlunoRepository;

class AlunoDisciplinaDispensadaService
{
    /**
     * @var AlunoDisciplinaDispensadaRepository
     */
    private $repository;

    /**
     * @var
     */
    private $alunoRepository;

    /**
     * AlunoDisciplinaDispensadaService constructor.
     * @p ram AlunoRepository $alunoRepository
     */
    public function __construct(AlunoDisciplinaDispensadaRepository $repository, AlunoRepository $alunoRepository)
    {
        $this->repository = $repository;
        $this->alunoRepository = $alunoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $alunoDisciplinaDispensada = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('AlunoDisciplinaDispensada não encontrada!');
        }

        #retorno
        return $alunoDisciplinaDispensada;
    }

    /**
     * @param array $data
     * @return AlunoDisciplinaDispensada
     * @throws \Exception
     */
    public function store(array $data) : AlunoDisciplinaDispensada
    {
        # Validando a entrada
        if(!isset($data['disciplina_id']) && !isset($data['aluno_id'])
            && !isset($data['semestre_id']) && !isset($data['motivo'])) {
            throw new \Exception('O campo disciplina é obrigatório!');
        }

        # Tratamento
        $this->tratamentoCampos($data);
        
        # Recuperando o aluno
        $aluno = $this->alunoRepository->find($data['aluno_id']);
        $pivot = $aluno->semestres()->find($data['semestre_id'])->pivot;

        # Regra de negócio
        unset($data['aluno_id']);
        unset($data['semestre_id']);
        $data['aluno_semestre_id'] = $pivot->id;

        #Salvando o registro pincipal
        $alunoDisciplinaDispensada =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoDisciplinaDispensada;
    }

    /**
     * @param array $data
     * @param int $id
     * @return AlunoDisciplinaDispensada
     * @throws \Exception
     */
    public function update(array $data, int $id) : AlunoDisciplinaDispensada
    {
        # Validando a entrada
        if(!isset($data['disciplina_id']) && !isset($data['motivo'])) {
            throw new \Exception('O campo disciplina é obrigatório!');
        }

        # Tratamento
        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $alunoDisciplinaDispensada = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoDisciplinaDispensada;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Removendo o registro no banco de dados
        $alunoDisciplinaDispensada = $this->repository->find($id);

        # Verifiando se a AlunoDisciplinaDispensada foi recuperada
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('Dados não encontrados não encontrada!');
        }

        # Removendo o registro do banco de dados
        $this->repository->delete($id);

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
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $explodeKey2 = explode("_", $key2);

                    if ($explodeKey2[count($explodeKey2) -1] == "id" && $value2 == null ) {
                        $data[$key][$key2] = null;
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #Retorno
        return $data;
    }
}
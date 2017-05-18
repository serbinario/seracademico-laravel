<?php

namespace Seracademico\Services\Tecnico;

use Seracademico\Repositories\Tecnico\CurriculoRepository;
use Seracademico\Entities\Tecnico\Curriculo;
use Seracademico\Repositories\Tecnico\CursoRepository;
use Seracademico\Repositories\Tecnico\DisciplinaRepository;

class CurriculoService
{
    /**
     * @var CurriculoRepository
     */
    private $repository;

    /**
     * @var DisciplinaRepository
     */
    private $disciplinaRepository;

    /**
     * @param CurriculoRepository $repository
     * @param DisciplinaRepository $disciplinaRepository
     * @param CursoRepository $cursoRepository
     */
    public function __construct(CurriculoRepository $repository, DisciplinaRepository $disciplinaRepository)
    {
        $this->repository           = $repository;
        $this->disciplinaRepository = $disciplinaRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $curriculo = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$curriculo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $curriculo;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Curriculo
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 3;

        #Executando regras de negócios
        $this->tratamentoCurriculoAtivo($data);

        #Salvando o registro pincipal
        $curriculo =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$curriculo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curriculo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Curriculo
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 3;

        #Executando regras de negócios
        $this->tratamentoCurriculoAtivo($data);

        #Atualizando no banco de dados
        $curriculo = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$curriculo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curriculo;
    }

    /**
     * @param array $data
     * @return bool|\Exception
     */
    public function adicionarDisciplinas(array $data)
    {
        #Validando os parametros de entrada
        if(!isset($data['idCurriculo']) && !isset($data['idDisciplinas'])) {
            return new \Exception("Parâmetros inválidos");
        }

        #Recuperando a entidade
        $curriculo = $this->repository->find($data['idCurriculo']);

        #Percorrendo os id das disciplinas
        foreach($data['idDisciplinas'] as $id) {
            #Recuperando a entidade
            $disciplina = $this->disciplinaRepository->find($id);

            #Válidando a disciplina
            if(!$disciplina) {
                return new \Exception("Disciplina não existe");
            }

            #Adicionando a entidade principal
            $curriculo->disciplinas()->attach($disciplina->id);
        }

        #Salvando as adições
        $curriculo->save();

        #Retorno
        return true;
    }

    /**
     * @param array $data
     * @return bool|\Exception
     */
    public function removerDisciplina(array $data)
    {
        #Validando os parametros de entrada
        if(!isset($data['idCurriculo']) && !isset($data['idDisciplina'])) {
            return new \Exception("Parâmetros inválidos");
        }

        #Recuperando a entidade
        $curriculo = $this->repository->find($data['idCurriculo']);

        #Recuperando a entidade
        $disciplina = $this->disciplinaRepository->find($data['idDisciplina']);

        #Válidando a disciplina
        if(!$disciplina) {
            return new \Exception("Disciplina não existe");
        }

        #Adicionando a entidade principal
        $curriculo->disciplinas()->detach($disciplina->id);


        #Salvando as adições
        $curriculo->save();

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
    private function tratamentoCurriculoAtivo(array &$data): array
    {
        #Verificando se a condição é válida
        if($data['ativo'] == 1 && isset($data['curso_id'])) {
            #Recuperando o(s) currículo(s) ativo(s)
            $rows = $this->repository->getCurriculoAtivo($data['curso_id']);

            #Varrendo o array
            foreach($rows as $row) {
                $curriculo = $this->repository->find($row->id);

                $curriculo->ativo = 0;
                $curriculo->save();
            }
        }

        #retorno
        return $data;
    }
}
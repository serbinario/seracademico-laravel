<?php

namespace Seracademico\Services\Tecnico;

use Seracademico\Repositories\Tecnico\CursoRepository;
use Seracademico\Repositories\TurnoRepository;
use Seracademico\Repositories\Tecnico\InscricaoRepository;
use Seracademico\Entities\Tecnico\Inscricao;
use Seracademico\Facades\ParametroVestibularFacade;

class InscricaoService
{
    /**
     * @var InscricaoRepository
     */
    private $repository;

    /**
     * @var CursoRepository
     */
    private $cursoRepository;

    /**
     * @var TurnoRepository
     */
    private $turnoRepository;

    /**
     * @param InscricaoRepository $repository
     * @param CursoRepository $cursoRepository
     * @param TurnoRepository $turnoRepository
     */
    public function __construct(
        InscricaoRepository $repository,
        CursoRepository $cursoRepository,
        TurnoRepository $turnoRepository)
    {
        $this->repository        = $repository;
        $this->cursoRepository   = $cursoRepository;
        $this->turnoRepository   = $turnoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $vestibular = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$vestibular) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $vestibular;
    }

    /**
     * @param array $data
     * @return Inscricao
     * @throws \Exception
     */
    public function store(array $data) : Inscricao
    {
        # Regras de Negócios
        $this->tratamentoInscricaoAtivo($data);
        $this->tratamentoDataRanger($data);

        #Salvando o registro pincipal
        $vestibular =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$vestibular) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $vestibular;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Inscricao
     * @throws \Exception
     */
    public function update(array $data, int $id) : Inscricao
    {
        # Regras de Negócios
        $this->tratamentoInscricaoAtivo($data);
        $this->tratamentoDataRanger($data);

        #Atualizando no banco de dados
        $vestibular = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$vestibular) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $vestibular;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #Recuperando o registro no banco de dados
        $vestibular = $this->repository->find($id);

        #Verificando se foi atualizado no banco de dados
        if(!$vestibular) {
            throw new \Exception('Vestibular não existe!');
        }

        # Deletando o registro
        $this->repository->delete($vestibular->id);

        # retorno
        return true;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function tratamentoDataRanger(array &$data)
    {
        # Recuperando as datas e separado data_inicial e final
        $arrayData = explode('-', $data['data_ranger']);

        # Verificando as datas
        if(count($arrayData) !== 2) {
            throw new \Exception('Formato das datas inicial e final são inválidas.');
        }

        # Removendo o registro data_ranger
        unset($data['data_ranger']);

        # colocando as datas
        $data['data_inicio'] = trim($arrayData[0]);
        $data['data_fim']   = trim($arrayData[1]);

        # Retorno
        return true;
    }

    /**
 * @param array $data
 * @return mixed
 */
    private function tratamentoInscricaoAtivo(array &$data): array
    {
        #Verificando se a condição é válida
        if($data['ativo'] == 1) {
            #Recuperando o(s) vestibular(es) ativo(s)
            $rows = $this->repository->findWhere(['ativo' => 1]);

            #Varrendo o array
            foreach($rows as $row) {
                $vestibular = $this->repository->find($row->id);

                $vestibular->ativo = 0;
                $vestibular->save();
            }
        }

        #retorno
        return $data;
    }

    /**
     * @param array $models || Melhorar esse código
     * @return array
     */
    public function load(array $models, $ajax = false) : array
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

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 1) {
                    switch (count($expressao)) {
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
                }
            }

            # Limpando a expressão
            $expressao = [];
        }

        #retorno
        return $result;
    }


    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function storeCurso($data)
    {

        # Validando os dados
        if(!isset($data['arrayCursoId']) && !(count($data['arrayCursoId']) > 0) &&
            !isset($data['idInscricao']) && is_numeric($data['idInscricao'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objInscricao = $this->repository->find($data['idInscricao']);

        # Validando a existência dos objetos
        if(!$objInscricao) {
            throw new \Exception('Curso ou vestibular não existe!');
        }

        # adicionado os curso ao vestibular
        $objInscricao->cursos()->attach($data['arrayCursoId']);

        # Percorrendo todos os cursos cadastrados
        foreach ($data['arrayCursoId'] as $value) {
            $curso = $objInscricao->cursos()->find($value);
        }

        # Retono
        return true;
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function deleteCurso($data)
    {
        # Validando os dados
        if(!isset($data['idCurso']) && is_numeric($data['idCurso']) &&
            !isset($data['idInscricao']) && is_numeric($data['idInscricao'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objInscricao = $this->repository->find($data['idInscricao']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);

        # Validando a existência dos objetos
        if(!$objInscricao || !$objCurso) {
            throw new \Exception('Curso ou vestibular não existe!');
        }

        # removendo o curso do vestibular
        $objInscricao->cursos()->detach($objCurso->id);

        # Retono
        return true;
    }


    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function storeCursoTurno($data)
    {

        # Validando os dados
        if(!isset($data['idCurso']) && !is_numeric($data['idCurso']) &&
            !isset($data['idInscricao']) && is_numeric($data['idInscricao'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objInscricao = $this->repository->find($data['idInscricao']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);
        $objTurno      = $this->turnoRepository->find($data['turno_id']);

        # Deletando os indexs
        unset($data['idCurso'], $data['idInscricao'], $data['turno_id']);

        # Validando a existência dos objetos
        if(!$objInscricao && !$objCurso && !$objTurno) {
            throw new \Exception('Curso ou vestibular não existe!');
        }

        # adicionado os curso ao vestibular
        $pivot = $objInscricao->cursos()->find($objCurso->id)->pivot;
        $pivot->turnos()->attach($objTurno->id, $data);

        # Retono
        return true;
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function deleteCursoTurno($data)
    {
        # Validando os dados
        if(!isset($data['idCurso']) && is_numeric($data['idCurso']) &&
            !isset($data['idInscricao']) && is_numeric($data['idInscricao']) &&
            !isset($data['idTurno']) && is_numeric($data['idTurno'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objInscricao = $this->repository->find($data['idInscricao']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);
        $objTurno      = $this->turnoRepository->find($data['idTurno']);

        # Validando a existência dos objetos
        if(!$objInscricao || !$objCurso || !$objTurno) {
            throw new \Exception('vestibular, curso ou turno não existe!');
        }

        # removendo a matéria do curso de um vestibular
        $pivot = $objInscricao->cursos()->find($objCurso->id)->pivot;
        $pivot->turnos()->detach($objTurno->id);

        # Retono
        return true;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getByValidDate()
    {
        # Verificando se existe um vestibular ativo
        if(count(ParametroVestibularFacade::getAtivo()) == 0) {
            throw new \Exception('Não existe um vestibular ativo!');
        }

        # recuperando a data atual
        $now  = new \DateTime('now');

        # recuperando os vestibulares
        $rows = \DB::table('pos_incricoes')
            ->select('id')
            ->whereDate('data_inicio', '<=', $now->format('Y-m-d'))
            ->whereDate('data_fim', '>=', $now->format('Y-m-d'))
            ->get();
        
        # retorno
        return $rows;
    }
}
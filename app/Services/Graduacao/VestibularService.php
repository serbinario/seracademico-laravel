<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\CursoRepository;
use Seracademico\Repositories\Graduacao\MateriaRepository;
use Seracademico\Repositories\TurnoRepository;
use Seracademico\Repositories\Graduacao\VestibularRepository;
use Seracademico\Entities\Graduacao\Vestibular;

class VestibularService
{
    /**
     * @var VestibularRepository
     */
    private $repository;

    /**
     * @var CursoRepository
     */
    private $cursoRepository;

    /**
     * @var MateriaRepository
     */
    private $materiaRepository;

    /**
     * @var TurnoRepository
     */
    private $turnoRepository;

    /**
     * @param VestibularRepository $repository
     * @param CursoRepository $cursoRepository
     * @param MateriaRepository $materiaRepository
     * @param TurnoRepository $turnoRepository
     */
    public function __construct(
        VestibularRepository $repository,
        CursoRepository $cursoRepository,
        MateriaRepository $materiaRepository,
        TurnoRepository $turnoRepository)
    {
        $this->repository        = $repository;
        $this->cursoRepository   = $cursoRepository;
        $this->materiaRepository = $materiaRepository;
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
     * @return array
     */
    public function store(array $data) : Vestibular
    {
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
     * @return mixed
     */
    public function update(array $data, int $id) : Vestibular
    {
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
            !isset($data['idVestibular']) && is_numeric($data['idVestibular'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objVestibular = $this->repository->find($data['idVestibular']);

        # Validando a existência dos objetos
        if(!$objVestibular) {
            throw new \Exception('Curso ou vestibular não existe!');
        }

        # adicionado os curso ao vestibular
        $objVestibular->cursos()->attach($data['arrayCursoId']);

        # Recuperando todas as matérias
        $materias = $this->materiaRepository->all();

        # Percorrendo todos os cursos cadastrados
        foreach ($data['arrayCursoId'] as $value) {
            $curso = $objVestibular->cursos()->find($value);

            # Percorrendo as matérias
            foreach ($materias as $materia) {
                $curso->pivot->materias()->attach($materia->id);
            }
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
            !isset($data['idVestibular']) && is_numeric($data['idVestibular'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objVestibular = $this->repository->find($data['idVestibular']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);

        # Validando a existência dos objetos
        if(!$objVestibular || !$objCurso) {
            throw new \Exception('Curso ou vestibular não existe!');
        }

        # removendo o curso do vestibular
        $objVestibular->cursos()->detach($objCurso->id);

        # Retono
        return true;
    }


    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function storeCursoMateria($data)
    {
        # Validando os dados
        if(!isset($data['idCurso']) && !is_numeric($data['idCurso']) &&
            !isset($data['idVestibular']) && is_numeric($data['idVestibular'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objVestibular = $this->repository->find($data['idVestibular']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);
        $objMateria    = $this->materiaRepository->find($data['materia_id']);

        # Deletando os indexs
        unset($data['idCurso'], $data['idVestibular'], $data['materia_id']);

        # Validando a existência dos objetos
        if(!$objVestibular && !$objCurso && !$objMateria) {
            throw new \Exception('Curso ou vestibular não existe!');
        }

        # adicionado os curso ao vestibular
        $pivot = $objVestibular->cursos()->find($objCurso->id)->pivot;
        $pivot->materias()->attach($objMateria->id, $data);

        # Retono
        return true;
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function deleteCursoMateria($data)
    {
        # Validando os dados
        if(!isset($data['idCurso']) && is_numeric($data['idCurso']) &&
            !isset($data['idVestibular']) && is_numeric($data['idVestibular']) &&
            !isset($data['idMateria']) && is_numeric($data['idMateria'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objVestibular = $this->repository->find($data['idVestibular']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);
        $objMateria    = $this->materiaRepository->find($data['idMateria']);

        # Validando a existência dos objetos
        if(!$objVestibular || !$objCurso || !$objMateria) {
            throw new \Exception('vestibular, curso ou matéria não existe!');
        }

        # removendo a matéria do curso de um vestibular
        $pivot = $objVestibular->cursos()->find($objCurso->id)->pivot;
        $pivot->materias()->detach($objMateria->id);

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
            !isset($data['idVestibular']) && is_numeric($data['idVestibular'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objVestibular = $this->repository->find($data['idVestibular']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);
        $objTurno      = $this->turnoRepository->find($data['turno_id']);

        # Deletando os indexs
        unset($data['idCurso'], $data['idVestibular'], $data['turno_id']);

        # Validando a existência dos objetos
        if(!$objVestibular && !$objCurso && !$objTurno) {
            throw new \Exception('Curso ou vestibular não existe!');
        }

        # adicionado os curso ao vestibular
        $pivot = $objVestibular->cursos()->find($objCurso->id)->pivot;
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
            !isset($data['idVestibular']) && is_numeric($data['idVestibular']) &&
            !isset($data['idTurno']) && is_numeric($data['idTurno'])) {
            throw new \Exception('Valores inválidos');
        }

        # Recuperando os objetos
        $objVestibular = $this->repository->find($data['idVestibular']);
        $objCurso      = $this->cursoRepository->find($data['idCurso']);
        $objTurno      = $this->turnoRepository->find($data['idTurno']);

        # Validando a existência dos objetos
        if(!$objVestibular || !$objCurso || !$objTurno) {
            throw new \Exception('vestibular, curso ou turno não existe!');
        }

        # removendo a matéria do curso de um vestibular
        $pivot = $objVestibular->cursos()->find($objCurso->id)->pivot;
        $pivot->turnos()->detach($objTurno->id);

        # Retono
        return true;
    }

    /**
     * @return mixed
     */
    public function getByValidDate()
    {
        # recuperando a data atual
        $now  = new \DateTime('now');

        # recuperando os vestibulares
        $rows = \DB::table('fac_vestibulares')
            ->select('id')
            ->whereDate('data_inicial', '<=', $now->format('Y-m-d'))
            ->whereDate('data_final', '>=', $now->format('Y-m-d'))
            ->get();
        
        # retorno
        return $rows;
    }
}
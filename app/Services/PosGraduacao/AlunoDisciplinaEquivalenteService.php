<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Entities\PosGraduacao\AlunoDisciplinaEquivalente;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;
use Seracademico\Repositories\PosGraduacao\AlunoDisciplinaEquivalenteRepository;

class AlunoDisciplinaEquivalenteService
{
    /**
     * @var AlunoDisciplinaEquivalenteRepository
     */
    private $repository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @param AlunoDisciplinaEquivalenteRepository $repository
     * @param AlunoRepository $alunoRepository
     */
    public function __construct(AlunoDisciplinaEquivalenteRepository $repository, AlunoRepository $alunoRepository)
    {
        $this->repository = $repository;
        $this->alunoRepository = $alunoRepository;
    }


    /**
     * @param array $data
     * @return AlunoDisciplinaEquivalente
     * @throws \Exception
     */
    public function store(array $data) : AlunoDisciplinaEquivalente
    {
        #Salvando o registro pincipal
        $alunoEquivalencia =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$alunoEquivalencia) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoEquivalencia;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Removendo o registro no banco de dados
        $alunoEquivalencia = $this->repository->find($id);
        
        # Verifiando se a AlunoDisciplinaDispensada foi recuperada
        if(!$alunoEquivalencia) {
            throw new \Exception('Dados não encontrados não encontrada!');
        }

        # Removendo o registro do banco de dados
        $this->repository->delete($alunoEquivalencia->id);

        #Retorno
        return true;
    }
}
<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Repositories\PosGraduacao\AlunoDisciplinaExtraCurricularRepository;
use Seracademico\Entities\PosGraduacao\AlunoDisciplinaExtraCurricular;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;

class AlunoDisciplinaExtraCurricularService
{
    /**
     * @var AlunoDisciplinaExtraCurricularRepository
     */
    private $repository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @param AlunoDisciplinaExtraCurricularRepository $repository
     */
    public function __construct(AlunoDisciplinaExtraCurricularRepository $repository, AlunoRepository $alunoRepository)
    {
        $this->repository = $repository;
        $this->alunoRepository = $alunoRepository;
    }


    /**
     * @param array $data
     * @return AlunoDisciplinaExtraCurricular
     * @throws \Exception
     */
    public function store(array $data) : AlunoDisciplinaExtraCurricular
    {
        #Salvando o registro pincipal
        $alunoDisciplinaExtraCurricular =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$alunoDisciplinaExtraCurricular) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoDisciplinaExtraCurricular;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Removendo o registro no banco de dados
        $alunoDisciplinaExtraCurricular = $this->repository->find($id);

        # Verifiando se a AlunoDisciplinaDispensada foi recuperada
        if(!$alunoDisciplinaExtraCurricular) {
            throw new \Exception('Dados não encontrados não encontrada!');
        }

        # Removendo o registro do banco de dados
        $this->repository->delete($id);

        #Retorno
        return true;
    }
}
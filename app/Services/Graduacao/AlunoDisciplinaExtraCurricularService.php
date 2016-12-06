<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\AlunoDisciplinaExtraCurricularRepository;
use Seracademico\Entities\Graduacao\AlunoDisciplinaExtraCurricular;
use Seracademico\Repositories\Graduacao\AlunoRepository;

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
        # Aplicação de regras de negócios
        $this->tratamentoAluno($data);

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
     * @param array $data
     * @throws \Exception
     */
    public function tratamentoAluno(array &$data)
    {
        # Validando os dados de entrada
        if((!isset($data['aluno_id']) && !is_integer($data['aluno_id'])) ||
            (!isset($data['semestre_id']) && !is_integer($data['semestre_id']))) {
            throw new \Exception('Parametros inválidos!');
        }

        # Recuperando a entidade de aluno
        $aluno = $this->alunoRepository->find($data['aluno_id']);

        # Recuperando o id do pivot e adicionando o array da reuisição
        $data['aluno_semestre_id'] = $aluno->semestres()->find($data['semestre_id'])->pivot->id;

        # Removendo os indices
        unset($data['aluno_id']);
        unset($data['semestre_id']);
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
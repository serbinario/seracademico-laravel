<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\AlunoEquivalenciaRepository;
use Seracademico\Entities\Graduacao\AlunoEquivalencia;
use Seracademico\Repositories\Graduacao\AlunoRepository;

class AlunoEquivalenciaService
{
    /**
     * @var AlunoEquivalenciaRepository
     */
    private $repository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @param AlunoEquivalenciaRepository $repository
     * @param AlunoRepository $alunoRepository
     */
    public function __construct(AlunoEquivalenciaRepository $repository, AlunoRepository $alunoRepository)
    {
        $this->repository = $repository;
        $this->alunoRepository = $alunoRepository;
    }


    /**
     * @param array $data
     * @return AlunoEquivalencia
     * @throws \Exception
     */
    public function store(array $data) : AlunoEquivalencia
    {
        # Aplicação de regras de negócios
        $this->tratamentoAluno($data);

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
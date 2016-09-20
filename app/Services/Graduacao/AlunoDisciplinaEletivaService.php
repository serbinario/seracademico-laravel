<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\AlunoDisciplinaEletivaRepository;
use Seracademico\Entities\Graduacao\AlunoDisciplinaEletiva;
use Seracademico\Repositories\Graduacao\AlunoRepository;

class AlunoDisciplinaEletivaService
{
    /**
     * @var AlunoDisciplinaEletivaRepository
     */
    private $repository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @param AlunoDisciplinaEletivaRepository $repository
     */
    public function __construct(AlunoDisciplinaEletivaRepository $repository, AlunoRepository $alunoRepository)
    {
        $this->repository = $repository;
        $this->alunoRepository = $alunoRepository;
    }


    /**
     * @param array $data
     * @return AlunoDisciplinaEletiva
     * @throws \Exception
     */
    public function store(array $data) : AlunoDisciplinaEletiva
    {
        # Aplicação de regras de negócios
        $this->tratamentoAluno($data);

        #Salvando o registro pincipal
        $alunoDisciplinaEletiva =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$alunoDisciplinaEletiva) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoDisciplinaEletiva;
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
        $alunoDisciplinaEletiva = $this->repository->findWhere(['turma_disciplina_id' => $id]);

        # Verifiando se a AlunoDisciplinaDispensada foi recuperada
        if(count($alunoDisciplinaEletiva) == 0) {
            throw new \Exception('Dados não encontrados não encontrada!');
        }

        # Removendo o registro do banco de dados
        $this->repository->delete($alunoDisciplinaEletiva[0]->id);

        #Retorno
        return true;
    }
}
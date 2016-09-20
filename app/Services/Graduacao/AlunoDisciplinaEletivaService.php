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
        $this->tratamentoTurmaDisciplina($data);

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
     * @param $id
     * @return mixed
     */
    private function getTurmaDisciplina($id)
    {
        # Recuperando o registro do pivot
        $row = \DB::table('fac_turmas_disciplinas')
            ->where('id', $id)
            ->select('disciplina_id', 'turma_id')->get();

        # Validando o retorno da query
        if(count($row) !== 1) {
            throw new \Exception('Dados inválidos!');
        }

        # Retorno
        return $row;
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function tratamentoTurmaDisciplina(array &$data)
    {
        # Recuperando o pivot
        $turmaDisciplina = $this->getTurmaDisciplina($data['turma_disciplina_id']);

        # Recuperando o id do pivot e adicionando o array da reuisição
        $data['turma_id'] = $turmaDisciplina->turma_id;
        $data['disciplina_eletiva_id'] = $turmaDisciplina->disciplina_id;

        # Removendo os indices
        unset($data['turma_disciplina_id']);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Removendo o registro no banco de dados
        $alunoDisciplinaEletiva = $this->repository->find($id);

        # Verifiando se a AlunoDisciplinaDispensada foi recuperada
        if(!$alunoDisciplinaEletiva) {
            throw new \Exception('Dados não encontrados não encontrada!');
        }

        # Removendo o registro do banco de dados
        $this->repository->delete($alunoDisciplinaEletiva->id);

        #Retorno
        return true;
    }
}
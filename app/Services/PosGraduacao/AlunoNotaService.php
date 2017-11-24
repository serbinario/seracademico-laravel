<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Repositories\PosGraduacao\AlunoNotaRepository;
use Seracademico\Entities\PosGraduacao\AlunoNota;

class AlunoNotaService
{
    /**
     * @var AlunoNotaRepository
     */
    private $repository;

    /**
     * AlunoNotaService constructor.
     * @param AlunoNotaRepository $repository
     */
    public function __construct(AlunoNotaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $alunoNota = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$alunoNota) {
            throw new \Exception('Curso não encontrado!');
        }

        #retorno
        return $alunoNota;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function search($id)
    {
        # Fazendo a consulta
        $row = \DB::table('pos_alunos_notas')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'pos_alunos_notas.situacao_nota_id')
            ->join('pos_alunos_turmas', 'pos_alunos_turmas.id', '=', 'pos_alunos_notas.pos_aluno_turma_id')
            ->join('pos_alunos_cursos', 'pos_alunos_cursos.id', '=', 'pos_alunos_turmas.pos_aluno_curso_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->where('pos_alunos_notas.id', $id)
            ->select([
                'pos_alunos_notas.id',
                'pos_alunos_notas.nota_final',
                'fac_situacao_nota.id as idSituacao',
                'fac_situacao_nota.nome as nomeSituacao',
                'pessoas.nome as nomePessoa'
            ])->get();

        # Validando se a nota foi encontrada
        if(count($row) === 0) {
            throw new \Exception("Nota não encontrada");
        }
        
        #retorno
        return $row;
    }

    /**
     * @param array $data
     * @return AlunoNota
     * @throws \Exception
     */
    public function store(array $data) : AlunoNota
    {
        #Salvando o registro pincipal
        $alunoNota =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$alunoNota) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoNota;
    }

    /**
     * @param array $data
     * @param int $id
     * @return AlunoNota
     * @throws \Exception
     */
    public function update(array $data, int $id) : AlunoNota
    {   
        #Atualizando no banco de dados
        $alunoNota = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$alunoNota) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoNota;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o alunoNota
        $nota = $this->find($id);
        $nota->frequencias()->delete();

        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o alunoNota!');
        }

        #retorno
        return true;
    }

    /**
     * @param $idAluno
     * @param $idSemestre
     * @param $idDisciplina
     * @return bool
     * @throws \Exception
     */
    public function deleteByAlunoAndDisciplina($idAluno, $idSemestre, $idDisciplina)
    {
        # Recuperando o id de alunos notas
        $row = \DB::table('fac_alunos_notas')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
            ->where('fac_disciplinas.id', $idDisciplina)
            ->where('fac_alunos_semestres.aluno_id', $idAluno)
            ->where('fac_alunos_semestres.semestre_id', $idSemestre)
            ->lists('fac_alunos_notas.id');
      
        # Validando o registro obtido
        if(!(count($row) == 1)) {
            throw new \Exception('Notas e Frequências inválidas!');
        }

        # Recuperando o model de alunoNota e deletando em cascata
        $alunoNota = $this->repository->find($row[0]);
        $alunoNota->delete();

        #retorno
        return true;
    }
}
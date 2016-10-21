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
        $row = \DB::table('fac_alunos_notas')            
            ->leftJoin('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->leftJoin('fac_alunos_frequencias', 'fac_alunos_frequencias.aluno_nota_id', '=', 'fac_alunos_notas.id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->where('fac_alunos_notas.id', $id)
            ->select([
                'fac_alunos_notas.id',
                'fac_alunos_notas.nota_unidade_1',
                'fac_alunos_notas.nota_unidade_2',
                'fac_alunos_notas.nota_2_chamada',
                'fac_alunos_notas.nota_final',
                'fac_alunos_notas.nota_media',
                'fac_alunos_frequencias.total_falta',
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
<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Repositories\Graduacao\AlunoFrequenciaRepository;
use Seracademico\Entities\Graduacao\AlunoFrequencia;

class AlunoFrequenciaService
{
    /**
     * @var AlunoFrequenciaRepository
     */
    private $repository;

    /**
     * AlunoFrequenciaService constructor.
     * @param AlunoFrequenciaRepository $repository
     */
    public function __construct(AlunoFrequenciaRepository $repository)
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
        $alunoFrequencia = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$alunoFrequencia) {
            throw new \Exception('Frequencia não encontrada!');
        }

        #retorno
        return $alunoFrequencia;
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
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->join('fac_alunos_frequencias', 'fac_alunos_frequencias.aluno_nota_id', '=', 'fac_alunos_notas.id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->where('fac_alunos_frequencias.id', $id)
            ->select([
                'fac_alunos_frequencias.id',
                'fac_alunos_frequencias.falta_mes_1',
                'fac_alunos_frequencias.falta_mes_2',
                'fac_alunos_frequencias.falta_mes_3',
                'fac_alunos_frequencias.falta_mes_4',
                'fac_alunos_frequencias.falta_mes_5',
                'fac_alunos_frequencias.falta_mes_6',
                'fac_alunos_frequencias.total_falta',
                'fac_situacao_nota.nome as nomeSituacao',
                'pessoas.nome as nomePessoa'
            ])->get();

        # Validando se a nota foi encontrada
        if(count($row) === 0) {
            throw new \Exception("Frequencia não encontrada");
        }
        
        #retorno
        return $row;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : AlunoFrequencia
    {
        #Salvando o registro pincipal
        $alunoFrequencia =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$alunoFrequencia) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoFrequencia;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : AlunoFrequencia
    {
        #Atualizando no banco de dados
        $alunoFrequencia = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$alunoFrequencia) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoFrequencia;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o alunoFrequencia
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o alunoFrequencia!');
        }

        #retorno
        return true;
    }
}
<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Repositories\PosGraduacao\AlunoDisciplinaDispensadaRepository;
use Seracademico\Entities\PosGraduacao\AlunoDisciplinaDispensada;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;

class AlunoDisciplinaDispensadaService
{
    /**
     * @var AlunoDisciplinaDispensadaRepository
     */
    private $repository;

    /**
     * @var
     */
    private $alunoRepository;

    /**
     * AlunoDisciplinaDispensadaService constructor.
     * @p ram AlunoRepository $alunoRepository
     */
    public function __construct(
        AlunoDisciplinaDispensadaRepository $repository,
        AlunoRepository $alunoRepository)
    {
        $this->repository = $repository;
        $this->alunoRepository = $alunoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $alunoDisciplinaDispensada = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('AlunoDisciplinaDispensada não encontrada!');
        }

        #retorno
        return $alunoDisciplinaDispensada;
    }

    /**
     * @param array $data
     * @return AlunoDisciplinaDispensada
     * @throws \Exception
     */
    public function store(array $data) : AlunoDisciplinaDispensada
    {
        # Validando a entrada
        if(!isset($data['disciplina_id']) && !isset($data['aluno_id'])
            && !isset($data['pos_aluno_turma_id']) && !isset($data['motivo'])) {
            throw new \Exception('O campo disciplina é obrigatório!');
        }

        # Tratamento
        $this->tratamentoCampos($data);
        
        # Salvando o registro
        $alunoDisciplinaDispensada =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoDisciplinaDispensada;
    }

    /**
     * @param array $data
     * @param int $id
     * @return AlunoDisciplinaDispensada
     * @throws \Exception
     */
    public function update(array $data, int $id) : AlunoDisciplinaDispensada
    {
        # Validando a entrada
        if(!isset($data['disciplina_id']) && !isset($data['motivo'])) {
            throw new \Exception('O campo disciplina é obrigatório!');
        }

        # Tratamento
        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $alunoDisciplinaDispensada = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $alunoDisciplinaDispensada;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        # Removendo o registro no banco de dados
        $alunoDisciplinaDispensada = $this->repository->find($id);

        # Verifiando se a AlunoDisciplinaDispensada foi recuperada
        if(!$alunoDisciplinaDispensada) {
            throw new \Exception('Dados não encontrados não encontrada!');
        }

        # Removendo o registro do banco de dados
        $this->repository->delete($id);

        #Retorno
        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $explodeKey2 = explode("_", $key2);

                    if ($explodeKey2[count($explodeKey2) -1] == "id" && $value2 == null ) {
                        $data[$key][$key2] = null;
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #Retorno
        return $data;
    }
}
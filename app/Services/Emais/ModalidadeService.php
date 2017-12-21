<?php

namespace Seracademico\Services\Emais;

use Carbon\Carbon;
use Seracademico\Entities\Emais\Modalidade;
use Seracademico\Repositories\Emais\ModalidadeRepository;
use Seracademico\Services\TraitService;

class ModalidadeService
{
    use TraitService;

    /**
     * @var ModalidadeRepository
     */
    private $repository;


    /**
     * AlunoService constructor.
     * @param ModalidadeRepository $repository
     */
    public function __construct(ModalidadeRepository $repository)
    {
        $this->repository  = $repository;
    }

    /**
     * Método responável por retornar o aluno passado pelo o id
     * com todas as suas dependências.
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados

        # Recuperando o registor do aluno
        $aluno = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$aluno) {
            throw new \Exception('Aluno não encontrado!');
        }

        #retorno
        return $aluno;
    }

    /**
     * Método responsável por salvar o aluno
     *
     * @param array $data
     * @return Aluno
     * @throws \Exception
     */
    public function store(array $data) : Modalidade
    {

        #Salvando o registro pincipal
        $aluno =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }
        
        #Retorno
        return $aluno;
    }

    /**
     * Método reponsável por atualizar o aluno.
     *
     * @param array $data
     * @param int $id
     * @return Aluno
     * @throws \Exception
     */
    public function update(array $data, int $id) : Modalidade
    {
        # Regras de negócios pre edição
        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $aluno = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $aluno;
    }

}
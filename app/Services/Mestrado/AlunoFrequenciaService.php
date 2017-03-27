<?php

namespace Seracademico\Services\Mestrado;

use Seracademico\Repositories\Mestrado\AlunoFrequenciaRepository;

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
}
<?php

namespace Seracademico\Services;

use Seracademico\Repositories\InstituicaoRepository;
use Seracademico\Entities\Instituicao;

class InstituicaoService
{
    /**
     * @var InstituicaoRepository
     */
    private $repository;

    /**
     * @param InstituicaoRepository $repository
     */
    public function __construct(InstituicaoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     */
    public function inserirInstituicaoSelect($data)
    {
        #
        $novaInstituicao = "";

        #
        $validacao = $this->repository->findWhere(['nome' => $data]);

        #
        if (count($validacao) > 0) {

            $novaInstituicao = null;

        } else {
            #
            $novaInstituicao = $this->repository->create($data);
        }

        #
        return $novaInstituicao;
    }
}
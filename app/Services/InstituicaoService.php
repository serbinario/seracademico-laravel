<?php

namespace Seracademico\Services;

use Seracademico\Repositories\InstituicaoRepository;
use Seracademico\Entities\Instituicao;

class InstituicaoService
{
    /**
     * @var InstituicaoRepository|HoraRepository
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
    public function inserirInstituicaoSelect($data) {

        #
        $novaInstituicao = $this->repository->create($data);

        #
        return $novaInstituicao;
    }
}
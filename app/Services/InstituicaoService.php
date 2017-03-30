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
        #verificando se o valor inserido já existe no banco de dados
        $objInstituicao = $this->repository->findWhere(['nome' => $data['nome']]);

        #se já existir, retorne, se não, cadastre.
        if (count($objInstituicao) > 0) {

            return $objInstituicao[0];
        }

        #persistindo
        $novaInstituicao = $this->repository->create($data);

        return $novaInstituicao;
    }
}
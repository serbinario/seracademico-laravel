<?php

namespace Seracademico\Services;

use Seracademico\Repositories\CursoSuperiorRepository;
use Seracademico\Entities\CursoSuperior;

class CursoFormacaoService
{
    /**
     * @var
     */
    private $repository;

    /**
     * @param CursoSuperiorRepository $repository
     */
    public function __construct(CursoSuperiorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function inserirCursoFormacaoSelect($data)
    {
        #verificando se o valor inserido já existe no banco de dados
        $objFormacao = $this->repository->findWhere(['nome' => $data['nome']]);

        #se já existir, retorne, se não, cadastre.
        if (count($objFormacao) > 0) {

            return $objFormacao[0];
        }

        #persistindo
        $novoCursoFormacao = $this->repository->create($data);

        return $novoCursoFormacao;
    }
}
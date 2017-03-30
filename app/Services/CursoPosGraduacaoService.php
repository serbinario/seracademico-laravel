<?php

namespace Seracademico\Services;

use Seracademico\Repositories\CursoPosGraduacaoRepository;
use Seracademico\Entities\PosGraduacao;

class CursoPosGraduacaoService
{
    /**
     * @var CursoPosGraduacaoRepository
     */
    private $repository;

    /**
     * @param CursoPosGraduacaoRepository $repository
     */
    public function __construct(CursoPosGraduacaoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function inserirCursoPosGraduacaoSelect($data)
    {
        #verificando se o valor inserido já existe no banco de dados
        $objCurso = $this->repository->findWhere(['nome' => $data['nome']]);

        #se já existir, retorne, se não, cadastre.
        if (count($objCurso) > 0) {

            return $objCurso[0];
        }

        #persistindo
        $novoCursoPosGraduacao = $this->repository->create($data);

        return $novoCursoPosGraduacao;
    }
}
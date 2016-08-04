<?php
/**
 * Created by PhpStorm.
 * User: AndreyPriscila
 * Date: 01/08/2016
 * Time: 12:39
 */

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\FechamentoRepository;

class FechamentoService
{
    /**
     * @var FechamentoRepository
     */
    private $repository;

    /**
     * FechamentoService constructor.
     * @param FechamentoRepository $repository
     */
    public function __construct(FechamentoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        #Salvando o registro pincipal
        $fechamento =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$fechamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $fechamento;
    }
}
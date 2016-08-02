<?php
/**
 * Created by PhpStorm.
 * User: AndreyPriscila
 * Date: 01/08/2016
 * Time: 12:39
 */

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\DebitoAbertoAlunoRepository;

class DebitoAbertoAlunoService
{
    /**
     * @var DebitoAbertoAlunoRepository
     */
    private $repository;

    /**
     * DebitoAbertoAlunoService constructor.
     * @param DebitoAbertoAlunoRepository $repository
     */
    public function __construct(DebitoAbertoAlunoRepository $repository)
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
        $debito =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$debito) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $debito;
    }
}
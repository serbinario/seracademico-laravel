<?php
/**
 * Created by PhpStorm.
 * User: serbinario
 * Date: 05/07/16
 * Time: 10:15
 */

namespace Seracademico\Uteis;


use Seracademico\Repositories\Graduacao\VestibularRepository;

class ParametroVestibular
{
    /**
     * @var VestibularRepository
     */
    private $repository;

    /**
     * ParametroMatricula constructor.
     * @param VestibularRepository $repository
     */
    public function __construct(VestibularRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Método responsável por retornar o vestibular ativo
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAtivo()
    {
        # Retorno
        return $this->repository->findByField('ativo', 1);
    }
}
<?php
namespace Seracademico\Uteis;

use Seracademico\Repositories\Financeiro\BancoRepository;

class ParametroBanco
{

    /**
     * @var BancoRepository
     */
    private $repository;

    /**
     * ParametroMatricula constructor.
     * @param BancoRepository $repository
     */
    public function __construct(BancoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     * @throws \Exception
     *
     * Esse método retorna o único banco ativo
     */
    public function getAtivo()
    {
        # Recuperando o banco
        $banco = $this->repository->findWhere(['status' => 1]);

        # Verificando se um banco foi encontrado
        if(count($banco) == 0) {
            throw new \Exception('Não existe um banco ativo!');
        }

        # retorno
        return $banco[0];
    }
}
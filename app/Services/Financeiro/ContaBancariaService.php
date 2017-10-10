<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\ContaBancariaRepository;
use Seracademico\Entities\Financeiro\ContaBancaria;
use Seracademico\Services\TraitService;

class ContaBancariaService
{
    use TraitService;

    /**
     * @var ContaBancariaRepository
     */
    private $repository;

    /**
     * @param ContaBancariaRepository $repository
     */
    public function __construct(ContaBancariaRepository $repository)
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
        $relacionamentos = [
            'banco'
        ];

        $contaBancaria = $this->repository->with($relacionamentos)->find($id);

        if(!$contaBancaria) {
            throw new \Exception('Conta bancária não encontrada!');
        }

        return $contaBancaria;
    }


    /**
     * @param array $data
     * @return ContaBancaria
     * @throws \Exception
     */
    public function store(array $data) : ContaBancaria
    {
        $contaBancaria =  $this->repository->create($data);

        if(!$contaBancaria) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        return $contaBancaria;
    }

    /**
     * @param array $data
     * @param int $id
     * @return ContaBancaria
     * @throws \Exception
     */
    public function update(array $data, int $id) : ContaBancaria
    {
        $contaBancaria = $this->repository->update($data, $id);

        if(!$contaBancaria) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        return $contaBancaria;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $contaBancaria = $this->repository->find($id);

        if(!$contaBancaria) {
            throw new \Exception('ContaBancaria não encontrada!');
        }

        $this->repository->delete($contaBancaria->id);

        return true;
    }
}
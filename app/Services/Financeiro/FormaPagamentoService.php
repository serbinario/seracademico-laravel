<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\FormaPagamentoRepository;
use Seracademico\Entities\Financeiro\FormaPagamento;
use Seracademico\Services\TraitService;


class FormaPagamentoService
{
    use TraitService;

    /**
     * @var FormaPagamentoRepository
     */
    private $repository;

    /**
     * @param FormaPagamentoRepository $repository
     */
    public function __construct(FormaPagamentoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return FormaPagamento
     * @throws \Exception
     */
    public function store(array $data) : FormaPagamento
    {
        $this->tratamentoCampos($data);

        $formaPagamento =  $this->repository->create($data);

        if(!$formaPagamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        return $formaPagamento;
    }

    /**
     * @param array $data
     * @param int $id
     * @return FormaPagamento
     * @throws \Exception
     */
    public function update(array $data, int $id) : FormaPagamento
    {
        $this->tratamentoCampos($data);

        $formaPagamento = $this->repository->update($data, $id);

        if(!$formaPagamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        return $formaPagamento;
    }
}
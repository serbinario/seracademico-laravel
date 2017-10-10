<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Events\DebitoStored;
use Seracademico\Events\DebitoUpdated;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Services\TraitService;

class DebitoService
{
    use TraitService;

    /**
     * @var DebitoRepository
     */
    private $repository;

    /**
     * @var BoletoService
     */
    private $boletoService;

    /**
     * @var GerencianetService
     */
    private $gerencianetService;


    /**
     * DebitoService constructor.
     * @param DebitoRepository $repository
     * @param BoletoService $boletoService
     * @param GerencianetService $gerencianetService
     */
    public function __construct(
        DebitoRepository $repository,
        BoletoService $boletoService,
        GerencianetService $gerencianetService
    )
    {
        $this->repository = $repository;
        $this->boletoService = $boletoService;
        $this->gerencianetService = $gerencianetService;
    }


    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        $relacionamentos = [
            'taxa.tipoTaxa',
            'boleto.statusGnet',
            'formaPagamento'
        ];

        $debito = $this->repository->with($relacionamentos)->find($id);

        if(!$debito) {
            throw new \Exception('Débito não encontrado!');
        }

        return $debito;
    }


    /**
     * @param $debitante
     * @param array $dados
     * @return mixed
     * @throws \Exception
     */
    public function store($debitante, array $dados)
    {
        $this->tratamentoCampos($dados);

        $debito =  $debitante->debitos()->create($dados);

        if(!$debito) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        event(new DebitoStored($debito));

        return $debito;
    }


    /**
     * @param array $dados
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function update(array $dados, $id)
    {
        $this->tratamentoCampos($dados);

        $debitoAnterior = $this->find($id);

        if (!$debitoAnterior) {
            throw new \Exception("Débito não encontrado");
        }

        $debito = $this->repository->update($dados, $debitoAnterior->id);

        event(new DebitoUpdated($debitoAnterior, $debito));

        return $debito;
    }


    /**
     * @param $idDebito
     * @return mixed
     * @throws \Exception
     */
    public function gerarBoleto($idDebito)
    {
        $debito = $this->repository->find($idDebito);
        $debitante = $debito->debitante;
        $pessoa = $debitante->pessoa;

        if (!$debito) {
            throw new \Exception('Débito não encontrado');
        }

        if ($debito->boleto) {
            return $debito->boleto;
        }

        $boleto = $this->boletoService->obtemModel();
        $boleto->gnet_nome = $debito->taxa->nome;
        $boleto->gnet_quantidade = 1;
        $boleto->gnet_valor = $debito->valor_debito;
        $boleto->vencimento = $debito->data_vencimento;
        $boleto->debito_id = $debito->id;

        $retornoGnet = $this->gerencianetService->setFormOfPayment($pessoa, $boleto);
        $status = $this->boletoService->obtemStatusPelo($retornoGnet['data']['status']);

        $boleto->gnet_charge = $retornoGnet['data']['charge_id'];
        $boleto->gnet_link = $retornoGnet['data']['link'];
        $boleto->gnet_status_id = $status->id;
        $boleto->save();

        return $boleto;
    }
}
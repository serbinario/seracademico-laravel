<?php
namespace Seracademico\Services\Financeiro;

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
        # Definindo os relacionamentos
        $relacionamentos = [
            'taxa'
        ];

        # Recuperando o débito
        $debito = $this->repository->with($relacionamentos)->find($id);

        #Verificando se foi criado no banco de dados
        if(!$debito) {
            throw new \Exception('Débito não encontrado!');
        }

        #Retorno
        return $debito;
    }


    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function store($debitante, array $data)
    {
        #Salvando o registro pincipal
        $debito =  $debitante->debitos()->create($data);

        #Verificando se foi criado no banco de dados
        if(!$debito) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
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
        $debito = $this->find($id);

        if (!$debito) {
            throw new \Exception("Débito não encontrado");
        }

        $debito = $this->repository->update($dados, $debito->id);

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
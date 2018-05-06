<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Events\DebitoStored;
use Seracademico\Events\DebitoUpdated;
use Seracademico\Repositories\Financeiro\CarneRepository;
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
     * @var CarneRepository
     */
    private $carneRepository;


    /**
     * DebitoService constructor.
     * @param DebitoRepository $repository
     * @param BoletoService $boletoService
     * @param GerencianetService $gerencianetService
     */
    public function __construct(
        DebitoRepository $repository,
        CarneRepository $carneRepository,
        BoletoService $boletoService,
        GerencianetService $gerencianetService
    )
    {
        $this->repository = $repository;
        $this->boletoService = $boletoService;
        $this->gerencianetService = $gerencianetService;
        $this->carneRepository = $carneRepository;
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

        event(new DebitoStored($debito, $dados));

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
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {

        // Deletar o extrato
        \DB::table('fin_extratos')->where('debito_id', $id)->delete();

        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteCarne(int $id)
    {
        // Pegando todos os debitos relacioandos ao carnê
         $debitos = \DB::table('fin_debitos')
             ->where('carne_id', $id)
             ->select(['id'])->get();

         // Deletando todos os extratos ligados aos dêbito
         foreach($debitos as $debito) {
             // Deletar o extrato
             \DB::table('fin_extratos')->where('debito_id', $debito->id)->delete();
             \DB::table('fin_boletos')->where('debito_id', $debito->id)->delete();
         }

         // Deletando todos os débitos do carnê
        \DB::table('fin_debitos')->where('carne_id', $id)->delete();

        #deletando o curso
        $result = $this->carneRepository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }

    /*
    * Retorna uma transaçao de um carne
    */

    public function detailCarnet($idDebito)
    {
        return $this->gerencianetService->detailCarnet($idDebito);
    }

    /*
     * Retorna uma transaçao
     */
    public function detailCharge($idDebito)
    {
        return $this->gerencianetService->detailCharge($idDebito);
    }



    /**
     * @param $idDebito
     * @return mixed
     * @throws \Exception
     */
    public function gerarBoleto($idDebito)
    {
        //dd($idDebito);
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


        //Inicializa a transaçao do gerencianet
        $retornoGnet = $this->gerencianetService->setFormOfPayment($pessoa, $boleto);
        dd($retornoGnet);
        $status = $this->boletoService->obtemStatusPelo($retornoGnet['data']['status']);

        $boleto->gnet_charge = $retornoGnet['data']['charge_id'];
        $boleto->gnet_link = $retornoGnet['data']['link'];
        $boleto->gnet_status_id = $status->id;
        $boleto->save();

        return $boleto;
    }
}
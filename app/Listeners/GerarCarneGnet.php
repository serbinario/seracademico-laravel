<?php
namespace Seracademico\Listeners;

use Illuminate\Support\Collection;
use Seracademico\Events\DebitoStored;
use Seracademico\Repositories\Financeiro\CarneRepository;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Services\Financeiro\BoletoService;
use Seracademico\Services\Financeiro\DebitoService;
use Seracademico\Services\Financeiro\GerencianetService;

class GerarCarneGnet
{
    /**
     * @var DebitoService
     */
    private $service;

    /**
     * @var GerencianetService
     */
    private $gerencianetService;

    /**
     * @var DebitoRepository
     */
    private $repository;

    /**
     * @var CarneRepository
     */
    private $carneRepository;

    /**
     * @var BoletoService
     */
    private $boletoService;

    /**
     * GerarCarneGnet constructor.
     * @param DebitoRepository $repository
     * @param DebitoService $service
     * @param GerencianetService $gerencianetService
     * @param CarneRepository $carneRepository
     * @param BoletoService $boletoService
     * @internal param DebitoService $service
     */
    public function __construct(
        DebitoRepository $repository,
        DebitoService $service,
        GerencianetService $gerencianetService,
        CarneRepository $carneRepository,
        BoletoService $boletoService)
    {
        $this->service = $service;
        $this->gerencianetService = $gerencianetService;
        $this->repository = $repository;
        $this->carneRepository = $carneRepository;
        $this->boletoService = $boletoService;
    }

    /**
     * @param DebitoStored $event
     * @throws \Exception
     */
    public function handle(DebitoStored $event)
    {
        $debito = $event->getDebito();
        $dados = $event->getDados();
        $pessoa = $debito->debitante->pessoa;
        $dadosGnet = $this->formatDataForGnet($debito, $dados);

        if (!(isset($dados['quantidade']) && $dados['quantidade'] > 0)) {
            return;
        }

        try {
            \DB::beginTransaction();

            $carnet = $this->gerencianetService->createCarnet($pessoa, $dadosGnet);

            if (! $carnet) {
                throw new \Exception("Não foi possível gerar o carnê");
            }

            $carnetObj = $this->carneRepository->create($this->formatDataForCarnet($carnet));
            $debito->carne_id = $carnetObj->id;
            $debito->save();

            $boletos = Collection::make($carnet['data']['charges']);
            $debito->boleto()->create($this->formatBoletoForDebito($debito, $boletos->first()));

            foreach ($boletos->slice(1) as $boleto) {
                $novoDebito = $this->repository->create(array_except($debito->toArray(), 'id'));
                $novoDebito->boleto()->create($this->formatBoletoForDebito($novoDebito, $boleto));
                $novaDataVencimento = new \DateTime($boleto['expire_at']);
                $novoDebito->data_vencimento = $novaDataVencimento->format('d/m/Y');
                $novoDebito->mes_referencia = $novaDataVencimento->format('m');
                $novoDebito->ano_referencia = $novaDataVencimento->format('Y');
                $novoDebito->carne_id = $carnetObj->id;
                $novoDebito->save();
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            $debito->boleto()->delete();
            $this->repository->delete($debito->id);
            throw $e;
        }
    }

    /**
     * @param $debito
     * @param $dados
     * @return array
     */
    private function formatDataForGnet($debito, $dados)
    {
        $dataVencStrPtBR = $debito->data_vencimento;
        $dataVencObj = \DateTime::createFromFormat('d/m/Y', $dataVencStrPtBR);

        $dadosGnet = [];
        $dadosGnet['qtd'] = (integer) $dados['quantidade'];
        $dadosGnet['expire_at'] = $dataVencObj->format('Y-m-d');
        $dadosGnet['value'] = ((integer) $debito->valor_debito) * 100;
        $dadosGnet['name'] = $debito->taxa->nome;

        return $dadosGnet;
    }

    /**
     * @param $debito
     * @param $dadosBoleto
     * @return array
     */
    private function formatBoletoForDebito($debito, $dadosBoleto)
    {
        $status = $this->boletoService->obtemStatusPelo($dadosBoleto['status']);

        return [
            'gnet_nome' => $debito->taxa->nome,
            'gnet_quantidade' => 1,
            'gnet_charge' => $dadosBoleto['charge_id'],
            'gnet_valor' => $dadosBoleto['value'],
            'gnet_vencimento' => $dadosBoleto['expire_at'],
            'gnet_parcel' => $dadosBoleto['parcel'],
            'gnet_status_id' => $status->id,
            'gnet_link' => $dadosBoleto['url'],
            'gnet_barcode' => $dadosBoleto['barcode']
        ];
    }

    /**
     * @param $carnet
     * @return array
     */
    private function formatDataForCarnet($carnet)
    {
        return [
            'gnet_carnet_id' => $carnet['data']['carnet_id'],
            'gnet_status' => $carnet['data']['status'],
            'gnet_cover_link' => $carnet['data']['cover'],
            'gnet_link' => $carnet['data']['link'],
            'gnet_code' => $carnet['code']
        ];
    }
}

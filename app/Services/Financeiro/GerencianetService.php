<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Contracts\GnetBoleto;
use Seracademico\Contracts\GnetCustomer;
use Seracademico\Repositories\BoletoRepository;
use Seracademico\Entities\Financeiro\Boleto;
use Seracademico\Entities\Pessoa;
use Gerencianet\Gerencianet;

class GerencianetService
{
    /**
     * @var Gerencianet
     */
    private $apiGerencianet;

    /**
     * @var string
     */
    private $link;

    /**
     * GerencianetService constructor.
     * @param $clientId
     * @param $secretId
     * @param $sendbox
     * @param $link
     */
    public function __construct($clientId, $secretId, $sendbox, $link)
    {
        $this->link = $link;
        $this->apiGerencianet = new Gerencianet(
            $this->formatOptions(
                $clientId,
                $secretId,
                $sendbox
            )
        );
    }

    /**
     * @param $clientId
     * @param $secretId
     * @param $sendbox
     * @return array
     */
    protected function formatOptions($clientId, $secretId, $sendbox)
    {
        return [
            'client_id' => $clientId,
            'client_secret' => $secretId,
            'sandbox' => $sendbox
        ];
    }

    /**
     * @param GnetBoleto $boleto
     * @return mixed
     */
    protected function initTransaction(GnetBoleto $boleto)
    {
        $item = [
            'name' => $boleto->getName(),
            'amount' => $boleto->getQtd(),
            'value' => $boleto->getValue()
        ];

        $charge = $this->apiGerencianet->createCharge([], [
            'items' => [$item],
            'metadata' => [
                'notification_url' => $this->link
            ]
        ]);

        return $charge;
    }

    /**
     * @param GnetCustomer $pessoa
     * @param GnetBoleto $boleto
     * @return array
     * @throws \Exception
     */
    public function setFormOfPayment(GnetCustomer $pessoa, GnetBoleto $boleto)
    {
        $this->validateOrFail($pessoa, $boleto);
        $charge = $this->initTransaction($boleto);

        if (!$charge) {
            throw new \Exception('Ocorreu um problema na comunicação 
               com o gerencianet, contate o suporte');
        }

        $params = $this->formatParamsPay($charge);
        $body = $this->formatBodyPay($pessoa, $boleto);
        $resultPay = $this->apiGerencianet->payCharge($params, $body);

        return array_merge($charge, $resultPay);
    }

    /*
     * retorna informações de carnê existente)
     */
    public function detailCarnet($params){

        $params = ['id' => $params];
        return $this->apiGerencianet->detailCarnet($params, []);

    }

    /*
     * retorna informações de Boleto existente)
     */
    public function detailCharge($params){

        $params = ['id' => $params];
        return $this->apiGerencianet->detailCharge($params, []);

    }



    /**
     * @param GnetCustomer $pessoa
     * @param array $data
     * @return mixed
     */
    public function createCarnet(GnetCustomer $pessoa, array $data)
    {
        $this->validateCustomer($pessoa);
        $this->validateDataCarnet($data);

        $item_1 = [
            'name' => $data['name'],
            'amount' => 1,
            'value' => $data['value']
        ];

        $body = [
            'items' => [$item_1],
            'customer' => $this->formatCustomer($pessoa),
            'expire_at' => $data['expire_at'],
            'repeats' => $data['qtd'],
            'split_items' => false
        ];

        $carnet = $this->apiGerencianet->createCarnet([], $body);

        return $carnet;
    }

    /**
     * @param $charge
     * @return array
     */
    protected function formatParamsPay($charge)
    {
        return [
            'id' => $charge['data']['charge_id']
        ];
    }

    /**
     * @param GnetCustomer $pessoa
     * @param GnetBoleto $boleto
     * @return array
     */
    protected function formatBodyPay(GnetCustomer $pessoa, GnetBoleto $boleto)
    {
        $bankingBillet = [
            'expire_at' => $boleto->getDueDate(),
            'customer' => $this->formatCustomer($pessoa),
            'configurations' => [
                'interest' => 0
            ],
            'message' => 'Não receber após o vencimento.',
        ];

        $payment = [
            'banking_billet' => $bankingBillet
        ];

        return [
            'payment' => $payment
        ];
    }

    /**
     * @param GnetCustomer $pessoa
     * @return array
     */
    protected function formatCustomer(GnetCustomer $pessoa)
    {
        return [
            'name' => $pessoa->getName(),
            'cpf' => $pessoa->getCpf() ,
            'phone_number' => $pessoa->getPhone()
        ];
    }

    /**
     * @param GnetCustomer $pessoa
     * @param GnetBoleto $
     * @throws \Exception
     */
    private function validateOrFail(GnetCustomer $pessoa, GnetBoleto $boleto)
    {
        $this->validateCustomer($pessoa);
        $this->validateBoleto($boleto);
    }

    /**
     * @param GnetCustomer $pessoa
     * @throws \Exception
     */
    private function validateCustomer(GnetCustomer $pessoa)
    {
        if (!$pessoa->getName()) {
            throw new \Exception('Nome da pessoa não informado');
        }

        if (!$pessoa->getCpf()) {
            throw new \Exception('CPF da pessoa não informado');
        }

        if (!$pessoa->getPhone()) {
            throw new \Exception('Telefone da pessoa não informado');
        }
    }

    /**
     * @param GnetBoleto $boleto
     * @throws \Exception
     */
    private function validateBoleto(GnetBoleto $boleto)
    {
        if (!$boleto->getDueDate()) {
            throw new \Exception('Data de vencimento não informada');
        }
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    private function validateDataCarnet(array $data)
    {
        if (!isset($data['expire_at'])) {
            throw new \Exception('Data do vencimento não informado!');
        }

        if (!isset($data['qtd'])) {
            throw new \Exception('Quantidade de repetições não informado');
        }

        if (!isset($data['value'])) {
            throw new \Exception('Valor não informado');
        }

        if (!isset($data['name'])) {
            throw new \Exception('Nome não informado');
        }
    }

    /**
     * @param $token
     * @return array
     */
    public function notification($token)
    {
        # Recuperando o token da notificação
        $params = [
            'token' => $token
        ];

        # Consultando os dados da notificação
        $chargeNotification = $this->apiGerencianet->getNotification($params, []);

        # Para identificar o status atual da sua transação você deverá contar o número de situações contidas no
        # array, pois a última posição guarda sempre o último status.
        # Conta o tamanho do array data (que armazena o resultado)
        $i = count($chargeNotification["data"]);

        # Pega o último Object chargeStatus
        $ultimoStatus = $chargeNotification["data"][$i-1];

        # Acessando o array Status
        $status = $ultimoStatus["status"];

        # Retorno
        return [
            'charge' => $ultimoStatus["identifiers"]["charge_id"],
            'status' => $status["current"]
        ];
    }
}
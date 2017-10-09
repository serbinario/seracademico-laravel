<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Contracts\GnetBoleto;
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
     * @param Pessoa $pessoa
     * @param GnetBoleto $boleto
     * @return array
     * @throws \Exception
     */
    public function setFormOfPayment(Pessoa $pessoa, GnetBoleto $boleto)
    {
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
     * @param Pessoa $pessoa
     * @param GnetBoleto $boleto
     * @return array
     */
    protected function formatBodyPay(Pessoa $pessoa, GnetBoleto $boleto)
    {
        $customer = [
            'name' => $pessoa->nome,
            'cpf' => $pessoa->cpf ,
            'phone_number' => $pessoa->telefone_fixo
        ];


        $bankingBillet = [
            'expire_at' => $boleto->getDueDate(),
            'customer' => $customer,
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
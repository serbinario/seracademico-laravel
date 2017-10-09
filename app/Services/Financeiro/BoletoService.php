<?php

namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\BoletoRepository;
use Seracademico\Entities\Financeiro\Boleto;
use Seracademico\Repositories\Financeiro\StatusBoletoGnetRepository;

class BoletoService
{
    /**
     * @var BoletoRepository
     */
    private $repository;

    /**
     * @var StatusBoletoGnetRepository
     */
    private $statusBoletoGnetRepository;

    /**
     * @param BoletoRepository $repository
     * @param StatusBoletoGnetRepository $statusBoletoGnetRepository
     */
    public function __construct(
        BoletoRepository $repository,
        StatusBoletoGnetRepository $statusBoletoGnetRepository)
    {
        $this->repository = $repository;
        $this->statusBoletoGnetRepository = $statusBoletoGnetRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $boleto = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$boleto) {
            throw new \Exception('Boleto não encontrada!');
        }

        #retorno
        return $boleto;
    }

    /**
     * @param array $data
     * @return Boleto
     * @throws \Exception
     */
    public function store(array $data) : Boleto
    {   
        #Salvando o registro pincipal
        $boleto =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$boleto) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $boleto;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Boleto
     * @throws \Exception
     */
    public function update(array $data, int $id) : Boleto
    {
        #Atualizando no banco de dados
        $boleto = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$boleto) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $boleto;
    }


    /**
     * @param $codigo
     * @return mixed
     * @throws \Exception
     */
    public function obtemStatusPelo($codigo)
    {
        // Recuperando o status da notificação
        $status = $this->statusBoletoGnetRepository->findWhere(['codigo' => $codigo]);

        // Verificando se foi encontrado o status e o boleto
        if(!(count($status) == 1)) {
            throw new \Exception("Status ou boleto não encontrado");
        }

        // Retorno
        return $status[0];
    }


    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function editarStatusPelaNotificacao(array $data)
    {
        # Recuperando o status da notificação
        $status = $this->statusBoletoGnetRepository->findWhere(['codigo' => $data['status']]);

        # Recuperando o boleto da transação
        $boleto = $this->repository->findWhere(['gnet_charge' => $data['charge']]);

        # Verificando se foi encontrado o status e o boleto
        if(!(count($status) == 1 || count($boleto) == 1)) {
            throw new \Exception("Status ou boleto não encontrado");
        }

        # Alterando o status do boleto
        $boleto[0]->gnet_status_id = $status[0]->id;
        $boleto[0]->save();

        # Retorno
        return true;
    }


    /**
     * @return mixed
     */
    public function obtemModel()
    {
        return new Boleto();
    }
}
<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\DebitoRepository;

class DebitoAbertoAlunoService
{
    /**
     * @var DebitoRepository
     */
    private $repository;

    /**
     * DebitoAbertoAlunoService constructor.
     * @param DebitoRepository $repository
     */
    public function __construct(DebitoRepository $repository)
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
        # Definindo os relacionamentos
        $relacionamentos = [
            'taxa',
            'aluno'
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
    public function store(array $data)
    {
        #Salvando o registro pincipal
        $debito =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$debito) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Validando o Benefício
        if(isset($data['beneficios'])) {
            # Vinculando os beneficios
            $debito->beneficios()->attach($data['beneficios']);
        }

        #Retorno
        return $debito;
    }
}
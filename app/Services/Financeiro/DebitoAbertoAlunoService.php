<?php
namespace Seracademico\Services\Financeiro;

use Seracademico\Repositories\Financeiro\DebitoAbertoAlunoRepository;

class DebitoAbertoAlunoService
{
    /**
     * @var DebitoAbertoAlunoRepository
     */
    private $repository;

    /**
     * DebitoAbertoAlunoService constructor.
     * @param DebitoAbertoAlunoRepository $repository
     */
    public function __construct(DebitoAbertoAlunoRepository $repository)
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

        # Validando a taxa
        if(!isset($data['beneficios'])) {
            throw new \Exception('Você deve informa um Benefício!');
        }

        # Tratamento das taxas
        $beneficios = $data['beneficios'];
        unset($data['beneficios']);

        #Verificando se foi criado no banco de dados
        if(!$debito) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Vinculando os beneficios
        $debito->beneficios()->attach($beneficios);

        #Retorno
        return $debito;
    }
}
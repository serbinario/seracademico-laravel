<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Entities\Biblioteca\PrimeiraEntrada;
use Seracademico\Entities\Biblioteca\SegundaEntrada;
use Seracademico\Repositories\Biblioteca\ArcevoRepository;
use Seracademico\Entities\Biblioteca\Arcevo;
use Seracademico\Repositories\Biblioteca\PrimeiraEntradaRepository;
use Seracademico\Repositories\Biblioteca\SegundaEntradaRepository;

//use Carbon\Carbon;

class ArcevoPeriodicoService
{
    /**
     * @var ArcevoRepository
     */
    private $repository;

    /**
     * @var SegundaEntradaRepository
     */
    private $segundaRepository;

    /**
     * @var PrimeiraEntradaRepository
     */
    private $primeiraRepository;

    /**
     * @param ArcevoRepository $repository
     */
    public function __construct(ArcevoRepository $repository, SegundaEntradaRepository $segundaRepository,
                                PrimeiraEntradaRepository $primeiraRepository)
    {
        $this->repository = $repository;
        $this->segundaRepository = $segundaRepository;
        $this->primeiraRepository = $primeiraRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        $relacionamentos = [
            'tipoAcervo',
            'colecao',
            'genero',
            'situacao',
            'corredor',
            'estante',
            'exemplares',
            'primeiraEntrada.responsaveis'
        ];

        #Recuperando o registro no banco de dados
        $arcevo = $this->repository->with($relacionamentos)->find($id);
        $segundaEntrada = $this->segundaRepository->with(['tipoAutor', 'acervos'])->findWhere(['arcevos_id'=> $arcevo->id]);
        $primeiraEntrada = $this->primeiraRepository->findWhere(['arcevos_id'=> $arcevo->id]);

        $retorno = [
            "acervo" => $arcevo,
            'segundaEntrada' => $segundaEntrada,
            'primeiraEntrada' => $primeiraEntrada
        ];

        #Verificando se o registro foi encontrado
        if(!$arcevo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $retorno;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function countAcervo()
    {
        $arcevo = $this->repository->all();

        #Verificando se o registro foi encontrado
        if(!$arcevo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $arcevo;
    }


    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Arcevo
    {

        $this->tratamentoCampos($data);

        $data['numero_chamada'] = $data['cdd'];

        #Salvando o registro pincipal
        $arcevo =  $this->repository->create($data);
        
        #Verificando se foi criado no banco de dados
        if(!$arcevo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $arcevo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Arcevo
    {
        $this->tratamentoCampos($data);

        $data['numero_chamada'] = $data['cdd'];

        #Atualizando no banco de dados
        $arcevo = $this->repository->update($data, $id);

        if(isset($data['cursos'])){
            $arcevo->cursos()->detach();
            $arcevo->cursos()->attach($data['cursos']);
        }

        #Verificando se foi atualizado no banco de dados
        if(!$arcevo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $arcevo;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o responsável!');
        }

        #retorno
        return true;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
    {
        #Declarando variáveis de uso
        $result = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            #qualificando o namespace
            $nameModel = "Seracademico\\Entities\\$model";

            #Recuperando o registro e armazenando no array
            $result[strtolower($model)] = $nameModel::orderBy('nome')->lists('nome', 'id');
        }

        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array &$data) : array
    {
         #tratando as datas
         //$data[''] = $data[''] ? Carbon::createFromFormat("d/m/Y", $data['']) : "";

         #retorno
         return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                unset($data[$key]);
            }
        }
        #Retorno
        return $data;
    }
    
    
}
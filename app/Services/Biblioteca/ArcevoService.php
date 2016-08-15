<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Entities\Biblioteca\PrimeiraEntrada;
use Seracademico\Entities\Biblioteca\SegundaEntrada;
use Seracademico\Repositories\Biblioteca\ArcevoRepository;
use Seracademico\Entities\Biblioteca\Arcevo;
use Seracademico\Repositories\Biblioteca\PrimeiraEntradaRepository;
use Seracademico\Repositories\Biblioteca\SegundaEntradaRepository;

//use Carbon\Carbon;

class ArcevoService
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
            'primeiraEntrada.responsaveis',
            'segundaEntrada'
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
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find2($id) {

        $relacionamentos = [
            'tipoAcervo',
            'colecao',
            'genero',
            'situacao',
            'corredor',
            'estante',
            'exemplares',
            'cursos',
            'primeiraEntrada.responsaveis',
            'segundaEntrada'
        ];

        #Recuperando o registro no banco de dados
        $arcevo = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$arcevo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $arcevo;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function countAcervoNPeriodico()
    {
        $arcevo = \DB::table('bib_arcevos')
            ->where('tipo_periodico', '=', '1')
            ->select([
                \DB::raw('COUNT(id) as qtd_acervos_np'),
            ])->get();

        #Verificando se o registro foi encontrado
        if(!$arcevo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $arcevo[0];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function countAcervoPeriodico()
    {
        $arcevo = \DB::table('bib_arcevos')
            ->where('tipo_periodico', '=', '2')
            ->select([
                \DB::raw('COUNT(id) as qtd_acervos_p'),
            ])->get();

        #Verificando se o registro foi encontrado
        if(!$arcevo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $arcevo[0];
    }


    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Arcevo
    {

        $this->tratamentoCampos($data);
        $this->tratamentoCampos2($data);

        //dd($data);

        //campos da tabela de segunda entrada dos acervos
        $entradas = [
            'tipo_autor_id' => "",
            'responsaveis_id' => "",
            'arcevos_id'=> ""
        ];

        //dd($data);

        $data['numero_chamada'] = $data['cdd'] . " " . $data['cutter'];

        #Salvando o registro pincipal
        $arcevo =  $this->repository->create($data);

        if(isset($data['cursos'])){
            $arcevo->cursos()->attach($data['cursos']);
        }

        //Inserir primeira entrada do acervos
        if(count($data['primeira']['responsaveis_id']) > 0 ) {
            for($i = 0; $i < count($data['primeira']['responsaveis_id']); $i++){
                $entradas['responsaveis_id'] = $data['primeira']['responsaveis_id'][$i];
                $entradas['arcevos_id'] = $arcevo->id;
                $this->primeiraRepository->create($entradas);
            }
        }

        //Inserir segunda entrada do acervos
        if(count($data['segunda']['responsaveis_id']) > 0 &&
            count($data['segunda']['tipo_autor_id']) > 0  &&
            count($data['segunda']['responsaveis_id']) == count($data['segunda']['tipo_autor_id'])) {

            for($i = 0; $i < count($data['segunda']['responsaveis_id']); $i++){
                $entradas['tipo_autor_id'] = $data['segunda']['tipo_autor_id'][$i];
                $entradas['responsaveis_id'] = $data['segunda']['responsaveis_id'][$i];
                $entradas['arcevos_id'] = $arcevo->id;
                $this->segundaRepository->create($entradas);
            }
        }


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
        $this->tratamentoCampos2($data);

        //campos da tabela de segunda entrada dos acervos
        $entradas = [
            'tipo_autor_id' => "",
            'responsaveis_id' => "",
            'arcevos_id'=> ""
        ];

        $data['numero_chamada'] = $data['cdd'] . " " . $data['cutter'];

        #Atualizando no banco de dados
        $arcevo = $this->repository->update($data, $id);

        if(isset($data['cursos'])){
            $arcevo->cursos()->detach();
            $arcevo->cursos()->attach($data['cursos']);
        }

        //dd($data['primeira']['responsaveis_id']);
        //Inserir segunda entrada do acervos
        if(count($data['primeira']['responsaveis_id']) > 0) {

            PrimeiraEntrada::where('arcevos_id', $arcevo->id)->delete();
            //$this->primeiraRepository->delete($data['primeira']['responsaveis_id']);

            for($i = 0; $i < count($data['primeira']['responsaveis_id']); $i++){
                $entradas['responsaveis_id'] = $data['primeira']['responsaveis_id'][$i];
                $entradas['arcevos_id'] = $arcevo->id;
                $this->primeiraRepository->create($entradas);
            }
        } else if (count($data['primeira']['responsaveis_id']) <= 0) {
            PrimeiraEntrada::where('arcevos_id', $arcevo->id)->delete();
        }

        //Inserir segunda entrada do acervos
        if(count($data['segunda']['responsaveis_id']) > 0 &&
            count($data['segunda']['tipo_autor_id']) > 0  &&
            count($data['segunda']['responsaveis_id']) == count($data['segunda']['tipo_autor_id'])) {

            SegundaEntrada::where('arcevos_id', $arcevo->id)->delete();

            for($i = 0; $i < count($data['segunda']['responsaveis_id']); $i++){
                $entradas['tipo_autor_id'] = $data['segunda']['tipo_autor_id'][$i];
                $entradas['responsaveis_id'] = $data['segunda']['responsaveis_id'][$i];
                $entradas['arcevos_id'] = $arcevo->id;
                $this->segundaRepository->create($entradas);
            }
        } else if(count($data['segunda']['responsaveis_id']) <= 0) {
            SegundaEntrada::where('arcevos_id', $arcevo->id)->delete();
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

        $acervo = $this->find2($id);

        #excluir dependências
        $acervo->primeiraEntrada()->delete();
        $acervo->segundaEntrada()->delete();
        $acervo->cursos()->detach();

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
     * Método load
     *
     * Método responsável por recuperar todos os models (com seus repectivos
     * métodos personalizados para consulta, se for o caso) do array passado
     * por parâmetro.
     *
     * @param array $models || Melhorar esse código
     * @return array
     */
    public function load(array $models, $ajax = false) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->lists('nome', 'id');
                }
            }

            # Limpando a expressão
            $expressao = [];
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

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos2(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data['primeira']['responsaveis_id'] as $key => $value) {

            if ($value == null) {
                unset($data['primeira']['responsaveis_id'][$key]);
            }
        }

        # Tratamento de campos de chaves estrangeira
        foreach ($data['segunda']['responsaveis_id'] as $key => $value) {

            if ($value == null ) {
                unset($data['segunda']['responsaveis_id'][$key]);
            }
        }

        # Tratamento de campos de chaves estrangeira
        foreach ($data['segunda']['tipo_autor_id'] as $key => $value) {

            if ($value == null ) {
                unset($data['segunda']['tipo_autor_id'][$key]);
            }
        }
        #Retorno
        return $data;
    }
    
    
}
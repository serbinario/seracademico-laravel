<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Repositories\Biblioteca\EmprestarRepository;
use Seracademico\Entities\Biblioteca\Emprestar;
use Seracademico\Repositories\Biblioteca\ExemplarRepository;

//use Carbon\Carbon;

class EmprestarService
{
    /**
     * @var EmprestarRepository
     */
    private $repository;

    /**
     * @var ExemplarRepository
     */
    private $repoExemplar;

    /**
     * @param EmprestarRepository $repository
     */
    public function __construct(EmprestarRepository $repository, ExemplarRepository $repoExemplar)
    {
        $this->repository   = $repository;
        $this->repoExemplar = $repoExemplar;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $emprestar = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$emprestar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $emprestar;
    }
    
    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function dataDevolucao($request)
    {
        $dados     = $request;
        $dataObj   = new \DateTime('now');
        $dias      = "";
        $dia       = 0;

        if($dados['id_emp'] == '1') {
            $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '002')->get();
            $dia = $dias[0]->valor - 1;
        } else if ($dados['id_emp'] == '2') {
            $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '001')->get();
            $dia = $dias[0]->valor - 1;
        }

        $dataObj->add(new \DateInterval("P{$dia}D"));
        $data = $dataObj->format('d/m/Y');

        $dados = [
            'data' => $data
        ];
        
        return $dados;

    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Emprestar
    {
        //dd($data);

        $data = $this->tratamentoCamposData($data);

        $date = new \DateTime('now');
        $dataFormat = $date->format('Y-m-d');
        $codigo = \DB::table('bib_emprestimos')->max('codigo');
        $codigoMax = $codigo != null ? $codigoMax = $codigo + 1 : $codigoMax = "1";

        $data['data'] = $dataFormat;
        $data['codigo'] = $codigoMax;

        #Salvando o registro pincipal
        $emprestar =  $this->repository->create($data);

        $emprestar->emprestimoExemplar()->attach($data['id']);

        foreach ($data['id'] as $id) {
            $exemplar =  $this->repoExemplar->find($id);
            $exemplar->situacao_id = '5';
            $exemplar->save();
        }

        #Verificando se foi criado no banco de dados
        if(!$emprestar) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
       return $emprestar;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function devolucao(int $id)
    {
        #deletando o curso
        $emprestimo = $this->repository->find($id);

        $dataObj = new \DateTime("now");
        $data = $dataObj->format('Y-m-d');

        $emprestimo->data_devolucao_real = $data;
        $emprestimo->save();

        //dd($emprestimo->emprestimoExemplar);
        
        foreach ($emprestimo->emprestimoExemplar as $e) {
            $exemplar =  $this->repoExemplar->find($e->id);
            if($exemplar->emprestimo_id == '1') {
                $exemplar->situacao_id = '1';
                $exemplar->save();
            } elseif ($exemplar->emprestimo_id == '2') {
                $exemplar->situacao_id = '3';
                $exemplar->save();
            }
        }

        # Verificando se a execução foi bem sucessida
        if(!$emprestimo) {
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

            if(count($expressao) > 1) {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
            } else {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::lists('nome', 'id');
            }

            # Limpando a expressão
            $expressao = [];
         }

         #retorno
         return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function tratamentoCamposData($data)
    {
        #tratamento de datas do aluno
        $data['data_devolucao'] = $data['data_devolucao'] ? $this->convertDate($data['data_devolucao'], 'en') : "";
        $data['data_devolucao'] = $data['data_devolucao']->format('Y-m-d');

        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #retorno
        return $data;
    }

    /**
     * @param $date
     * @return bool|string
     */
    public function convertDate($date, $format)
    {
        #declarando variável de retorno
        $result = "";

        #convertendo a data
        if (!empty($date) && !empty($format)) {
            #Fazendo o tratamento por idioma
            switch ($format) {
                case 'pt-BR' : $result = date_create_from_format('Y-m-d', $date); break;
                case 'en'    : $result = date_create_from_format('d/m/Y', $date); break;
            }
        }

        #retorno
        return $result;
    }

    /**
     * @param Aluno $aluno
     */
    public function getWithDateFormatPtBr($aluno)
    {
        #validando as datas
        $aluno->data_devolucao   = $aluno->data_devolucao == '0000-00-00' ? "" : $aluno->data_devolucao;
        //$aluno->data_nasciemento = $aluno->data_nasciemento == '0000-00-00' ? "" : $aluno->data_nasciemento;

        #tratando as datas
        $aluno->data_devolucao   = date('d/m/Y', strtotime($aluno->data_devolucao));
        //$aluno->data_nasciemento = date('d/m/Y', strtotime($aluno->data_nasciemento));
        //$aluno->data_exame_nacional_um   = date('d/m/Y', strtotime($aluno->data_exame_nacional_um));
        //$aluno->data_exame_nacional_dois = date('d/m/Y', strtotime($aluno->data_exame_nacional_dois));

        #return
        return $aluno;
    }

}
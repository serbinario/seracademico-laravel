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
        $relacionamentos = [
            'emprestimoExemplar.acervo'
        ];

        #Recuperando o registro no banco de dados
        $emprestar = $this->repository->with($relacionamentos)->find($id);

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
    public function findWhere($dados)
    {
        $relacionamentos = [
            'emprestimoExemplar.acervo',
        ];

        #Recuperando o registro no banco de dados
        $emprestar = $this->repository->with($relacionamentos)->findWhere(['pessoas_id' => $dados['pessoas_id'], 'status' => '0']);

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
        $parametros = \DB::table('bib_parametros')->select('bib_parametros.*')->where('bib_parametros.codigo', '=', '003')->get();
        
        $return = [
            'data',
            'msg',
            'sucesso',
            'emprestimos'
        ];

        $validarEmprestimo = Emprestar::join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->where('bib_emprestimos_exemplares.exemplar_id', '=', $dados['id'])
            ->where('bib_emprestimos.status', '=', '0')
            ->select('bib_emprestimos_exemplares.*')
            ->get();

        /*$validarQtdEmprestimo = Emprestar::join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_emprestimos.status', '=', '0')
            ->groupBy('bib_emprestimos_exemplares.emprestimo_id')
            ->select([
                \DB::raw('count(bib_emprestimos_exemplares.emprestimo_id) as qtd')
            ])
            ->get();*/

        $validarQtdEmprestimo = Emprestar::join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_exemplares.situacao_id', '=', '5')
            ->groupBy('bib_emprestimos.pessoas_id')
            ->select([
                \DB::raw('count(bib_emprestimos_exemplares.emprestimo_id) as qtd'),
            ])
            ->get();

        if(count($validarEmprestimo) > 0) {
            $return[1] = 'Este exemplar já está sendo emprestado no momento';
            $return[2] = false;
            return $return;
        } else if (isset($validarQtdEmprestimo[0]) && $validarQtdEmprestimo[0]->qtd >= $parametros[0]->valor) {
            $return[1] = "Limite de até {$parametros[0]->valor} empréstimos foi atingido";
            $return[2] = false;
            return $return;
        }


        if($dados['tipo_emprestimo'] == '1') {
            $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '002')->get();
            $dia = $dias[0]->valor - 1;
        } else if ($dados['tipo_emprestimo'] == '2') {
            $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '001')->get();
            $dia = $dias[0]->valor - 1;
        }

        $dataObj->add(new \DateInterval("P{$dia}D"));
        $data = $dataObj->format('d/m/Y');
        $dados['data_devolucao'] = $data;

        $result = $this->store($dados);
        $empestimos = $this->findWhere($dados);
        //dd($empestimos[0]->emprestimoExemplar);
        $return[0] = $data;
        $return[2] = true;
        $return[3] = $empestimos[0]->emprestimoExemplar;
        
        return $return;

    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Emprestar
    {

        $data = $this->tratamentoCamposData($data);

        $date = new \DateTime('now');
        $dataFormat = $date->format('Y-m-d');
        //$codigo = \DB::table('bib_emprestimos')->max('codigo');
        $codigo = $date->format('YmdHis');
        $data['data'] = $dataFormat;
        $data['codigo'] = $codigo;
        $data['status'] = '0';

        $validarEmprestimo = $this->findWhere($data);
       // dd($validarEmprestimo[0]->emprestimoExemplar());
        #Salvando o registro pincipal
        if(count($validarEmprestimo) <= 0) {
            $emprestar =  $this->repository->create($data);
            $emprestar->emprestimoExemplar()->attach([$data['id']]);
        } else {
            $emprestar = $validarEmprestimo[0];
            $emprestar->emprestimoExemplar()->attach([$data['id']]);
        }

        $exemplar = $this->repoExemplar->find($data['id']);
        $exemplar->situacao_id = '5';
        $exemplar->save();

        #Verificando se foi criado no banco de dados
        if(!$emprestar) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $emprestar;
    }
    

    /**
     * @param $id
     * @return mixed
     */
    public function renovacao($id){

        $emprestimo = $this->repository->find($id);
        $dataObj   = \DateTime::createFromFormat('Y-m-d H:i:s', $emprestimo->data_devolucao);
        $dia       = 0;
        //dd($dataObj);
        if($emprestimo->tipo_emprestimo == '1') {
            $query = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '002')->get();
            $dia = $query[0]->valor - 1;
        } else if ($emprestimo->tipo_emprestimo == '2') {
            $query = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '001')->get();
            $dia = $query[0]->valor - 1;
        }

        $dataObj->add(new \DateInterval("P{$dia}D"));
        $data = $dataObj->format('Y-m-d');

        $emprestimo->data_devolucao = $data;
        $emprestimo->save();

        return $emprestimo;
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
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteEmprestimo($id, $id2)
    {

        $idExemplar = \DB::table('bib_emprestimos_exemplares')
            ->where('id', '=', $id2)
            ->select('bib_emprestimos_exemplares.exemplar_id')
        ->get();

        $exemplar = $this->repoExemplar->find($idExemplar[0]->exemplar_id);
        if($exemplar->emprestimo_id == '1') {
            $exemplar->situacao_id = '1';
            $exemplar->save();
        } elseif ($exemplar->emprestimo_id == '2') {
            $exemplar->situacao_id = '3';
            $exemplar->save();
        }

        \DB::table('bib_emprestimos_exemplares')
            ->where('id', '=', $id2)
            ->where('emprestimo_id', '=', $id)
            ->delete();
        
        #deletando o curso
        $emprestimo = $this->find($id);

       if(count($emprestimo->emprestimoExemplar) <= 1) {
           \DB::delete('delete from bib_emprestimos where id = ?', [$id]);
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
<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Repositories\Biblioteca\EmprestarRepository;
use Seracademico\Entities\Biblioteca\Emprestar;
use Seracademico\Repositories\Biblioteca\ExemplarRepository;
use Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepository;
use Seracademico\Services\Biblioteca\RNEmprestimos\EmprestimosChainOfResponsibility;
use Seracademico\Services\Biblioteca\RNEmprestimos\GerarDataDeDevolucaoDoEmprestimo;
use Seracademico\Services\Financeiro\DebitoService;

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
     * @var ExemplarRepository
     */
    private $emprestimoExemplar;

    /**
     * @var DebitoService
     */
    private $debitoService;

    /**
     * @param EmprestarRepository $repository
     * @param ExemplarRepository $repoExemplar
     * @param EmprestimoExemplarRepository $emprestimoExemplar
     * @param DebitoService $debitoService
     */
    public function __construct(EmprestarRepository $repository,
        ExemplarRepository $repoExemplar,
        EmprestimoExemplarRepository $emprestimoExemplar,
        DebitoService $debitoService)
    {
        $this->repository   = $repository;
        $this->repoExemplar = $repoExemplar;
        $this->emprestimoExemplar = $emprestimoExemplar;
        $this->debitoService = $debitoService;
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
    public function findWherePendencias()
    {
        $relacionamentos = [
            'pessoa'
        ];

        #Recuperando o registro no banco de dados
        $emprestar = $this->repository->with($relacionamentos)->findWhere(['status' => '0']);

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

        #Recuperando o registro no banco de dados
        $emprestar = \DB::table('bib_emprestimos')
        ->join('bib_emprestimos_exemplares', 'bib_emprestimos_exemplares.emprestimo_id', '=', 'bib_emprestimos.id')
        ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
        ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
        ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
        ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
        ->where('bib_emprestimos.status', '=', '0')
        ->select([
            'bib_arcevos.titulo',
            'bib_arcevos.cutter',
            'bib_arcevos.subtitulo',
            'bib_exemplares.edicao',
            \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo'),
            'bib_emprestimos.id as emprestimo_id',
            'bib_emprestimos_exemplares.id',
            'bib_emprestimos.tipo_pessoa',
            'bib_emprestimos.emprestimo_especial',
            'pessoas.id as pessoa_id',
            'pessoas.nome as pessoa_nome',
        ])->get();

        #retorno
        return $emprestar;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function findEmpretimoEmAndamento($dados)
    {
        #Recuperando o registro no banco de dados
        $emprestar = $this->repository->findWhere(['pessoas_id' => $dados['pessoas_id'], 'status' => '0']);

        #Verificando se o registro foi encontrado
        if(!$emprestar) {
            throw new \Exception('Empresa não encontrada!');
        }

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
        $dataObj->setTimezone( new \DateTimeZone('UTC') );
        
        # Array para retorno da requisição ajax
        $return = [
            'data',
            'msg',
            'sucesso',
            'emprestimos'
        ];

        // Regras de negócio para validação do empréstimo
        if($resultChain = EmprestimosChainOfResponsibility::processChain($dados, $dataObj, $return)) {
            return $resultChain;
        }

        // Determinando a data de vecimento do empréstimo
        $dados['data_devolucao'] = GerarDataDeDevolucaoDoEmprestimo::getResult($dataObj, $dados);

        //Salvando os emprestimos no banco
        $this->store($dados);

        //Recuperando o emprestimo atual para ser listada novamente ao dar refresh na página
        $empestimos = $this->findWhere($dados);
        $return[0] = $dataObj->format('d/m/Y');
        $return[2] = true;
        $return[3] = $empestimos;
        
        return $return;

    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Emprestar
    {
        $data = $this->tratamentoCamposData($data);

        // Gerando o código do empréstimo
        $date = new \DateTime('now');
        $dataFormat = $date->format('Y-m-d');
        $codigo = $date->format('YmdHis');

       // dd($codigo);
        $data['data'] = $dataFormat;
        $data['codigo'] = $codigo;
        $data['status'] = '0';
        $data['status_devolucao'] = '0';
        $data['status_pagamento'] = '0';
        $data['emprestimo_especial'] = isset($data['emprestimo_especial']) ? $data['emprestimo_especial'] : "0";

        //busca o registro do emprestimo que está sendo usando no momento
        $emprestimo = $this->findEmpretimoEmAndamento($data);

        #Salvando o registro pincipal (caso aja um registro já sendo usado, não será feito um novo registro)
        if(count($emprestimo) <= 0) {
            //dd($data);
            $emprestar =  $this->repository->create($data);

            $emprestar->emprestimoExemplar()->attach([$data['id']]);
        } else {
            $emprestar = $emprestimo[0];
            //dd($data);
            $emprestar->emprestimoExemplar()->attach([$data['id']]);
        }
        //dd($data);
        //Alterando a situação do emprestimo para emprestado
        //dd($data);
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
    public function renovacao($id) {

        $this->devolucao($id);

        $emprestimo = $this->repository->find($id);


        $dataObj   = new \DateTime('now');

        $dia       = 0;

        # Pegas os parâmetros para saber a quantidade de dias de empréstimo por tipo de pessoa
        $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')
        ->whereIn('bib_parametros.codigo', ['002', '006', '008'])->get();

        //Validando se algum dos livros emprestados está sem reserva
        foreach ($emprestimo->emprestimoExemplar as $exemplar) {


            $validarReserva = \DB::table('bib_reservas_exemplares')
            ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->join('bib_exemplares', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_exemplares.id', '=', $exemplar->id)
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->select([
                'bib_exemplares.id'
            ])->first();

            if($validarReserva) {
                return false;
            }

        }

        # Gerando a data de devolução conforme a situação de emprestimo do livro
        if($emprestimo->tipo_emprestimo == '1' && $emprestimo->emprestimo_especial == '0') {
            if($emprestimo->tipo_pessoa == '1') {
                $dia = $dias[0]->valor;
            } else if ($emprestimo->tipo_pessoa == '2' || $emprestimo->tipo_pessoa == '3') {
                $dia = $dias[2]->valor - 1;
            } else if ($emprestimo->tipo_pessoa == '4') {
                $dia = $dias[1]->valor;
            }
        } else if ($emprestimo->tipo_emprestimo == '2' || $emprestimo->emprestimo_especial == '1') {
            $query = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '001')->get();
            $dia = $query[0]->valor - 1;
        }



        $dataObj->add(new \DateInterval("P{$dia}D"));
        $data = $dataObj->format('Y-m-d');
        $dataAtual = new \DateTime('now');
        $dataFormat = $dataAtual->format('Y-m-d');        


        $emprestimo->data_devolucao = $data;
        $emprestimo->data = $dataFormat;
        $data = [
            'data'              =>  $emprestimo->data,
            'codigo'            =>  $dataObj->format('YmdHis'),
            'data_devolucao'    =>  $emprestimo->data_devolucao,
            'pessoas_id'        =>  $emprestimo->pessoas_id,
            'tipo_emprestimo'   =>  $emprestimo->tipo_emprestimo,
            'status'            =>  '1',
            'users_id'          =>  $emprestimo->users_id,
            'status_devolucao'  =>  $emprestimo->status_devolucao,
            'emprestimo_especial'=> $emprestimo->emprestimo_especial,
            'tipo_pessoa'       =>  $emprestimo->tipo_pessoa,
            'valor_multa'       =>  $emprestimo->valor_multa,
            'status_pagamento'  =>  $emprestimo->status_pagamento
        ];

        $emprestar = $this->repository->create($data);

        $exemplares = $emprestimo->emprestimoExemplar;

        foreach ($exemplares as $exemplar){
            $emprestar->emprestimoExemplar()->attach([$exemplar->id]);
        }

        /*$emprestimo->save();*/

        /*$exemplar->save();*/


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

        $parametros = \DB::table('fin_parametros')
        ->join('fin_taxas', 'fin_taxas.id', '=', 'fin_parametros.taxa_id')
        ->whereIn('fin_parametros.codigo', ['001', '002'])->select(['fin_taxas.valor'])->get();

        $valorConsulta   = isset($parametros[0]) ? $parametros[0]->valor : "";
        $valorNormal     = isset($parametros[1]) ? $parametros[1]->valor : "";
        $multa           = "";

        if(strtotime($emprestimo->data_devolucao) < strtotime($data)) {
            $time_inicial = strtotime($emprestimo->data_devolucao);
            $time_final = strtotime($data);

            // Calcula a diferença de segundos entre as duas datas:
            $diferenca = $time_final - $time_inicial; // 19522800 segundos

            // Calcula a diferença de dias
            $dias = (int) floor( $diferenca / (60 * 60 * 24)); // 225 dias

            //pegando a quantidade de exemplares emprestados
            $qtdExemplar = count($emprestimo->emprestimoExemplar);

            // Calculando a multa geral do atraso
            if($emprestimo->tipo_emprestimo == '1' && $emprestimo->emprestimo_especial == '0') {
                $multa = ($valorNormal * $qtdExemplar) * $dias;
            } else if ($emprestimo->tipo_emprestimo == '2' || $emprestimo->emprestimo_especial == '1') {
                $multa = ($valorConsulta * $qtdExemplar) * $dias;
            }

            // Calculando multa por exemplar
            foreach ($emprestimo->exemplaresPivot as $exemplar) {
                $multaPorExemplar = 0;
                if($emprestimo->tipo_emprestimo == '1' && $emprestimo->emprestimo_especial == "0") {
                    $multaPorExemplar = $valorNormal * $dias;
                } else if ($emprestimo->tipo_emprestimo == '2' || $emprestimo->emprestimo_especial == '1') {
                    $multaPorExemplar = $valorConsulta * $dias;
                }

                $exemplar->valor_multa = $multaPorExemplar;
                $exemplar->save();
            }

            $emprestimo->valor_multa = $multa;
        }

        // Setando data e status de devolução
        $emprestimo->data_devolucao_real = $data;
        $emprestimo->status_devolucao = '1';
        $emprestimo->status_pagamento = $multa ? '0' : '1';
        $emprestimo->save();

        // Alterando o status dos exemplares a serem devolvidos
        foreach ($emprestimo->emprestimoExemplar as $e) {
            $exemplar =  $this->repoExemplar->find($e->id);
            if ($exemplar->emprestimo_id == '1') {
                $exemplar->situacao_id = '1';
                $exemplar->save();
            } else if ($exemplar->emprestimo_id == '2') {
                $exemplar->situacao_id = '3';
                $exemplar->save();
            }
        }

        # Verificando se a execução foi bem sucessida
        if(!$emprestimo) {
            throw new \Exception('Ocorreu um erro ao tentar remover o responsável!');
        }

        #retorno
        return $emprestimo;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function devolucaoPorAluno(int $id)
    {
        #recuperando os emprestimos dessa pessoa
        $emprestimos = $this->repository->with(['emprestimoExemplar.acervo'])->findWhere(['pessoas_id' => $id,
            'status' => '1', 'status_devolucao' => '0']);

        $dataObj = new \DateTime("now");
        $data = $dataObj->format('Y-m-d');

        $parametros = \DB::table('fin_parametros')
        ->join('fin_taxas', 'fin_taxas.id', '=', 'fin_parametros.taxa_id')
        ->whereIn('fin_parametros.codigo', ['001', '002'])->select(['fin_taxas.valor'])->get();

        $valorConsulta   = isset($parametros[0]) ? $parametros[0]->valor : "";
        $valorNormal     = isset($parametros[1]) ? $parametros[1]->valor : "";
        $multaTotal      = 0;
        $idEmprestimos   = [];

        foreach ($emprestimos as $chave => $emprestimo) {

            // Validando se o empréstimo está vencido ou não
            if(strtotime($emprestimo->data_devolucao) < strtotime($data)) {
                $time_inicial = strtotime($emprestimo->data_devolucao);
                $time_final = strtotime($data);

                // Calcula a diferença de segundos entre as duas datas:
                $diferenca = $time_final - $time_inicial; // 19522800 segundos

                // Calcula a diferença de dias
                $dias = (int) floor( $diferenca / (60 * 60 * 24)); // 225 dias

                //pegando a quantidade de exemplares emprestados
                $qtdExemplar = count($emprestimo->emprestimoExemplar);

                if($emprestimo->tipo_emprestimo == '1' && $emprestimo->emprestimo_especial == "0") {
                    $multa = ($valorNormal * $qtdExemplar) * $dias;
                } else if ($emprestimo->tipo_emprestimo == '2' || $emprestimo->emprestimo_especial == '1') {
                    $multa = ($valorConsulta * $qtdExemplar) * $dias;
                }

                // Calculando multa por exemplar
                foreach ($emprestimo->exemplaresPivot as $exemplar) {
                    $multaPorExemplar = 0;
                    if($emprestimo->tipo_emprestimo == '1' && $emprestimo->emprestimo_especial == "0") {
                        $multaPorExemplar = $valorNormal * $dias;
                    } else if ($emprestimo->tipo_emprestimo == '2' || $emprestimo->emprestimo_especial == '1') {
                        $multaPorExemplar = $valorConsulta * $dias;
                    }

                    // Setando e salvando o valor da multa no exemplar
                    $exemplar->valor_multa = $multaPorExemplar;
                    $exemplar->save();
                }

                $multaTotal = $multaTotal + $multa;
                $emprestimo->valor_multa = $multa;

            }

            //Armazenando as os ids dos empréstimos
            $idEmprestimos[] = $emprestimo->id;
        }

        foreach ($emprestimos as $emprestimo) {

            // Setando data e status de devolução
            $emprestimo->data_devolucao_real = $data;
            $emprestimo->status_devolucao = '1';
            $emprestimo->status_pagamento = $multaTotal ? '1' : '0';
            $emprestimo->save();

            // Alterando o status dos exemplares a serem devolvidos
            foreach ($emprestimo->emprestimoExemplar as $e) {
                $exemplar =  $this->repoExemplar->find($e->id);
                if($exemplar->emprestimo_id == '1') {
                    $exemplar->situacao_id = '1';
                    $exemplar->save();
                } else if ($exemplar->emprestimo_id == '2') {
                    $exemplar->situacao_id = '3';
                    $exemplar->save();
                }
            }
            
        }

        # Verificando se a execução foi bem sucessida
        if(count($idEmprestimos) <= 0) {
            throw new \Exception('Ocorreu um erro ao tentar remover o responsável!');
        }

        #retorno
        return ['idEmprestimo' => $idEmprestimos, 'toltaMulta' => $multaTotal];
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteEmprestimo($id, $id2)
    {

        // Buscando o registro de pivot de empréstimo e exemplar
        $idExemplar = \DB::table('bib_emprestimos_exemplares')
        ->where('id', '=', $id2)
        ->select('bib_emprestimos_exemplares.exemplar_id')
        ->first();

        // Buscando o exemplar
        $exemplar = $this->repoExemplar->find($idExemplar->exemplar_id);
        // Alterando o status do exemplar para disponível ou indisponivel
        if($exemplar->emprestimo_id == '1') {
            $exemplar->situacao_id = '1';
            $exemplar->save();
        } elseif ($exemplar->emprestimo_id == '2') {
            $exemplar->situacao_id = '3';
            $exemplar->save();
        }

        // Deletando o registro de pivot de empréstimo e exemplar
        \DB::table('bib_emprestimos_exemplares')
        ->where('id', '=', $id2)
        ->where('emprestimo_id', '=', $id)
        ->delete();
        
        #Buscando o empréstimo
        $emprestimo = $this->find($id);

        // Validando se o empréstimo ainda tem algum exemplar contido nele
        // Caso não tenha o registro de empréstimo também será deletado
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

}
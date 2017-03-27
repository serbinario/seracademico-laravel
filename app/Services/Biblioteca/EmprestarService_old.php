<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Repositories\Biblioteca\EmprestarRepository;
use Seracademico\Entities\Biblioteca\Emprestar;
use Seracademico\Repositories\Biblioteca\ExemplarRepository;
use Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepository;

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
     * @param EmprestarRepository $repository
     */
    public function __construct(EmprestarRepository $repository, ExemplarRepository $repoExemplar,
                                EmprestimoExemplarRepository $emprestimoExemplar)
    {
        $this->repository   = $repository;
        $this->repoExemplar = $repoExemplar;
        $this->emprestimoExemplar = $emprestimoExemplar;
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
        $dataObj->setTimezone( new \DateTimeZone('BRT') );

        $tipoPessoa = isset($dados['tipo_pessoa']) ? $dados['tipo_pessoa'] : "";
        $dia       = 0;
        $emprestimoEspecial = $dados['emprestimo_especial'] ? $dados['emprestimo_especial'] : "0";

        # Pegas os parâmetros para saber a quantidade de exemplares por tipo de pessoa
        $qtdEmprestimos = \DB::table('bib_parametros')->select('bib_parametros.*')
            ->whereIn('bib_parametros.codigo',['003', '007', '009'] )->get();
        # Pegas os parâmetros para saber a quantidade de dias de empréstimo por tipo de pessoa
        $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')
            ->whereIn('bib_parametros.codigo', ['002', '006', '008'])->get();

        # Array para retorno da requisição ajax
        $return = [
            'data',
            'msg',
            'sucesso',
            'emprestimos'
        ];

        //validando se a pessoa possui empréstimo em atraso
        /*$emprestimoAtraso = Emprestar::where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->whereDate('bib_emprestimos.data_devolucao', '<', $dataObj->format('Y-m-d'))
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->orWhere('bib_emprestimos.status_pagamento', '=', '1')
            ->select('bib_emprestimos.*')
            ->first();*/

        //Buscando o exemplar que esteja sendo emprestado
        /*$validarEmprestimo = Emprestar::join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->where('bib_emprestimos_exemplares.exemplar_id', '=', $dados['id'])
            ->where('bib_emprestimos.status', '=', '0')
            ->select('bib_emprestimos_exemplares.*')
            ->get();*/

        //Busca quantidade de emprestimos do aluno
        /*$validarQtdEmprestimo = Emprestar::join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_exemplares.situacao_id', '=', '5')
            ->groupBy('bib_emprestimos.pessoas_id')
            ->select([
                \DB::raw('count(bib_emprestimos_exemplares.emprestimo_id) as qtd'),
            ])
            ->first();*/

        //Validando se o examplar a ser selecionado é do mesmo título e cutter
        /*$validarAcervo = Emprestar::join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.id', '=', $dados['acervo_id'])
            ->where('bib_arcevos.titulo', '=', $dados['titulo'])
            ->where('bib_arcevos.cutter', '=', $dados['cutter'])
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->whereIn('bib_emprestimos.status', [0,1])
            ->select('bib_emprestimos_exemplares.id')
            ->first();*/

        //Validando se algum dos livros emprestados está sem reserva
        /*$validarReserva = \DB::table('bib_reservas_exemplares')
            ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->join('bib_exemplares', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_exemplares.id', '=', $dados['id'])
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->where('bib_reservas.data_vencimento', '>', $dataObj->format('Y-m-d H:i:s'))
            ->select([
                'bib_exemplares.id'
            ])->first();*/

        //Verifica se o exemplar está sendo emprestado, e se o limite de emprestimos foi atingido
        if ($emprestimoAtraso) {
            $return[1] = "Esta pessoa possui um empréstimo em atraso";
            $return[2] = false;
            return $return;
        } else if (count($validarEmprestimo) > 0) {
            $return[1] = 'Este exemplar já está sendo emprestado no momento';
            $return[2] = false;
            return $return;
        } else if ($validarQtdEmprestimo && $tipoPessoa == '1' && $validarQtdEmprestimo->qtd >= $qtdEmprestimos[0]->valor) { # Aluno Graduação
            $return[1] = "Limite de até {$qtdEmprestimos[0]->valor} empréstimos foi atingido";
            $return[2] = false;
            return $return;
        } else if ($validarQtdEmprestimo && ($tipoPessoa == '2' || $tipoPessoa == '3')
            && $validarQtdEmprestimo->qtd >= $qtdEmprestimos[2]->valor) {  # Aluno pós-graduação, mestrado, doutorado
            $return[1] = "Limite de até {$qtdEmprestimos[2]->valor} empréstimos foi atingido";
            $return[2] = false;
            return $return;
        } else if ($validarQtdEmprestimo && $tipoPessoa == '4' && $validarQtdEmprestimo->qtd >= $qtdEmprestimos[1]->valor) { # Professores
            $return[1] = "Limite de até {$qtdEmprestimos[1]->valor} empréstimos foi atingido";
            $return[2] = false;
            return $return;
        } else if ($validarAcervo) {
            $return[1] = "Este exemplar já foi incluído em um empréstimo ativo da pessoa!";
            $return[2] = false;
            return $return;
        } else if ($validarReserva) {
            $return[1] = "Não será possível o empréstimo desse livro, pois o mesmo está em reserva!";
            $return[2] = false;
            return $return;
        }

        //Gerando a data de devolução conforme a situação de emprestimo do livro
        if($dados['tipo_emprestimo'] == '1' && $emprestimoEspecial == '0') {
            if($tipoPessoa == '1') {
                $dia = $dias[0]->valor;
            } else if ($tipoPessoa == '2' || $tipoPessoa == '3') {
                $dia = $dias[2]->valor - 1;
            } else if ($tipoPessoa == '4') {
                $dia = $dias[1]->valor;
            }
        } else if ($dados['tipo_emprestimo'] == '2' || $emprestimoEspecial == '1') {
            $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '001')->get();
            $dia = $dias[0]->valor - 1;
        }

        $dataObj->add(new \DateInterval("P{$dia}D"));
        $dados['data_devolucao'] = $dataObj->format('Y-m-d');

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

        $date = new \DateTime('now');
        $dataFormat = $date->format('Y-m-d');
        //$codigo = \DB::table('bib_emprestimos')->max('codigo');
        $codigo = $date->format('YmdHis');
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
            $emprestar =  $this->repository->create($data);
            $emprestar->emprestimoExemplar()->attach([$data['id']]);
        } else {
            $emprestar = $emprestimo[0];
            $emprestar->emprestimoExemplar()->attach([$data['id']]);
        }

        //Alterando a situação do emprestimo para emprestado
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
        $dataObj   = \DateTime::createFromFormat('Y-m-d', $emprestimo->data_devolucao);
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

        $parametros = \DB::table('bib_parametros')->where('codigo', '=', '004')->orWhere('codigo', '=', '005')->get();

        $valorNormal     = isset($parametros[0]) ? $parametros[0]->valor : "";
        $valorConsulta   = isset($parametros[1]) ? $parametros[1]->valor : "";
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
        $emprestimo->status_pagamento = $multa ? '1' : '0';
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

        $parametros = \DB::table('bib_parametros')->where('codigo', '=', '006')->orWhere('codigo', '=', '007')->get();

        // Pegando os valores das multas contidas no banco de dados
        $valorNormal     = isset($parametros[0]) ? $parametros[0]->valor : "";
        $valorConsulta   = isset($parametros[1]) ? $parametros[1]->valor : "";
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
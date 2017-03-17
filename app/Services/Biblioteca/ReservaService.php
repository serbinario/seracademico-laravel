<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Entities\Biblioteca\Exemplar;
use Seracademico\Repositories\Biblioteca\ArcevoRepository;
use Seracademico\Repositories\Biblioteca\EmprestarRepository;
use Seracademico\Repositories\Biblioteca\ExemplarRepository;
use Seracademico\Repositories\Biblioteca\ReservaExemplarRepository;
use Seracademico\Repositories\Biblioteca\ReservaRepository;
use Seracademico\Entities\Biblioteca\Reserva;
use Seracademico\Entities\Biblioteca\ReservaExemplar;
//use Carbon\Carbon;

class ReservaService
{
    /**
     * @var ReservaRepository
     */
    private $repository;

    /**
     * @var ArcevoRepository
     */
    private $repoAcervo;

    /**
     * @var ReservaExemplarRepository
     */
    private $repoReseExemp;

    /**
     * @var EmprestarRepository
     */
    private $repoEmprestar;

    /**
     * @var ExemplarRepository
     */
    private $repoExemplar;

    /**
     * @param ReservaRepository $repository
     */
    public function __construct(ReservaRepository $repository, 
                                ArcevoRepository $repoAcervo, 
                                ReservaExemplarRepository $repoReseExemp,
                                EmprestarRepository $repoEmprestar, ExemplarRepository $repoExemplar)
    {
        $this->repository = $repository;
        $this->repoAcervo = $repoAcervo;
        $this->repoReseExemp = $repoReseExemp;
        $this->repoEmprestar = $repoEmprestar;
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
        $reserva = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$reserva) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $reserva;
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
        $reservar = $this->repository->with($relacionamentos)->findWhere(['status' => '0']);

        #Verificando se o registro foi encontrado
        if(!$reservar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $reservar;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findWhere($dados)
    {
        $relacionamentos = [
            'reservaExemplar',
            'pessoa'
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
     * @param array $data
     * @return array
     */
    public function store(array $data)
    {

        $date = new \DateTime('now');
        $date->setTimezone( new \DateTimeZone('BRT') );
        $dataFormat = $date->format('Y-m-d H:i:s');

        // Preenchendo os dados da reserva
        $codigo = $date->format('YmdHis');
        $data['data'] = $dataFormat;
        $data['data_vencimento'] = $date->add(new \DateInterval("P1D"))->format('Y-m-d H:i:s');
        $data['codigo'] = $codigo;
        $data['status'] = '0';
        $tipoPessoa = isset($data['tipo_pessoa']) ? $data['tipo_pessoa'] : "";
        $data['emprestimo_especial'] = $data['emprestimo_especial'] ? $data['emprestimo_especial'] : "0";

        # Pegas os parâmetros para saber a quantidade de exemplares por tipo de pessoa
        $qtdReservas = \DB::table('bib_parametros')->select('bib_parametros.*')
            ->whereIn('bib_parametros.codigo',['003', '007', '009'] )->get();

        # Array para retorno da requisição ajax
        $return = [
            'msg',
            'sucesso',
            'reserva'
        ];

        //validando se a pessoa possui empréstimo em atraso
        $emprestimoAtraso = \DB::table('bib_emprestimos')->
        where('bib_emprestimos.pessoas_id', '=', $data['pessoas_id'])
            ->whereDate('bib_emprestimos.data_devolucao', '<', $dataFormat)
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->orWhere('bib_emprestimos.status_pagamento', '=', '1')
            ->select('bib_emprestimos.*')
            ->first();

        //Busca quantidade de reserva do aluno
        $validarQtdReserva = Reserva::join('bib_reservas_exemplares', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->where('bib_reservas.pessoas_id', '=', $data['pessoas_id'])
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->groupBy('bib_reservas.pessoas_id')
            ->select([
                \DB::raw('count(bib_reservas_exemplares.reserva_id) as qtd'),
            ])
            ->first();

        //Verificando se a pessoa está tentando reservar um livro que o mesmo já tenha pego emprestado
        $acervoEmprestado = \DB::table('bib_emprestimos_exemplares')
            ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.id', '=', $data['id_acervo'])
            ->where('bib_emprestimos.pessoas_id', '=', $data['pessoas_id'])
            ->where('bib_emprestimos.status', '=', '1')
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->select([
                'bib_arcevos.id'
            ])->first();

        //Valida se a quantidade de reserva atinge o limite máximo, ou se a pessoa possui empréstimo em atraso
        if ($emprestimoAtraso) {
            $return[1] = "Esta pessoa possui empréstimo em atraso!";
            $return[2] = false;
            return $return;
        } else if ($validarQtdReserva && $tipoPessoa == '1' && $validarQtdReserva->qtd >= $qtdReservas[0]->valor) { # Aluno Graduação
            $return[1] = "Limite de até {$qtdReservas[0]->valor} reservas foi atingido";
            $return[2] = false;
            return $return;
        } else if ($validarQtdReserva && ($tipoPessoa == '2' || $tipoPessoa == '3')
            && $validarQtdReserva->qtd >= $qtdReservas[2]->valor) {  # Aluno pós-graduação, mestrado, doutorado
            $return[1] = "Limite de até {$qtdReservas[2]->valor} reservas foi atingido";
            $return[2] = false;
            return $return;
        } else if ($validarQtdReserva && $tipoPessoa == '4' && $validarQtdReserva->qtd >= $qtdReservas[1]->valor) { # Professores
            $return[1] = "Limite de até {$qtdReservas[1]->valor} reservas foi atingido";
            $return[2] = false;
            return $return;
        } else if ($acervoEmprestado) {
            $return[1] = "Este livro consta como emprestado para esta pessoa!";
            $return[2] = false;
            return $return;
        }

        //busca o registro de reserva que está sendo usando no momento para reservas
        $validarReserva = $this->findWhere($data);

        #Salvando o registro principal (caso aja um registro já sendo usado, não será feito um novo registro)
        if(count($validarReserva) <= 0) {
            $reserva =  $this->repository->create($data);
            $reserva->reservaExemplar()->attach($data['id_acervo']);
        } else {
            $reserva = $validarReserva[0];
            $reserva->reservaExemplar()->attach($data['id_acervo']);
        }

        //Atualizando as reservas para status em que ainda n foi feito emprestimos para as mesmas de acordo com a edição
       // if ($data['edicao'] != 'null') {
        $reservaExem = $this->repoReseExemp->findWhere(['reserva_id' => $reserva->id, 'arcevos_id' => $data['id_acervo']]);
        $reservaExem[0]->edicao = $data['edicao'];
        $reservaExem[0]->status = 0;

        //Validar se já existe reserva para esse acervo
        $existeReserva = \DB::table('bib_reservas')
            ->join('bib_reservas_exemplares', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->where('bib_reservas.pessoas_id', '!=', $data['pessoas_id'])
            ->where('bib_reservas_exemplares.arcevos_id', '=', $data['id_acervo'])
            ->where('bib_reservas_exemplares.edicao', '=', $data['edicao'])
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->select([
                'bib_arcevos.id'
            ])->first();

        // Se exister reserva ativa para esse acervo, a pessoa receberá um status para fila de reserva para esse acervo
        if($existeReserva) {
            $reservaExem[0]->status_fila = 0;
        } else {
            $reservaExem[0]->status_fila = 1;
        }

        //Salva o registro do acervo na relacionado a reserva
        $reservaExem[0]->save();


        //Recuperando a reserva atual para ser listada novamente ao dar refresh na página
        $reservas = $this->findWhere($data);
        $return[1] = true;
        $return[2] = $reservas[0]->reservaExemplar;

        #Verificando se foi criado no banco de dados
        if(!$reserva) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $return;
    }

    public function deleteReserva($id, $id2)
    {

        //Deletando reserva
        \DB::table('bib_reservas_exemplares')
            ->where('id', '=', $id2)
            ->where('reserva_id', '=', $id)
            ->delete();

        #deletando o curso
        $reserva = $this->find($id);

        if(count($reserva->reservaExemplar) <= 1) {
            \DB::delete('delete from bib_reservas where id = ?', [$id]);
        }

        #retorno
        return true;
    }

    /**
     * @param array $data
     */
    public function saveEmprestimo(array $data)
    {
        $user = \Auth::user();
        $date = new \DateTime('now');
        $dataFormat = $date->format('Y-m-d');
        $codigo = $date->format('YmdHis');
        $dia       = 0;

        # Pegas os parâmetros para saber a quantidade de dias de empréstimo por tipo de pessoa
        $dias = \DB::table('bib_parametros')->select('bib_parametros.valor')
            ->whereIn('bib_parametros.codigo', ['002', '006', '008'])->get();

        $emprestimo = array();
        $exemplares = array();

        // Preenche os dados para empréstimos
        $emprestimo['data'] = $dataFormat;
        $emprestimo['codigo'] = $codigo;
        $emprestimo['pessoas_id'] = $data['id_pessoa'];
        $emprestimo['tipo_emprestimo'] = $data['tipo_emprestimo'];
        $emprestimo['status'] = '1';
        $emprestimo['status_devolucao'] = '0';
        $emprestimo['status_pagamento'] = '0';
        $emprestimo['tipo_pessoa'] = $data['tipo_pessoa'];
        $emprestimo['users_id'] = $user->id;

        // Pega os exemplares a serem emprestados
        for ($i = 0; $i < count($data['id']); $i++) {

            $exemplar = Exemplar::join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->join('bib_reservas_exemplares', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
                ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
                ->where('bib_reservas.id', '=', $data['id_reserva'])
                ->where('bib_arcevos.id', '=', $data['id'][$i])
                ->where('bib_exemplares.situacao_id', '=', '1')
                ->orWhere('bib_exemplares.situacao_id', '=', '3')
                ->where('bib_exemplares.edicao', '=', $data['edicao'][$i])
                ->where('bib_exemplares.exemp_principal', '=', '0')
                ->select(
                    ['bib_exemplares.*',
                    ])->first();

               $exemplares[] = $exemplar->id;

        }

        // Faz a contagem de dias para entrega dos livros conforme a situação do livro, se livro de consulta ou não
        if($data['tipo_emprestimo'] == '1' && $data['emprestimoEspecial'] == '0') {
            if($data['tipo_pessoa'] == '1') {
                $dia = $dias[0]->valor;
            } else if ($data['tipo_pessoa'] == '2' || $data['tipo_pessoa'] == '3') {
                $dia = $dias[2]->valor - 1;
            } else if ($data['tipo_pessoa'] == '4') {
                $dia = $dias[1]->valor;
            }
        } else if ($data['tipo_emprestimo'] == '2' || $data['emprestimoEspecial'] == '1' ) {
            $query = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '001')->get();
            $dia = $query[0]->valor - 1;
        }

        // Atribuindo a data de devolução e se é empréstimo especial
        $date->add(new \DateInterval("P{$dia}D"));
        $dataDevolucao = $date->format('Y-m-d');
        $emprestimo['data_devolucao'] = $dataDevolucao;
        $emprestimo['emprestimo_especial'] = $data['emprestimoEspecial'];

        // Salvando o empréstimo e adicioando os exemplares
        $emprestar =  $this->repoEmprestar->create($emprestimo);
        $emprestar->emprestimoExemplar()->attach($exemplares);

        // Mudando a situação dos exemplares emprestados para situação de emprestado
        foreach ($exemplares as $id) {
            $exemplar = $this->repoExemplar->find($id);
            $exemplar->situacao_id = '5';
            $exemplar->save();
        }

        // Mudanso a situação do registro de pivot de exemplares e empréstimos
        for ($i = 0; $i < count($data['id']); $i++) {
                $reservaExem =  $this->repoReseExemp->findWhere(['reserva_id' => $data['id_reserva'], 'arcevos_id' => $data['id'][$i]]);
                $reservaExem[0]->status = 1;
                $reservaExem[0]->status_fila = 2;
                $reservaExem[0]->save();
        }

        #Retorno
        return $emprestar;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Reserva
    {
        #Atualizando no banco de dados
        $reserva = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$reserva) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $reserva;
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

}
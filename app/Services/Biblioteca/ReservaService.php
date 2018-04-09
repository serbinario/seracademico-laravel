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
use Seracademico\Services\Biblioteca\RNEmprestimos\GerarDataDeDevolucaoDoEmprestimo;
use Seracademico\Services\Biblioteca\RNReservas\ReservasChainOfResponsibility;

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
        $date->setTimezone( new \DateTimeZone('UTC') );
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

        // Regras de nogócio para validação da reserva
        if($resultChain = ReservasChainOfResponsibility::processChain($data, $dataFormat, $return)) {
            return $resultChain;
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
        $emprestimo['emprestimo_especial'] = $data['emprestimoEspecial'];

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

        // Determinando a data de vecimento do empréstimo
        $emprestimo['data_devolucao'] = GerarDataDeDevolucaoDoEmprestimo::getResult($date, $emprestimo);

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
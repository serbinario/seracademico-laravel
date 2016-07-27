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
        $dataFormat = $date->format('Y-m-d');
       
        $codigo = $date->format('YmdHis');
        $data['data'] = $dataFormat;
        $data['data_vencimento'] = $dataFormat;
        $data['codigo'] = $codigo;
        $data['status'] = '0';
        $parametros = \DB::table('bib_parametros')->select('bib_parametros.*')->where('bib_parametros.codigo', '=', '003')->get();
        $return = [
            'msg',
            'sucesso',
            'reserva'
        ];

        //Busca quantidade de reserva do aluno
        $validarQtdReserva = Reserva::join('bib_reservas_exemplares', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->where('bib_reservas.pessoas_id', '=', $data['pessoas_id'])
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->groupBy('bib_reservas.pessoas_id')
            ->select([
                \DB::raw('count(bib_reservas_exemplares.reserva_id) as qtd'),
            ])
            ->get();

        //Valida se a quantidade de reserva atinge o limite máximo
        if (isset($validarQtdReserva[0]) && $validarQtdReserva[0]->qtd >= $parametros[0]->valor) {
            $return[1] = "Limite de até {$parametros[0]->valor} reservas foi atingido";
            $return[2] = false;
            return $return;
        }

        //busca o registro de reserva que está sendo usando no momento para reservas
        $validarReserva = $this->findWhere($data);

        #Salvando o registro pincipal (caso aja um registro já sendo usado, não será feito um novo registro)
        if(count($validarReserva) <= 0) {
            $reserva =  $this->repository->create($data);
            $reserva->reservaExemplar()->attach($data['id_acervo']);
        } else {
            $reserva = $validarReserva[0];
            $reserva->reservaExemplar()->attach($data['id_acervo']);
        }

        //Atualizando as reservas para status em que ainda n foi feito emprestimos para as mesmas de acordo com a edição
        if ($data['edicao'] != 'null') {
            $reservaExem = $this->repoReseExemp->findWhere(['reserva_id' => $reserva->id, 'arcevos_id' => $data['id_acervo']]);
            $reservaExem[0]->edicao = $data['edicao'];
            $reservaExem[0]->status = 0;
            $reservaExem[0]->save();
        }

        /*$acervo = $this->repoAcervo->find($data['id_acervo']);
        $acervo->situacao_id = '3';
        $acervo->save();*/

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
        
        $date = new \DateTime('now');
        $dataFormat = $date->format('Y-m-d');
        $codigo = $date->format('YmdHis');
        $dia       = 0;

        $emprestimo = array();
        $exemplares = array();

        $emprestimo['data'] = $dataFormat;
        $emprestimo['codigo'] = $codigo;
        $emprestimo['pessoas_id'] = $data['id_pessoa'];
        $emprestimo['tipo_emprestimo'] = $data['tipo_emprestimo'];

        for ($i = 0; $i < count($data['id']); $i++) {
            $exemplar = Exemplar::join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->where('bib_arcevos.id', '=', $data['id'][$i])
                ->where('bib_exemplares.situacao_id', '=', '1')
                ->orWhere('bib_exemplares.situacao_id', '=', '3')
                ->where('bib_exemplares.edicao', '=', $data['edicao'][$i])
                ->where('bib_exemplares.exemp_principal', '=', '0')
                ->select(
                    ['bib_exemplares.*',
                    ])->get();

               $exemplares[] = $exemplar[0]->id;

        }

        if($data['tipo_emprestimo'] == '1') {
            $query = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '002')->get();
            $dia = $query[0]->valor - 1;
        } else if ($data['tipo_emprestimo'] == '2') {
            $query = \DB::table('bib_parametros')->select('bib_parametros.valor')->where('bib_parametros.codigo', '=', '001')->get();
            $dia = $query[0]->valor - 1;
        }

        $date->add(new \DateInterval("P{$dia}D"));
        $dataDevolucao = $date->format('Y-m-d');
        $emprestimo['data_devolucao'] = $dataDevolucao;

        $emprestar =  $this->repoEmprestar->create($emprestimo);
        $emprestar->emprestimoExemplar()->attach($exemplares);

        foreach ($exemplares as $id) {
            $exemplar = $this->repoExemplar->find($id);
            $exemplar->situacao_id = '5';
            $exemplar->save();
        }

        for ($i = 0; $i < count($data['id']); $i++) {
                $reservaExem =  $this->repoReseExemp->findWhere(['reserva_id' => $data['id_reserva'], 'arcevos_id' => $data['id'][$i]]);
                $reservaExem[0]->status = 1;
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
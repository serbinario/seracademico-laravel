<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Entities\Biblioteca\Reserva;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Biblioteca\ArcevoService;
use Seracademico\Services\Biblioteca\ReservaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Biblioteca\ReservaValidator;

class ReservaController extends Controller
{
    /**
    * @var ReservaService
    */
    private $service;

    /**
     * @var ArcevoService
     */
    private $serviceAcervo;

    /**
    * @var ReservaValidator
    */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Pessoa'
    ];

    /**
    * @param ReservaService $service
    * @param ReservaValidator $validator
    */
    public function __construct(ReservaService $service, ArcevoService $serviceAcervo, ReservaValidator $validator)
    {
        $this->service   =  $service;
        $this->serviceAcervo   =  $serviceAcervo;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $loadFields = $this->service->load($this->loadFields);
        $reservasPendentes = $this->service->findWherePendencias();

        return view('biblioteca.controle.reserva.index', compact('loadFields', 'reservasPendentes'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_exemplares.exemp_principal', '=', '0')
            ->select(
                'bib_arcevos.titulo',
                'bib_arcevos.id as id_acervo',
                'bib_arcevos.cutter',
                'bib_exemplares.edicao',
                'bib_exemplares.situacao_id',
                'bib_exemplares.emprestimo_id as id_emp',
                'bib_arcevos.subtitulo as subtitulo'
                )
            ->groupBy('bib_exemplares.edicao', 'bib_exemplares.ano', 'bib_arcevos.id')
            ->having(\DB::raw('sum(bib_exemplares.situacao_id) = count(*) * 5'), '=', '1');

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html   =    '<a class="btn-floating add" href="" title="Adicionar acervo"><i class="fa fa-plus"></i></a></li>';
            $html   .=   ' <a class="btn-floating fila-reserva" href="" title="Lista de pessoas"><i class="fa fa-bars"></i></a></li>';

            # Retorno
            return $html;
        })->addColumn('previsao', function ($row) {

            $query = \DB::table('bib_emprestimos_exemplares')
                ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
                ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->where('bib_arcevos.id', '=', $row->id_acervo)
                ->where('bib_emprestimos.status', '=', '1')
                ->where('bib_emprestimos.status_devolucao', '=', '0')
                ->select([
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao,"%d/%m/%Y") as data_devolucao')
                ])->first();

            if($query) {
                $dataPrevisao = $query->data_devolucao;
            } else {
                $dataPrevisao = "";
            }

            return $dataPrevisao;

        })->addColumn('qtdReservas', function ($row) {

            $date = new \DateTime('now');
            $date->setTimezone( new \DateTimeZone('BRT') );
            $data = $date->format('Y-m-d H:i:s');

            $query = \DB::table('bib_reservas_exemplares')
                ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
                ->where('bib_arcevos.id', '=', $row->id_acervo)
                ->where('bib_reservas.status', '=', '1')
                ->where('bib_reservas_exemplares.status', '=', '0')
                ->where('bib_reservas.data_vencimento', '>', $data)
                ->select([
                    \DB::raw('COUNT(bib_reservas_exemplares.arcevos_id) as qtdReservas')
                ])->first();

            if($query) {
                $qtdReservas = $query->qtdReservas;
            } else {
                $qtdReservas = "";
            }

            return $qtdReservas;

        })->make(true);
    }

    /**
     * @param Request $request
     */
    public function listaPessoasReservas(Request $request)
    {

        $date = new \DateTime('now');
        $date->setTimezone( new \DateTimeZone('BRT') );
        $data = $date->format('Y-m-d H:i:s');

        $query = \DB::table('bib_reservas_exemplares')
            ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->join('pessoas', 'pessoas.id', '=', 'bib_reservas.pessoas_id')
            ->where('bib_arcevos.id', '=', $request->get('acervo'))
            ->where('bib_reservas.status', '=', '1')
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->where('bib_reservas.data_vencimento', '>', $data)
            ->orderBy('bib_reservas.data_vencimento')
            ->select([
                'pessoas.nome'
            ])->get();

        return $query;
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $req = $request->request->all();

        $data = $this->service->store($req);

        $request->session()->put('id_pessoa_reserva', $request['pessoas_id']);

        return $data;
    }

    /**
     * @param Request $request
     */
    public function findWhereReserva(Request $request)
    {
        $pessoaId = $request->request->get('id_pessoa');

        $data = $this->service->findWhere(['pessoas_id' => $pessoaId]);

        return $data;
    }

    /**
     * @param Request $request
     */
    public function deleteReserva($id, $id2)
    {
        $data = $this->service->deleteReserva($id, $id2);

        $result = $data;

        return array();
    }

    /**
     * @param Request $request
     */
    public function confirmarReserva(Request $request)
    {

        $dados  = $request->all();
        $id = isset($dados['id_emp']) ? $dados['id_emp'] : "";

        $user = \Auth::user();

        $data = $this->service->find($id);
        $data->status = '1';
        $data->users_id = $user->id;
        $data->save();

       return redirect()->back();
    }
    

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #tratando as rules
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function reservados(){

        return view('biblioteca.controle.reserva.reservas');
    }

    /**
     * @param Request $request
     */
    public function gridReservados(Request $request)
    {

        #Criando a consulta
        $rows = Reserva::join('pessoas', 'pessoas.id', '=', 'bib_reservas.pessoas_id')
            ->join('bib_reservas_exemplares', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->groupBy('bib_reservas.id')
            ->select([
                'bib_reservas.codigo',
                'bib_reservas.id as id',
                'bib_reservas.tipo_emprestimo',
                'bib_reservas.emprestimo_especial',
                'pessoas.nome',
                'pessoas.id as pessoas_id',
                'pessoas.identidade',
                'bib_reservas.tipo_pessoa',
                \DB::raw('DATE_FORMAT(bib_reservas.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(bib_reservas.data_vencimento,"%d/%m/%Y") as data_vencimento'),
                ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = "";

            # Retorno
            return $html;
        })->addColumn('qtdEmprestimos', function ($row) {


            # Variáveis
            $qtdEmprestimoAtual = '';
            $qtdEmprestimoMaximo = '';

            # Pegas os parâmetros para saber a quantidade de exemplares por tipo de pessoa
            $qtdEmprestimos = \DB::table('bib_parametros')->select('bib_parametros.*')
                ->whereIn('bib_parametros.codigo',['003', '007', '009'] )->get();

            //Pega a quantidade de emprestimo da pessoa
            $validarQtdEmprestimo = \DB::table('bib_emprestimos')
                ->join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
                ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
                ->where('bib_emprestimos.pessoas_id', '=', $row->pessoas_id)
                ->where('bib_exemplares.situacao_id', '=', '5')
                ->where('bib_emprestimos.status_devolucao', '=', '0')
                ->groupBy('bib_emprestimos.pessoas_id')
                ->select([
                    \DB::raw('count(bib_emprestimos_exemplares.emprestimo_id) as qtd'),
                ])
                ->first();

            # Pegando a quantidade de empréstimo atual
            $qtdEmprestimoAtual = $validarQtdEmprestimo ? "$validarQtdEmprestimo->qtd" : "0";

            # Pegando a quantidade de empréstimo máximo
            if ($row->tipo_pessoa == '1') { # Aluno Graduação
                $qtdEmprestimoMaximo =  $qtdEmprestimos[0]->valor;
            } else if ($row->tipo_pessoa == '2' || $row->tipo_pessoa == '3') {  # Aluno pós-graduação, mestrado, doutorado
                $qtdEmprestimoMaximo =  $qtdEmprestimos[2]->valor;
            } else if ($row->tipo_pessoa == '4') { # Professores
                $qtdEmprestimoMaximo =  $qtdEmprestimos[1]->valor;
            }

            // Montando um array de retorno
            $result = array (
                'qtdEmprestimoAtual' => $qtdEmprestimoAtual,
                'qtdEmprestimoMaximo' => $qtdEmprestimoMaximo,
            );

            # Retorno
            return $result;
        })->addColumn('acervos', function ($row) {

            $date = new \DateTime('now');
            $date->setTimezone( new \DateTimeZone('BRT') );
            $data = $date->format('Y-m-d H:i:s');

            // Recuperando todos os acervos da reserva
            $consulta = \DB::table('bib_reservas_exemplares')
                ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
                ->where('bib_reservas.id', '=', $row->id)
                ->select([
                    'bib_arcevos.titulo',
                    'bib_arcevos.subtitulo',
                    'bib_arcevos.numero_chamada',
                    'bib_arcevos.id as acervo_id',
                    'bib_reservas_exemplares.status',
                    'bib_reservas_exemplares.edicao',
                    'bib_reservas.pessoas_id',
                    'bib_reservas.data_vencimento',
                    'bib_reservas_exemplares.id',
                    'bib_reservas_exemplares.status_fila',
                ]);

            $acervosParaTratamento = $consulta;
            $fila = "";

            foreach ($acervosParaTratamento->get() as $acervo){

                //Pega todos os acervos que não pertence a reserva da pessoal atual
                $query = \DB::table('bib_reservas_exemplares')
                    ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
                    ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
                    ->where('bib_reservas.pessoas_id', '!=', $acervo->pessoas_id)
                    ->where('bib_reservas_exemplares.arcevos_id', '=', $acervo->acervo_id)
                    ->where('bib_reservas_exemplares.edicao', '=', $acervo->edicao)
                    ->where('bib_reservas_exemplares.status', '=', '0')
                    ->where('bib_reservas.data_vencimento', '>', $data)
                    ->select([
                        'bib_reservas_exemplares.status',
                        'bib_reservas_exemplares.status_fila',
                        'bib_reservas.data_vencimento',
                    ])->get();

                // Valida se já existe alguma reserva e coloca a reserva atual na fila caso seja validado se a mesma acima das demais por data e hora
                if(count($query) > 0) {

                    foreach ($query as $q) {
                        if(strtotime($acervo->data_vencimento) > strtotime($data)
                            && (strtotime($acervo->data_vencimento) < strtotime($q->data_vencimento))) {
                            $fila = '1';
                        } else {
                            $fila = '0';
                            break;
                        }
                    }
                    
                } else {
                    $fila = '1';
                }

                // Caso seja validado se a reserva atual está propícia a ser a primeita da fila, seu status é atualizado
                if ($fila == '1' && $acervo->status_fila != '2') {
                    \DB::table('bib_reservas_exemplares')->where('id', $acervo->id)->update(['status_fila' => 1]);
                }

                // Caso a reserva tenha sua data de vencimento expirada, a mesma recebe status 2 sendo removida da fila
                if ((strtotime($acervo->data_vencimento) < strtotime($data))) {
                    \DB::table('bib_reservas_exemplares')->where('id', $acervo->id)->update(['status_fila' => 2, 'status' => 1]);
                }

            }

            $acervos = $consulta->get();

            //Pegando a quantidade de exemplares disponíveis para empréstimo
            foreach ($acervos as $chave => $acervo) {

                $qtdExemplares = \DB::table('bib_exemplares')
                    ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                    ->join('bib_reservas_exemplares', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
                    ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
                    ->where('bib_reservas.id', '=', $row->id)
                    ->where('bib_arcevos.id', '=', $acervo->acervo_id)
                    ->where('bib_exemplares.edicao', '=', $acervo->edicao)
                    ->where(function ($query) use ($acervo) {
                        $query->orWhere('bib_exemplares.edicao', '=', $acervo->edicao)
                            ->orWhere('bib_exemplares.edicao', '=', "");
                    })
                    ->where('bib_exemplares.situacao_id', '=', '1')
                    ->orWhere(function ($query) {
                        $query->where('bib_exemplares.situacao_id', '=', '3')
                            ->where('bib_exemplares.exemp_principal', '=', "0");
                    })
                    ->select([
                        \DB::raw('COUNT(bib_exemplares.id) as qtdExemplares'),
                    ])->first();

                // Inserindo quantidade de exemplares disponível em cada registro de acervo
                $arrayTemp = (array) $acervos[$chave];
                $acervos[$chave] = (object) array_merge($arrayTemp, ['qtdExemplares' => $qtdExemplares->qtdExemplares]);

            }

            # Retorno
            return $acervos;

        })->make(true);
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function saveEmprestimo(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            if(!isset($data['id'])){
                return redirect()->back()->with("error", "É preciso informar pelo menos um acervo!");
            }

            #Executando a ação
            $result = $this->service->saveEmprestimo($data);
            
            #Retorno para a view
            return view('biblioteca.controle.emprestimo.cupomEmprestimo', compact('result'));
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

}

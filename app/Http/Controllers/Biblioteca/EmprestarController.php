<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Biblioteca\EmprestarService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Biblioteca\EmprestarValidator;
use Seracademico\Services\Biblioteca\ExemplarService;
use Seracademico\Entities\Biblioteca\Emprestar;
use Seracademico\Contracts\Report;

class EmprestarController extends Controller
{
    /**
    * @var EmprestarService
    */
    private $service;

    /**
     * @var ExemplarService
     */
    private $serviceExemplar;

    /**
    * @var EmprestarValidator
    */
    private $validator;

    /**
     * @var
     */
    private $data;

    /**
    * @var array
    */
    private $loadFields = [
        'Pessoa'
    ];

    /**
    * @param EmprestarService $service
    * @param EmprestarValidator $validator
    */
    public function __construct(EmprestarService $service, ExemplarService $serviceExemplar, EmprestarValidator $validator)
    {
        $this->service           =  $service;
        $this->serviceExemplar   =  $serviceExemplar;
        $this->validator         =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $loadFields = $this->service->load($this->loadFields);
        $emprestimosPendentes = $this->service->findWherePendencias();
        
        return view('biblioteca.controle.emprestimo.index', compact('loadFields', 'emprestimosPendentes'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->join('bib_emprestimo', 'bib_emprestimo.id', '=', 'bib_exemplares.emprestimo_id')
            ->join('bib_situacao', 'bib_situacao.id', '=', 'bib_exemplares.situacao_id')
            ->where('bib_exemplares.exemp_principal', '!=', '1')
            ->where('bib_exemplares.situacao_id', '!=', '5')
            ->where('bib_exemplares.situacao_id', '!=', '4')
            ->where('bib_exemplares.situacao_id', '!=', '2')
            ->select('bib_exemplares.id as id',
                'bib_arcevos.titulo',
                'bib_arcevos.cutter',
                'bib_arcevos.cdd',
                'bib_arcevos.id as acervo_id',
                'bib_exemplares.edicao',
                'bib_situacao.nome as nome_sit',
                'bib_situacao.id as id_sit',
                'bib_arcevos.subtitulo as subtitulo',
                'bib_emprestimo.nome as nome_emp',
                'bib_emprestimo.id as id_emp',
                'bib_exemplares.codigo_barra as codigo_barra',
                \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo')
            );

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html       = '<a class="btn-floating add" href="" title="Editar disciplina"><i class="fa fa-plus"></i></a></li>';

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('emprestimo.create', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #tratando as rules
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $result = $this->service->store($data);

            #Retorno para a view
            return view('biblioteca.controle.emprestimo.cupomEmprestimo', compact('result'));
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     */
    public function dataDevolucao(Request $request)
    {
        $req = $request->request->all();
        
        $data = $this->service->dataDevolucao($req);

        $request->session()->put('id_pessoa', ['id' => $request['pessoas_id'], 'nome' => $request['pessoas_nome']]);


        return \Illuminate\Support\Facades\Response::json($data);
        //return $data;
    }

    /**
     * @param Request $request
     */
    public function findWhereEmprestimo(Request $request)
    {
        $pessoaId = $request->request->get('id_pessoa');

        $data = $this->service->findWhere(['pessoas_id' => $pessoaId]);

       //dd($data);

        return $data;
        //return $data;
    }

    /**
     * @param Request $request
     */
    public function confirmarEmprestimo(Request $request)
    {
        $dados  = $request->all();
        $id = isset($dados['id_emp']) ? $dados['id_emp'] : "";
        $user = \Auth::user();

        $emprestimo = $this->service->find($id);

        $emprestimo->status = '1';
        $emprestimo->users_id = $user->id;
        $emprestimo->save();

        $result = $emprestimo;

        return view('biblioteca.controle.emprestimo.cupomEmprestimo', compact('result'));
    }

    /**
     * @param Request $request
     */
    public function deleteEmprestimo($id, $id2)
    {
        $data = $this->service->deleteEmprestimo($id, $id2);

        $result = $data;

        return array();
    }

    /**
     * @return mixed
     */
    public function viewDevolucao(){

        return view('biblioteca.controle.emprestimo.devolucao');
    }

    /**
     * @param Request $request
     */
    public function gridDevolucao(Request $request)
    {
        $dataObj = new \DateTime('now');
        $this->data    = $dataObj->format('Y-m-d');

        #Criando a consulta
        $rows = Emprestar::join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
            ->join('bib_emprestimos_exemplares', 'bib_emprestimos_exemplares.emprestimo_id', '=', 'bib_emprestimos.id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->groupBy('bib_emprestimos.id')
            ->where('bib_emprestimos.status', '=', '1')
            ->select([
                    'bib_emprestimos.codigo',
                    'bib_emprestimos.tipo_emprestimo',
                    'bib_emprestimos.id',
                    'pessoas.nome',
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao,"%d/%m/%Y") as data_devolucao'),
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao_real,"%d/%m/%Y") as data_devolucao_real'),
                    'bib_emprestimos.data_devolucao as devolucao',
                    'bib_emprestimos.status_pagamento'
                ]);
        
        #Editando a grid
        return Datatables::of($rows)
            ->filter(function ($query) use ($request) {
                // Filtrando Global
                if ($request->has('globalSearch')) {
                    # recuperando o valor da requisição
                    $search = $request->get('globalSearch');

                    #condição
                    $query->where(function ($where) use ($search) {
                        $where->orWhere('bib_exemplares.codigo', 'like', "%$search%")
                            ->orWhere('bib_emprestimos.codigo', 'like', "%$search%")
                            ->orWhere('pessoas.nome', 'like', "%$search%");
                    });

                }
            })
            ->addColumn('action', function ($row) {
                
                
                
                $html = "";
                if(!$row->data_devolucao_real) {
                    $html .= '<div class="fixed-action-btn horizontal">
                              <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                              <ul>
                              <li>
                                <a class="btn-floating excluir" href="confirmarDevolucao/'.$row->id.'" title="Devolver"><i class="material-icons">done</i></a>
                              </li>';
                    if($row->tipo_emprestimo == '1' && strtotime($row->devolucao) >= strtotime($this->data)) {
                            $html .= '<li>
                                      <a class="btn-floating renovar" href="renovacao/'.$row->id.'" title="Renovar"><i class="material-icons">restore</i></a>
                                      </li>
                                      </ul>
                                      </div>';
                    }
                }
                if($row->status_pagamento == '1') {
                    $html .= '<div class="fixed-action-btn horizontal">
                                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                                    <ul>
                                    <li>
                                    <a class="btn-floating baixa-pagamento" href="baixaPagamento/'.$row->id.'" title="Baixa pagamento"><i class="material-icons">thumb_up</i></a>
                                    </li>
                                    </ul>
                                    </div>';
                }
            # Retorno
            return $html;
        })->addColumn('exemplares', function ($row) {

            $exemplares = \DB::table('bib_emprestimos_exemplares')
                ->join('bib_emprestimos', 'bib_emprestimos_exemplares.emprestimo_id', '=', 'bib_emprestimos.id')
                ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
                ->where('bib_emprestimos.status', '=', '1')
                ->where('bib_emprestimos.id', '=', $row->id)
                ->select([
                    'bib_arcevos.titulo',
                    'bib_arcevos.cutter',
                    'bib_arcevos.subtitulo',
                    'bib_exemplares.edicao',
                    \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo'),
                    'bib_emprestimos_exemplares.id',
                    'bib_arcevos.titulo',
                    'bib_arcevos.numero_chamada'
                ])->get();

            # Retorno
            return $exemplares;
                
        })->make(true);
    }

    /**
     * @param Request $request
     */
    public function gridDevolucaoPorAluno(Request $request)
    {
        $dataObj = new \DateTime('now');
        $this->data    = $dataObj->format('Y-m-d');

        #Criando a consulta
        $rows = Emprestar::join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
            ->join('bib_emprestimos_exemplares', 'bib_emprestimos_exemplares.emprestimo_id', '=', 'bib_emprestimos.id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->groupBy('pessoas.id')
            ->where('bib_emprestimos.status', '=', '1')
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->orWhere('bib_emprestimos.status_pagamento', '=', '1')
            ->select([
                'pessoas.id as pessoa_id',
                'pessoas.nome',
                'pessoas.identidade',
                'pessoas.cpf',
                'bib_emprestimos.id',
                \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao,"%d/%m/%Y") as data_devolucao'),
                \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao_real,"%d/%m/%Y") as data_devolucao_real'),
                'bib_emprestimos.status_devolucao',
                'bib_emprestimos.status_pagamento'
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->filter(function ($query) use ($request) {
                // Filtrando Global
                if ($request->has('globalSearchAluno')) {
                    # recuperando o valor da requisição
                    $search = $request->get('globalSearchAluno');

                    #condição
                    $query->where(function ($where) use ($search) {
                        $where->orWhere('bib_exemplares.codigo', 'like', "%$search%")
                            ->orWhere('bib_emprestimos.codigo', 'like', "%$search%")
                            ->orWhere('pessoas.nome', 'like', "%$search%")
                            ->orWhere('pessoas.identidade', 'like', "%$search%")
                            ->orWhere('pessoas.cpf', 'like', "%$search%");
                    });

                }
            })
            ->addColumn('action', function ($row) {
                $html = "";

                # Valida se foi realizado o pagamento ou não de no caso o empréstmimo atrasado
                if($row->status_devolucao == '0') {
                    $html .= '<div class="fixed-action-btn horizontal">
                          <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                          <ul>
                          <li>
                            <a class="btn-floating devolver-aluno" href="confirmarDevolucaoPorAluno/'.$row->pessoa_id.'" title="Devolver"><i class="material-icons">done_all</i></a>
                          </li>
                          </ul>
                          </div>';
                }
                if($row->status_pagamento == '1') {
                    $html .= '<div class="fixed-action-btn horizontal">
                                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                                    <ul>
                                    <li>
                                    <a class="btn-floating baixa-pagamento-aluno" href="baixaPagamentoPorAluno/'.$row->pessoa_id.'" title="Baixa pagamento"><i class="material-icons">thumb_up</i></a>
                                    </li>
                                    </ul>
                                    </div>';
                }
                # Retorno
                return $html;
            })->addColumn('exemplares', function ($row) {

                $exemplares = \DB::table('bib_emprestimos_exemplares')
                    ->join('bib_emprestimos', 'bib_emprestimos_exemplares.emprestimo_id', '=', 'bib_emprestimos.id')
                    ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
                    ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                    ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
                    ->where('bib_emprestimos.status', '=', '1')
                    ->where('bib_emprestimos.status_devolucao', '=', '0')
                    ->where('pessoas.id', '=', $row->pessoa_id)
                    ->select([
                        'bib_arcevos.titulo',
                        'bib_arcevos.cutter',
                        'bib_arcevos.subtitulo',
                        'bib_exemplares.edicao',
                        \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo'),
                        'bib_emprestimos_exemplares.id',
                        'bib_arcevos.titulo',
                        'bib_arcevos.numero_chamada',
                        'bib_emprestimos.codigo',
                        \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                        \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao,"%d/%m/%Y") as data_devolucao'),
                    ])->get();

                # Retorno
                return $exemplares;
            })->make(true);
    }

    /**
     * @return mixed
     */
    public function confirmarDevolucao($id)
    {
        try {

            #Executando a ação
            $result = $this->service->devolucao($id);

            //Pegando o empréstimo
            $emprestimo = \DB::table('bib_emprestimos')
                ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
                ->where('bib_emprestimos.id', '=', $result->id)
                ->select([
                    'pessoas.nome',
                    'pessoas.celular',
                    'pessoas.identidade',
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao,"%d/%m/%Y") as data_devolucao'),
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao_real,"%d/%m/%Y") as data_devolucao_real'),
                    'bib_emprestimos.codigo',
                    'bib_emprestimos.valor_multa',
                ])->first();

            //Pegando os exemplares
            $exemplares = \DB::table('bib_emprestimos_exemplares')
                ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
                ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->where('bib_emprestimos.id', '=', $result->id)
                ->select([
                    'bib_arcevos.titulo',
                    'bib_arcevos.cutter',
                    'bib_arcevos.cdd',
                    \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo'),
                    'bib_emprestimos_exemplares.valor_multa',
                ])->get();

            #Retorno para a view
            return view('biblioteca.controle.emprestimo.cupomDevolucao', compact('emprestimo', 'exemplares'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function confirmarDevolucaoPorAluno($id)
    {
        try {

            #Executando a ação
            $result = $this->service->devolucaoPorAluno($id);

            $totalMulta = $result['toltaMulta'];

            //Pegando o empréstimo
            $emprestimo = \DB::table('bib_emprestimos')
                ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
                ->whereIn('bib_emprestimos.id', $result['idEmprestimo'])
                ->groupBy('pessoas.id')
                ->select([
                    'pessoas.nome',
                    'pessoas.celular',
                    'pessoas.identidade',
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao_real,"%d/%m/%Y") as data_devolucao_real'),
                    'bib_emprestimos.codigo',
                    'bib_emprestimos.valor_multa',
                ])->first();

            //Pegando os exemplares
            $exemplares = \DB::table('bib_emprestimos_exemplares')
                ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
                ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->whereIn('bib_emprestimos.id', $result['idEmprestimo'])
                ->select([
                    'bib_arcevos.titulo',
                    'bib_arcevos.cutter',
                    'bib_arcevos.cdd',
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao,"%d/%m/%Y") as data_devolucao'),
                    \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo'),
                    'bib_emprestimos.codigo',
                    'bib_emprestimos_exemplares.valor_multa',
                ])->get();

            #Retorno para a view
            return view('biblioteca.controle.emprestimo.cupomDevolucaoPorAluno', compact('emprestimo', 'exemplares', 'totalMulta'));
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function renovacao($id)
    {
        try {
            #Executando a ação
            $result = $this->service->renovacao($id);

            if(!$result){
                return redirect()->back()->with("error", "Não será possível a renovação, pois há livros em reserva!");
            }

            #Retorno para a view
            return view('biblioteca.controle.emprestimo.cupomEmprestimo', compact('result'));
            //return redirect()->back()->with("message", "Devolução realizada com sucesso!");
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     */
    public function validarTermoBiblioteca(Request $request)
    {
        if($request->has('tipo_pessoa') && $request->get('tipo_pessoa') == '1') {

            $query = \DB::table('pessoas')
                ->join('fac_alunos', 'fac_alunos.pessoa_id', '=', 'pessoas.id')
                ->where('fac_alunos.termo_biblioteca', '=', null)
                ->where('fac_alunos.id', '=', $request->get('idAlunoProfessor'))
                ->where('pessoas.id', '=', $request->get('id_pessoa'))
                ->select('fac_alunos.id')->first();

        } else if ($request->has('tipo_pessoa') && ($request->get('tipo_pessoa') == '2' || $request->get('tipo_pessoa') == '3')) {

            $query = \DB::table('pessoas')
                ->join('pos_alunos', 'pos_alunos.pessoa_id', '=', 'pessoas.id')
                ->where('pos_alunos.termo_biblioteca', '=', null)
                ->where('pos_alunos.id', '=', $request->get('idAlunoProfessor'))
                ->where('pessoas.id', '=', $request->get('id_pessoa'))
                ->select('pos_alunos.id')->first();

        } else if ($request->has('tipo_pessoa') && $request->get('tipo_pessoa') == '4') {

            $query = \DB::table('pessoas')
                ->join('fac_professores', 'fac_professores.pessoa_id', '=', 'pessoas.id')
                ->where('fac_professores.termo_biblioteca', '=', null)
                ->where('fac_professores.id', '=', $request->get('idAlunoProfessor'))
                ->where('pessoas.id', '=', $request->get('id_pessoa'))
                ->select('fac_professores.id')->first();

        }
        
        if($query) {
            return 1;
        } else {
            return 0;
        }

    }

    /**
     * @param Request $request
     */
    public function confirmarTermoBiblioteca(Request $request)
    {
        if($request->has('tipo_pessoa') && $request->get('tipo_pessoa') == '1') {

            $query = \DB::table('pessoas')
                ->join('fac_alunos', 'fac_alunos.pessoa_id', '=', 'pessoas.id')
                ->join('enderecos', 'enderecos.id', '=', 'pessoas.enderecos_id')
                ->where('fac_alunos.termo_biblioteca', '=', null)
                ->where('fac_alunos.id', '=', $request->get('idAlunoProfessor'))
                ->select([
                    'pessoas.nome',
                    'pessoas.celular',
                    'enderecos.logradouro',
                    'fac_alunos.matricula',
                    'pessoas.email'
                ])->first();

            \DB::table('fac_alunos')->where('id', $request->get('idAlunoProfessor'))->update(['termo_biblioteca' => 1]);

            return \PDF::loadView('biblioteca.termo.termo', ['dados' =>  $query])->stream();

        } else if ($request->has('tipo_pessoa') && ($request->get('tipo_pessoa') == '2' || $request->get('tipo_pessoa') == '3')) {

            $query = \DB::table('pessoas')
                ->join('enderecos', 'enderecos.id', '=', 'pessoas.enderecos_id')
                ->join('pos_alunos', 'pos_alunos.pessoa_id', '=', 'pessoas.id')
                ->where('pos_alunos.termo_biblioteca', '=', null)
                ->where('pos_alunos.id', '=', $request->get('idAlunoProfessor'))
                ->select([
                    'pessoas.nome',
                    'pessoas.celular',
                    'enderecos.logradouro',
                    'pos_alunos.matricula',
                    'pessoas.email'
                ])->first();

            \DB::table('pos_alunos')->where('id', $request->get('idAlunoProfessor'))->update(['termo_biblioteca' => 1]);

            return \PDF::loadView('biblioteca.termo.termo', ['dados' =>  $query])->stream();

        } else if ($request->has('tipo_pessoa') && $request->get('tipo_pessoa') == '4') {

            $query = \DB::table('pessoas')
                ->join('enderecos', 'enderecos.id', '=', 'pessoas.enderecos_id')
                ->join('fac_professores', 'fac_professores.pessoa_id', '=', 'pessoas.id')
                ->where('fac_professores.termo_biblioteca', '=', null)
                ->where('fac_professores.id', '=', $request->get('idAlunoProfessor'))
                ->select([
                    'pessoas.nome',
                    'pessoas.celular',
                    'enderecos.logradouro',
                    'pessoas.email'
                ])->first();

            \DB::table('fac_professores')->where('id', $request->get('idAlunoProfessor'))->update(['termo_biblioteca' => 1]);

            return \PDF::loadView('biblioteca.termo.termo', ['dados' =>  $query])->stream();

        }
        
    }

    /**
     * @return mixed
     */
    public function baixaPagamento($id)
    {
        try {

            #Executando a ação
            $result = \DB::table('bib_emprestimos')
                ->where('id', $id)
                ->where('status_pagamento', '1')
                ->update(['status_pagamento' => 2]);

            if(!$result){
                return redirect()->back()->with("error", "Não foi possível confirmar o pagamento!");
            }

            #Retorno para a view
            return redirect()->back()->with("message", "Pagamento confirmado com sucesso!");
            //return redirect()->back()->with("message", "Devolução realizada com sucesso!");
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function baixaPagamentoPorAluno($id)
    {
        try {

            #Executando a ação
            $result = \DB::table('bib_emprestimos')
                ->where('pessoas_id', $id)
                ->where('status_pagamento', '1')
                ->update(['status_pagamento' => 2]);

            if(!$result){
                return redirect()->back()->with("error", "Não foi possível confirmar o pagamento!");
            }

            #Retorno para a view
            return redirect()->back()->with("message", "Pagamento confirmado com sucesso!");
            //return redirect()->back()->with("message", "Devolução realizada com sucesso!");
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}

<?php

namespace Seracademico\Http\Controllers\Biblioteca;

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
    * @var array
    */
    private $loadFields = [
        'Aluno'
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
        
        return view('biblioteca.controle.emprestimo.index', compact('loadFields'));
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
                'bib_exemplares.edicao',
                'bib_situacao.nome as nome_sit',
                'bib_situacao.id as id_sit',
                'bib_arcevos.subtitulo as subtitulo',
                'bib_emprestimo.nome as nome_emp',
                'bib_emprestimo.id as id_emp',
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

            //dd($data);

            #tratando as rules
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Emprestimo realizado com sucesso!");
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
        $request = $request->request->all();
        
        $data = $this->service->dataDevolucao($request);
        
        return $data;
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
        #Criando a consulta
        $rows = Emprestar::join('fac_alunos', 'fac_alunos.id', '=', 'bib_emprestimos.alunos_id')
            ->with(['emprestimoExemplar.acervo'])
            ->select(
                ['bib_emprestimos.codigo',
                    'bib_emprestimos.*',
                    'fac_alunos.nome',
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao,"%d/%m/%Y") as data_devolucao'),
                    \DB::raw('DATE_FORMAT(bib_emprestimos.data_devolucao_real,"%d/%m/%Y") as data_devolucao_real'),
                ]);
        
        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = "";
            if (!$row->data_devolucao_real) {
                $html       = '<a class="btn-floating excluir" target="_blank" href="confirmarDevolucao/'.$row->id.'" title="Editar disciplina"><i class="fa fa-plus"></i></a></li>';
            }

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function confirmarDevolucao($id)
    {
        try {
            #Executando a ação
            $this->service->devolucao($id);

            #Retorno para a view
            return view('biblioteca.controle.emprestimo.cupomDevolucao');
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

}

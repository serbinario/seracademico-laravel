<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Biblioteca\EmprestarService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Biblioteca\EmprestarValidator;
use Seracademico\Services\Biblioteca\ExemplarService;

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
            ->where('bib_exemplares.situacao_id', '=', '1')
            ->select('bib_exemplares.id as id',
                'bib_arcevos.titulo',
                'bib_arcevos.cutter',
                'bib_exemplares.edicao',
                'bib_situacao.nome as nome_sit',
                'bib_arcevos.subtitulo as subtitulo',
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
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('emprestimo.edit', compact('model', 'loadFields'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
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
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

}

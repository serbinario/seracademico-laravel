<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\ExemplarService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\ExemplarValidator;

class ExemplarController extends Controller
{
    /**
    * @var ExemplarService
    */
    private $service;

    /**
    * @var ExemplarValidator
    */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Aquisicao',
        'Ilustracao',
        'Idioma',
        'Situacao',
        'Emprestimo',
        'Genero',
        'Editora'
    ];

    /**
    * @param ExemplarService $service
    * @param ExemplarValidator $validator
    */
    public function __construct(ExemplarService $service, ExemplarValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('biblioteca.exemplar.index');
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
            ->select('bib_exemplares.id as id', 'bib_arcevos.titulo', 'bib_exemplares.edicao',
                'bib_emprestimo.nome as nome_emp', 'bib_situacao.nome as nome_sit');

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating" href="editExemplar/'.$row->id.'" title="Editar sede"><i class="material-icons">edit</i></a></li>
                    </ul>
                    </div>';
        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);
        $acervo = $this->service->acervos($this->loadFields);

        #Retorno para view
        return view('biblioteca.exemplar.create', compact('loadFields', 'acervo'));
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

            #Tratando as datas
            $model = $this->service->getDateFormatPtBr($model);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);
            $acervo = $this->service->acervos($this->loadFields);

            #retorno para view
            return view('biblioteca.exemplar.edit', compact('model', 'loadFields', 'acervo'));
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

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

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

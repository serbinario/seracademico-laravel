<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Aluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\AlunoService;
use Seracademico\Validators\AlunoValidator;
use Yajra\Datatables\Datatables;

class AlunoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;

    /**
     * @var AlunoValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Turno',
        'Sexo',
        'EstadoCivil',
        'GrauInstrucao',
        'Profissao',
        'CorRaca',
        'TipoSanguinio',
        'Estado',
        'CorRaca'
    ];

    /**
     * @param AlunoService $service
     */
    public function __construct(AlunoService $service, AlunoValidator $validator)
    {
        $this->service    = $service;
        $this->validator  = $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('aluno.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $alunos = \DB::table('fac_alunos')->select(['id', 'nome', 'cpf', 'matricula', 'celular']);

        #Editando a grid
        return Datatables::of($alunos)->addColumn('action', function ($aluno) {
                return '<div class="btn-group btn-group-justified">
                        <a href="edit/'.$aluno->id.'" title="Editar" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="contrato/'.$aluno->id.'" title="Contrato" target="__blanck" class="btn btn-xs btn-primary"><i class="fa fa-file-text"></i></a>
                        <a href="#" class="btn btn-xs btn-primary" title="Curso/Turma" id="link_modal_curso_turma"><i class="glyphicon glyphicon-home"></i></a>
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

        #Retorno para view
        return view('aluno.create', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
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
        } catch (\Throwable $e) {var_dump($e); exit;
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
            #Recuperando o aluno
            $aluno = $this->service->find($id);

            #Tratando as datas
            $aluno = $this->service->getAlunoWithDateFormatPtBr($aluno);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('aluno.edit', compact('aluno', 'loadFields'));
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contrato(Request $request, $id)
    {
        $aluno = $this->service->find($id);

        return \PDF::loadView('reports.contrato', ['aluno' =>  $aluno])->stream();
    }
}
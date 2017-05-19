<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Biblioteca\GeneroService;
use Seracademico\Validators\SalaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use \Prettus\Validator\Contracts\ValidatorInterface;

class RelatorioController extends Controller
{
    /**
     * @var GeneroService
     */
    private $service;

    /**
     * @var SalaValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'PosGraduacao\Curso',
        'Biblioteca\Genero'
    ];

    /**
     * @param GeneroService $service
     * @param SalaValidator $validator
     */
    public function __construct(GeneroService $service, SalaValidator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRelatorioLivrosPorCurso()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('biblioteca.relatorios.report_acervoByCurso', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function relatorioLivrosPorCurso()
    {
        #Criando a consulta
        $rows = \DB::table('bib_genero')->select(['id', 'nome']);

        #Editando a grid
       return $rows;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        //$loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('biblioteca.genero.create');
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
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $result = $this->service->store($data);

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
            #Recuperando a sala
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            //$loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('biblioteca.genero.edit', compact('model'));
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

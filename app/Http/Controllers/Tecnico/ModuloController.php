<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Tecnico\ModuloRepository;
use Seracademico\Services\Tecnico\ModuloService;
use Seracademico\Validators\Tecnico\ModuloValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class ModuloController extends Controller
{
    /**
     * @var ModuloService
     */
    private $service;

    /**
     * @var ModuloValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [

    ];

    public function __construct(ModuloService $service, ModuloValidator $validator, ModuloRepository $repository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->repository =  $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        # Retorno para view
        return view('tecnico.modulo.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Retorno para view
        return view('tecnico.modulo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        } catch (\Throwable $e) {dd($e); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('tec_modulos')
            ->select([
                'id',
                'nome',
                'codigo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar Currículo"><i class="material-icons">edit</i></a></li>
                        <li><a class="grid-materiais btn-floating green" data-id="'.$row->id.'" href="#" title="Adicionar Materiais ao Módulo"><i class="material-icons">add_to_photos</i></a></li>
                    </ul>
                    </div>';
        })->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('tecnico.modulo.edit', compact('model', 'loadFields'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gridByModulo($id)
    {
        #Criando a consulta
        $rows = \DB::table('tec_materiais')
            ->join('tec_modulos', 'tec_modulos.id', '=', 'tec_materiais.modulo_id')
            ->where('modulo_id', $id)
            ->select([
                'tec_materiais.id',
                'tec_materiais.nome',
                'tec_materiais.path'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo removerMaterial" href="#" title="Excluir Material"><i class="material-icons">delete</i></a></li>
                        <li><a class=" btn-floating green downloadFile" href="#" title="Baixar Material"><i class="material-icons">cloud_download</i></a></li>
                    </ul>
                    </div>';
        })->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adicionarMateriais(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->adicionarMateriais($data);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['msg' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function removerMateriais($id)
    {
        try {

            #Executando a ação
            $this->service->removerMateriais($id);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['msg' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['msg' => $e->getMessage()]);
        }
    }
}

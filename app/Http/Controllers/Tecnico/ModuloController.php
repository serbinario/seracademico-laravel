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

            #Executando a ação
            $this->service->store($data);

            #retorno sucesso
            return response()->json(['success' => true, 'msg' => "Disciplinas adicionadas com sucesso!"]);
        } catch (\Throwable $e) {
            #retorno falido
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function grid($id)
    {
        #Criando a consulta
        $rows = \DB::table('tec_modulos')
            ->select([
                'tec_modulos.id',
                'tec_modulos.nome',
                'tec_modulos.codigo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            $modulo = $this->repository->find($row->id);

            $html = "";

            $html .= '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a><ul>';

            $html .= '<li><a class="btn-floating editar-modulo" href="#" title="Editar Módulo"><i class="material-icons">edit</i></a></li>';

            if(count($modulo->disciplinas) <= 0 ) {
                $html .= '<li><a class="btn-floating delete-modulo" href="#" title="Deletar Módulo"><i class="material-icons">delete</i></a></li>';
            }


            $html .= '</ul></div>';

            return $html;
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

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'content' => $model]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'content' => $e->getMessage()]);
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

            #Executando a ação
            $this->service->update($data, $id);

            #retorno sucesso
            return response()->json(['success' => true, 'msg' => "Disciplinas adicionadas com sucesso!"]);
        } catch (\Throwable $e) {
            #retorno falido
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
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
        try {

            #Executando a ação
            $this->service->destroy($id);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['msg' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['msg' => $e->getMessage()]);
        }
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

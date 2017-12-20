<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Tecnico\InscricaoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Tecnico\InscricaoValidator;

class InscricaoController extends Controller
{
    /**
    * @var InscricaoService
    */
    private $service;

    /**
    * @var InscricaoValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'Financeiro\\Taxa|byNivel,4',
    ];

    /**
    * @param InscricaoService $service
    * @param InscricaoValidator $validator
    */
    public function __construct(InscricaoService $service, InscricaoValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('tecnico.inscricao.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('pos_incricoes')
            ->select([
                'id',
                'nome',
                'codigo',
                \DB::raw('DATE_FORMAT(data_inicio, "%d/%m/%Y") as data_inicio'),
                \DB::raw('DATE_FORMAT(data_fim, "%d/%m/%Y") as data_fim'),
                \DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as data_criacao'),
                \DB::raw('IF(ativo, "Ativo", "Desativado") as ativo'),
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Objeto vestibular
            $inscricao = $this->service->find($row->id);

            # Html principal
            $html =  '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar Inscrição"><i class="material-icons">edit</i></a></li>
                            <li><a class="btn-floating green" href="#" id="btnAdicionarCursos" title="Adicionar Cursos ao inscrição"><i class="material-icons">add_to_photos</i></a></li>
                        ';

            # Verificando a possibilida de deleção
            if(count($inscricao->inscritos) == 0 && count($inscricao->cursos) == 0) {
                $html .= '<li><a class="btn-floating indigo" href="delete/'.$row->id.'" title="Editar Inscrição"><i class="material-icons">delete</i></a></li>';
            }

            # Html Principal
            $html .= '</ul></div>';

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
        return view('tecnico.inscricao.create', compact('loadFields'));
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
        } catch (\Throwable $e) {dd($e);
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
            return view('tecnico.inscricao.edit', compact('model', 'loadFields'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->delete($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (\Throwable $e) { dd($e);
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

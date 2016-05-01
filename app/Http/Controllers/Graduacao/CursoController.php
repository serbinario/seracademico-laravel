<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\CursoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Graduacao\CursoValidator;

class CursoController extends Controller
{
    /**
    * @var CursoService
    */
    private $service;

    /**
    * @var CursoValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'TipoCurso',
        'TipoNivelSistema'
    ];

    /**
    * @param CursoService $service
    * @param CursoValidator $validator
    */
    public function __construct(CursoService $service, CursoValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('graduacao.curso.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_cursos')
            ->join('fac_tipo_cursos', 'fac_cursos.tipo_curso_id', '=', 'fac_tipo_cursos.id')
            ->leftJoin('sedes', 'fac_cursos.sede_id', '=', 'sedes.id')
            ->where('fac_cursos.tipo_nivel_sistema_id', 1)
            ->select([
                'fac_cursos.id',
                'fac_cursos.nome',
                'fac_cursos.codigo',
                'sedes.nome as sede',
                'fac_tipo_cursos.nome as tipocurso',
                \DB::raw('IF(fac_cursos.ativo = 1,"SIM","NÃO") as ativo'),
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            $html       = '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                            <li><a class="btn-floating indigo" title="Tabela de precos" id="tabela-precos"><i class="glyphicon glyphicon-list-alt"></i></a></li>
                            <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar Curso"><i class="material-icons">edit</i></a></li>';
            $curso = $this->service->find($row->id);

            if(count($curso->curriculos) == 0 && count($curso->precosCursos) == 0) {
                $html .= '<li><a class="btn-floating red" href="delete/'.$row->id.'" title="Excluir Curso"><i class="material-icons">delete</i></a></li>                        
                            </ul>
                           </div>';
            }

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
        return view('graduacao.curso.create', compact('loadFields'));
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
           // $aluno = $this->service->getAlunoWithDateFormatPtBr($aluno);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('graduacao.curso.edit', compact('model', 'loadFields'));
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
     * @param Request $request
     * @param $id
     */
    public function delete($id)
    {
        try {
            #Executando a ação
            $this->service->delete($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

}
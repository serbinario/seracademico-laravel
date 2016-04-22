<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\CurriculoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\CurriculoValidator;

class CurriculoController extends Controller
{
    /**
    * @var CurriculoService
    */
    private $service;

    /**
    * @var CurriculoValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'Curso'
    ];

    /**
    * @param CurriculoService $service
    * @param CurriculoValidator $validator
    */
    public function __construct(CurriculoService $service, CurriculoValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('curriculo.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_curriculos')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->select([
                'fac_curriculos.id',
                'fac_curriculos.nome',
                'fac_curriculos.codigo',
                'fac_curriculos.ano',
                \DB::raw('DATE_FORMAT(fac_curriculos.valido_inicio, "%d/%m/%Y") as valido_inicio'),
                \DB::raw('DATE_FORMAT(fac_curriculos.valido_fim, "%d/%m/%Y") as valido_fim'),
                'fac_cursos.nome as curso',
                'fac_cursos.codigo as codigo_curso'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a title="Editar Currículo" href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
            <a title="Adicionar Disciplinas ao Currículo" data-id="'. $row->id  .'" href="#" class="grid-curricular btn btn-xs btn-primary"><i class="glyphicon glyphicon-book"></i></a>';
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function gridByCurriculo($id)
    {
        #Criando a consulta
        $rows = \DB::table('fac_curriculo_disciplina')
            ->join('fac_disciplinas', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->leftJoin('fac_tipo_avaliacoes', 'fac_disciplinas.tipo_avaliacao_id', '=', 'fac_tipo_avaliacoes.id')
            ->select([
                    'fac_curriculos.id as idCurriculo',
                    'fac_disciplinas.id',
                    'fac_disciplinas.nome',
                    'fac_disciplinas.qtd_falta',
                    'fac_tipo_disciplinas.nome as tipo_disciplina',
                    'fac_tipo_avaliacoes.nome as tipo_avaliacao']
            )
            ->where('fac_curriculos.id', $id);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a href="#" class="removerDisciplina btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i>Remover</a>';
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
        return view('curriculo.create', compact('loadFields'));
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
            return view('curriculo.edit', compact('model', 'loadFields'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarDisciplinas(Request $request)
    {
        try {
            #Recuperando os valores da requisição e salvando no banco
            $this->service->adicionarDisciplinas($request->all());

            #retorno sucesso
            return response()->json(['sucess' => true, 'msg' => "Disciplinas adicionadas com sucesso!"]);
        } catch (\Throwable $e) {
            #retorno falido
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerDisciplina(Request $request)
    {
        try {
            #Recuperando os valores da requisição e salvando no banco
            $this->service->removerDisciplina($request->all());

            #retorno sucesso
            return response()->json(['sucess' => true, 'msg' => "Disciplinas adicionadas com sucesso!"]);
        } catch (\Throwable $e) {
            #retorno falido
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
        }
    }
}

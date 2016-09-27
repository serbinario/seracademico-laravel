<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\CurriculoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Graduacao\CurriculoValidator;

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
        'Graduacao\\Curso|ativo,1'
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
        return view('graduacao.curriculo.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_curriculos')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->join('tipo_nivel_sistema', 'fac_curriculos.tipo_nivel_sistema_id', '=', 'tipo_nivel_sistema.id')
            ->where('tipo_nivel_sistema.id', 1)
            ->select([
                'fac_curriculos.id',
                'fac_curriculos.nome',
                'fac_curriculos.codigo',
                'fac_curriculos.ano',
                \DB::raw('IF(fac_curriculos.ativo = 1,"SIM","NÃO") as ativo'),
                \DB::raw('DATE_FORMAT(fac_curriculos.valido_inicio, "%d/%m/%Y") as valido_inicio'),
                \DB::raw('DATE_FORMAT(fac_curriculos.valido_fim, "%d/%m/%Y") as valido_fim'),
                'fac_cursos.nome as curso',
                'fac_cursos.codigo as codigo_curso'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar Currículo"><i class="material-icons">edit</i></a></li>
                        <li><a class="btn-floating green" href="#" id="btnGraduacaoAddDisciplinaCurriculo" title="Adicionar Disciplinas ao Currículo"><i class="material-icons">add_to_photos</i></a></li>
                        <li><a class="btn-floating green" href="#" id="btnGraduacaoEletivaOfCurriculo" title="Gernciamento de Eletivas"><i class="material-icons">add_to_photos</i></a></li>
                    </ul>
                    </div>';
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function gridByCurriculo(Request $request, $id)
    {
        #Criando a consulta
        $rows = \DB::table('fac_curriculo_disciplina')
            ->join('fac_disciplinas', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
            ->leftJoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->leftJoin('fac_disciplinas as pre1', 'pre1.id', '=', 'fac_curriculo_disciplina.pre_requisito_1_id')
            ->leftJoin('fac_disciplinas as pre2', 'pre2.id', '=', 'fac_curriculo_disciplina.pre_requisito_2_id')
            ->leftJoin('fac_disciplinas as co1', 'co1.id', '=', 'fac_curriculo_disciplina.co_requisito_1_id')
            ->leftJoin('fac_tipo_avaliacoes', 'fac_disciplinas.tipo_avaliacao_id', '=', 'fac_tipo_avaliacoes.id')
            ->select([
                    'fac_curriculo_disciplina.id as idCurriculoDisciplina',
                    'fac_curriculos.id as idCurriculo',
                    'fac_disciplinas.id',
                    'fac_disciplinas.nome',
                    'fac_disciplinas.codigo',
                    'fac_curriculo_disciplina.qtd_credito',
                    'fac_curriculo_disciplina.qtd_faltas',
                    'fac_curriculo_disciplina.periodo',
                    'fac_curriculo_disciplina.carga_horaria_total',
                    'fac_curriculo_disciplina.carga_horaria_pratica',
                    'fac_curriculo_disciplina.carga_horaria_teorica',
                    'fac_curriculo_disciplina.qtd_credito',
                    'fac_tipo_disciplinas.nome as tipo_disciplina',
                    'fac_tipo_avaliacoes.nome as tipo_avaliacao',
                    \DB::raw('IF(pre1.codigo != "", pre1.codigo, "Não Informado") as pre1Codigo'),
                    \DB::raw('IF(pre2.codigo != "", pre1.codigo, "Não Informado") as pre2Codigo'),
                    \DB::raw('IF(co1.codigo  != "", pre1.codigo, "Não Informado") as co1Codigo')
                ])
            ->where('fac_curriculos.id', $id);

        #Editando a grid
        return Datatables::of($rows)
            ->filter(function ($query) use ($request) {
                if ($request->has('periodo')) {
                    $query->where('periodo', '=', $request->get('periodo'));
                }
            })
            ->addColumn('action', function ($row) {
            # variáveis de uso
            $html       = '<a class="btn-floating indigo" id="editarAdicionarDisicplina" title="Editar Currículo"><i class="material-icons">edit</i></a>';
            $curriculo  = $this->service->find($row->idCurriculo);
            $tumas      = $curriculo->turmas;
            $boolReturn = true;

            # percorre as turmas
            if($tumas) {
                foreach ($tumas as $turma) {
                    if(count($turma->disciplinas) > 0) {
                        $boolReturn = false;
                        break;
                    }
                }
            }


            # Verifica a se a condição é válida
            if($boolReturn) {
                $html .= '<a href="#" id="removeGraduacaoDisciplina" class="btn-floating indigo"><i class="material-icons">delete</i></a>';
            }

            # retorno
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
        return view('graduacao.curriculo.create', compact('loadFields'));
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
        } catch (\Throwable $e) {dd($e); exit;
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
            return view('graduacao.curriculo.edit', compact('model', 'loadFields'));
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

    /**
     * @param Request $request
     * @return mixed
     *
     */
    public function getLoadFields(Request $request)
    {
        try {
            return $this->service->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     */
    public function disciplinaStore(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->disciplinaStore($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Cadastro realizado com sucesso"]);
            // } catch (ValidatorException $e) {
            //     return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function disciplinaDelete(Request $request)
    {
        try {
            #Executando a ação
            $this->service->disciplinaDelete($request->all());

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Remoção realizada com sucesso"]);
        } catch (\Throwable $e) { dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idDisciplina
     * @param $idCurriculo
     * @return mixed
     */
    public function disciplinaEdit($idDisciplina, $idCurriculo)
    {
        try {
            # Recuperando a empresa
            $model = $this->service->disciplinaFind($idDisciplina, $idCurriculo);

            # Array de retorno
            $pivot = [];

            # Preenchendo o array de retorno
            $pivot['qtd_credito']            = $model['model']->qtd_credito;
            $pivot['qtd_faltas']             = $model['model']->qtd_faltas;
            $pivot['nomeDisciplina']         = $model['nomeDisciplina'];
            $pivot['codigoDisciplina']       = $model['codigoDisciplina'];
            $pivot['disciplina_id']          = $model['model']->disciplina_id;
            $pivot['carga_horaria_total']    = $model['model']->carga_horaria_total;
            $pivot['carga_horaria_teorica']  = $model['model']->carga_horaria_teorica;
            $pivot['carga_horaria_pratica']  = $model['model']->carga_horaria_pratica;
            $pivot['periodo']                = $model['model']->periodo;
            $pivot['pre_1_id']               = $model['model']->preRequisito1->id ?? "";
            $pivot['pre_1_nome']             = $model['model']->preRequisito1->nome  ?? "";
            $pivot['pre_2_id']               = $model['model']->preRequisito2->id ?? "";
            $pivot['pre_2_nome']             = $model['model']->preRequisito2->nome ?? "";
            $pivot['pre_3_id']               = $model['model']->preRequisito3->id ?? "";
            $pivot['pre_3_nome']             = $model['model']->preRequisito3->nome ?? "";
            $pivot['pre_4_id']               = $model['model']->preRequisito4->id ?? "";
            $pivot['pre_4_nome']             = $model['model']->preRequisito4->nome ?? "";
            $pivot['pre_5_id']               = $model['model']->preRequisito5->id ?? "";
            $pivot['pre_5_nome']             = $model['model']->preRequisito5->nome ?? "";
            $pivot['co_1_id']                = $model['model']->coRequisito1->id ?? "";
            $pivot['co_1_nome']              = $model['model']->coRequisito1->nome ?? "";

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $pivot]);
        } catch (\Throwable $e) { dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     */
    public function disciplinaUpdate(Request $request, $idDisciplina, $idCurriculo)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->disciplinaUpdate($idDisciplina, $idCurriculo, $data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Edição realizada com sucesso"]);
            // } catch (ValidatorException $e) {
            //     return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idDisciplina
     * @return mixed
     */
    public function getDisciplina($idDisciplina)
    {
        try {
            # Recuperando a empresa
            $model  = $this->service->getDisciplina($idDisciplina);

            #array de retorno
            $result = [];

            # Preenchendo o array de retorno
            $result['qtd_credito']            = $model->qtd_credito;
            $result['qtd_faltas']             = $model->qtd_falta;
            $result['carga_horaria_total']    = $model->carga_horaria;
            $result['carga_horaria_teorica']  = $model->carga_horaria_teorica;
            $result['carga_horaria_pratica']  = $model->carga_horaria_pratica;

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $result]);
        } catch (\Throwable $e) { 
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function reportView()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('graduacao.curriculo.report', compact('loadFields'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function reportById($id)
    {
        try {
            # Fazendo a consulta no banco de dados
            $query = \DB::table('fac_disciplinas')
                ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->leftJoin('fac_disciplinas as preReq1', 'preReq1.id', '=', 'fac_curriculo_disciplina.pre_requisito_1_id')
                ->where('fac_curriculos.id', $id)
                ->select([
                    'fac_curriculos.codigo as codigoCurriculo',
                    'fac_cursos.nome as nomeCurso',
                    'fac_curriculo_disciplina.periodo',
                    'fac_disciplinas.codigo',
                    'fac_disciplinas.nome',
                    'fac_curriculo_disciplina.carga_horaria_total as carga_horaria',
                    'fac_curriculo_disciplina.qtd_credito',
                    'preReq1.codigo as codPreReq1'
                ])->get();

            # Verificando a consulta
            if(count($query) == 0) {
                throw new \Exception('Nenhum dado foi encontrado!');
            }

            # retorno
            return \PDF::loadView('reports.curriculos.curriculo', ['rows' =>  $query])->stream();
            //return view('reports.curriculos.curriculo', ['rows' =>  $query]);
        } catch(\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $idCurso
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getByCurso($idCurso)
    {
        try {
            # Fazendo a consulta no banco de dados
            $rows = \DB::table('fac_curriculos')
                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->where('fac_cursos.id', $idCurso)
                ->select([
                    'fac_curriculos.id',
                    'fac_curriculos.nome',
                ])->get();

            # Verificando a consulta
            if(count($rows) == 0) {
                throw new \Exception('Nenhum dado foi encontrado!');
            }

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'dados' => $rows]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

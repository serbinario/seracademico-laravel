<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\PosGraduacao\CurriculoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\PosGraduacao\CurriculoValidator;

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
        'PosGraduacao\\Curso|ativo,1',
        'SimpleReport|byCrud,4'
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
        #Carregando os dados
        $loadFields = $this->service->load($this->loadFields);

        # Retorno para view
        return view('posGraduacao.curriculo.index', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_curriculos')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->where('fac_curriculos.tipo_nivel_sistema_id', 2)
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
                        <li><a class="grid-curricular btn-floating green" id="btnPosGraduacaoAddDisciplinaCurriculo" href="#" title="Adicionar Disciplinas ao Currículo"><i class="material-icons">add_to_photos</i></a></li>
                    </ul>
                    </div>';
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
                    'fac_disciplinas.codigo',
                    \DB::raw('IF(fac_curriculo_disciplina.qtd_faltas != "", fac_curriculo_disciplina.qtd_faltas, fac_disciplinas.qtd_falta) as qtd_faltas'),
                    \DB::raw('IF(fac_curriculo_disciplina.carga_horaria_total != "", fac_curriculo_disciplina.carga_horaria_total, fac_disciplinas.carga_horaria) as carga_horaria_total'),
                   // 'fac_curriculo_disciplina.qtd_faltas',
                   // 'fac_curriculo_disciplina.carga_horaria_total',
                    'fac_tipo_disciplinas.nome as tipo_disciplina',
                    'fac_tipo_avaliacoes.nome as tipo_avaliacao']
            )
            ->where('fac_curriculos.tipo_nivel_sistema_id', 2)
            ->where('fac_curriculos.id', $id);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # variáveis de uso
            $html = '<a class="btn-floating indigo" id="editarAdicionarDisicplina" title="Editar Currículo"><i class="material-icons">edit</i></a>';

            # Query que vê se a disciplina tem calendário
            $query = \DB::table('fac_calendarios')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_calendarios.turma_disciplina_id')
                ->join('fac_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
                ->join('fac_turmas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
                ->where('fac_disciplinas.id', $row->id)
                ->where('fac_turmas.curriculo_id', $row->idCurriculo)
                ->select([
                    'fac_calendarios.id'
                ])->get();

            # Verifica a se a condição é válida
            if(count($query) == 0) {
                $html .= '<a id="removePosGraduacaoDisciplina" class="removerDisciplina btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';
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
        return view('posGraduacao.curriculo.create', compact('loadFields'));
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

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('posGraduacao.curriculo.edit', compact('model', 'loadFields'));
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

            #Executando a ação
            $this->service->disciplinaUpdate($idDisciplina, $idCurriculo, $data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Edição realizada com sucesso"]);
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
}
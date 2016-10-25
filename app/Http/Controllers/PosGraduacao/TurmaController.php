<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\PosGraduacao\TurmaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\PosGraduacao\TurmaValidator;

class TurmaController extends Controller
{
    /**
    * @var TurmaService
    */
    private $service;

    /**
    * @var TurmaValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'PosGraduacao\\Curso|byCurriculoAtivo,1',
        'Turno',
        'Sala|situacao,1',
        'Professor|getValues'
    ];

    /**
    * @param TurmaService $service
    * @param TurmaValidator $validator
    */
    public function __construct(TurmaService $service, TurmaValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #retorno
        return view('posGraduacao.turma.index', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_turmas')
            ->leftJoin('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
            ->leftJoin('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->leftJoin('fac_turnos', 'fac_turnos.id', '=', 'fac_turmas.turno_id')
            ->where('fac_turmas.tipo_nivel_sistema_id', 2)
            ->select([
                'fac_turmas.id',
                'fac_turmas.codigo as codigo_turma',
                'fac_turmas.valor_turma',
                'fac_turmas.valor_disciplina',
                \DB::raw('DATE_FORMAT(fac_turmas.aula_inicio, "%d/%m/%Y") as aula_inicio'),
                \DB::raw('DATE_FORMAT(fac_turmas.aula_final, "%d/%m/%Y") as aula_final'),
                'fac_cursos.codigo',
                'fac_cursos.nome',
                'fac_turnos.nome as turno'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar da turma"><i class="material-icons">edit</i></a></li>
                        <li><a class="modal-calendario btn-floating green" data-id="'.$row->id.'" href="#" title="Calendário da turma"><i class="material-icons">date_range</i></a></li>
                        <li><a class="btn-floating green" id="modal-notas" href="#" title="Notas da turma"><i class="material-icons">spellcheck</i></a></li>
                        <li><a class="btn-floating green" id="modal-frequencias" href="#" title="Frequências da turma"><i class="material-icons">playlist_add_check</i></a></li>
                        <li><a class="btn-floating green" id="modal-alunos" href="#" title="Gerenciamento de Alunos"><i class="material-icons">supervisor_account</i></a></li>
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

        #Retorno para view
        return view('posGraduacao.turma.create', compact('loadFields'));
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

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('posGraduacao.turma.edit', compact('model', 'loadFields'));
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
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $idCurso
     * @return mixed
     */
    public function getAllByCurso($idCurso)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fac_turmas')
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
                ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
                ->join('fac_turnos', 'fac_turnos.id', '=', 'fac_turmas.turno_id')
                ->where('fac_cursos.id', $idCurso)
                ->select([
                    'fac_turmas.id',
                    'fac_turmas.codigo'
                ])->get();

            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $rows]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idTurma
     * @param $idDisciplina
     * @return mixed
     */
    public function getCalendariosByDisciplina($idTurma, $idDisciplina)
    {
        try {
            #Recuperando a turma
            $turma = $this->service->find($idTurma);

            # Recuperando os calendários
            $calendarios = $turma->disciplinas()->find($idDisciplina)->pivot->calendarios()->get();

            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $calendarios]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}

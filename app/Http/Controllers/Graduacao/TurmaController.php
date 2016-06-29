<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\TurmaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Graduacao\TurmaValidator;
use Seracademico\Http\Controllers\Controller;

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
        'Graduacao\Curso|byCurriculoAtivo,1',
        'Turno',
        'Sala|situacao,1',
        'Professor',
        'Graduacao\Semestre'
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
        return view('graduacao.turma.index', compact('loadFields'));
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
            ->leftJoin('fac_semestres', 'fac_semestres.id', '=', 'fac_turmas.semestre_id')
            ->where('fac_turmas.tipo_nivel_sistema_id', 1)
            ->select([
                'fac_turmas.id',
                'fac_turmas.codigo as codigo_turma',
                \DB::raw('DATE_FORMAT(fac_turmas.aula_inicio, "%d/%m/%Y") as aula_inicio'),
                \DB::raw('DATE_FORMAT(fac_turmas.aula_final, "%d/%m/%Y") as aula_final'),
                'fac_cursos.codigo',
                'fac_cursos.nome',
                'fac_turnos.nome as turno',
                'fac_turmas.periodo',
                'fac_semestres.nome as semestre'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar da turma"><i class="material-icons">edit</i></a></li>
                        <li><a class="btn-floating green" id="modal-horario" href="#" title="Calendário da turma"><i class="material-icons">date_range</i></a></li>
                        <li><a class="btn-floating green" id="modal-notas" href="#" title="Notas da turma"><i class="material-icons">date_range</i></a></li>
                        <li><a class="btn-floating green" id="modal-frequencias" href="#" title="Frequências da turma"><i class="material-icons">date_range</i></a></li>
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
        return view('graduacao.turma.create', compact('loadFields'));
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
            return view('graduacao.turma.edit', compact('model', 'loadFields'));
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
}

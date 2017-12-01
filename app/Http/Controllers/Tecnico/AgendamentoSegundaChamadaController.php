<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Tecnico\AgendamentoSegundaChamadaRepository;
use Seracademico\Services\Tecnico\AgendamentoSegundaChamadaService;
use Seracademico\Validators\Tecnico\AgendamentoSegundaChamadaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class AgendamentoSegundaChamadaController extends Controller
{
    /**
     * @var AgendamentoSegundaChamadaService
     */
    private $service;

    /**
     * @var AgendamentoSegundaChamadaValidator
     */
    private $validator;

    /**
     * @var AgendamentoSegundaChamadaRepository
     */
    private $repository;

    /**
     * @var array
     */
    private $loadFields = [
        'Tecnico\\AgendamentoTipoProva',
        'Tecnico\\Disciplina|DisciplinaTecnico',
        'Tecnico\\Curso|ativo,1',
    ];

    public function __construct(AgendamentoSegundaChamadaService $service,
                                AgendamentoSegundaChamadaValidator $validator,
                                AgendamentoSegundaChamadaRepository $repository)
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
        return view('tecnico.agendamento.index');
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
        $rows = \DB::table('pos_agendamentos_segunda_chamada')
            ->join('pos_agendamentos_tipos_provas', 'pos_agendamentos_tipos_provas.id', '=', 'pos_agendamentos_segunda_chamada.agendamento_tp_id')
            ->select([
                'pos_agendamentos_segunda_chamada.id',
                \DB::raw('DATE_FORMAT(pos_agendamentos_segunda_chamada.data, "%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(pos_agendamentos_segunda_chamada.hora_inicio, "%h:%i") as hora_inicio'),
                \DB::raw('DATE_FORMAT(pos_agendamentos_segunda_chamada.hora_final, "%h:%i") as hora_final'),
                \DB::raw('DATE_FORMAT(pos_agendamentos_segunda_chamada.hora_entrada, "%h:%i") as hora_entrada'),
                'pos_agendamentos_tipos_provas.nome as tipo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar Agendamento"><i class="material-icons">edit</i></a></li>
                        <li><a class="modal-aluno btn-floating green" data-id="'.$row->id.'" href="#" title="Agendar aluno"><i class="material-icons">date_range</i></a></li>
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
        return view('tecnico.agendamento.create', compact('loadFields'));
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
            return view('tecnico.agendamento.edit', compact('model', 'loadFields'));
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
    public function getDisciplinas(Request $request)
    {

        $disciplinas = \DB::table('fac_curriculo_disciplina')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_curriculo_disciplina.disciplina_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->where('fac_cursos.id', $request->get('curso'))
            ->where('fac_disciplinas.tipo_nivel_sistema_id', 4)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
            ])->get();

        return \Illuminate\Support\Facades\Response::json($disciplinas);
    }
}

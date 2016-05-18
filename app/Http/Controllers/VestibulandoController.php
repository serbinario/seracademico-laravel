<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Aluno;
use Seracademico\Entities\Curriculo;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\AlunoService;
use Seracademico\Services\VestibulandoService;
use Seracademico\Validators\AlunoValidator;
use Yajra\Datatables\Datatables;

class VestibulandoController extends Controller
{
    /**
     * @var VestibulandoService
     */
    private $service;

    /**
     * @var AlunoValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Turno',
        'Sexo',
        'EstadoCivil',
        'GrauInstrucao',
        'Profissao',
        'CorRaca',
        'TipoSanguinio',
        'Estado',
        'CorRaca',
        'Vestibular',
        'Graduacao\\Curso|ativo,1',
        'Turno',
        'Sala',
        'LinguaExtrangeira'
    ];

    /**
     * @param VestibulandoService $service
     * @param AlunoValidator $validator
     */
    public function __construct(VestibulandoService $service, AlunoValidator $validator)
    {
        $this->service    = $service;
        $this->validator  = $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('vestibulando.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $alunos = \DB::table('fac_alunos')
            ->join('vestibulares', 'vestibulares.id', '=' , 'fac_alunos.vestibular_id')
            ->where('fac_alunos.tipo_aluno_id', 1)

            ->select(['fac_alunos.id', 'fac_alunos.nome', 'fac_alunos.cpf', 'fac_alunos.matricula', 'fac_alunos.celular', 'fac_alunos.inscricao',
            'vestibulares.nome as vestibular' ]);

        #Editando a grid
        return Datatables::of($alunos)->addColumn('action', function ($aluno) {
            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating" href="edit/'.$aluno->id.'" title="Editar aluno"><i class="material-icons">edit</i></a></li>
                        <li><a class="btn-floating" id="inclusao" title="Trasnferir para aluno"><i class="material-icons">chrome_reader_mode</i></a></li>
                        <li><a class="btn-floating" id="notas" title="Notas"><i class="material-icons">chrome_reader_mode</i></a></li>
                    </ul>
                    </div>';
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function gridNotas($idVestibulando)
    {
        #Criando a consulta
        $alunos = \DB::table('aluno_notas_vestibular')
            ->join('fac_materias', 'fac_materias.id', '=', 'aluno_notas_vestibular.materia_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'aluno_notas_vestibular.aluno_id')
            ->where('fac_alunos.id', $idVestibulando)
            ->select([
                'aluno_notas_vestibular.id',
                'fac_materias.codigo',
                'fac_materias.nome',
                'aluno_notas_vestibular.acertos',
                'aluno_notas_vestibular.pontuacao'
            ]);

        #Editando a grid
        return Datatables::of($alunos)->addColumn('action', function ($aluno) {
            return '<a class="btn-floating" id="editarNotas" title="Editar aluno"><i class="material-icons">edit</i></a>';
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
        return view('vestibulando.create', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
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
        } catch (\Throwable $e) {var_dump($e); exit;
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
            #Recuperando o aluno
            $aluno = $this->service->find($id);

            #Tratando as datas
            $aluno = $this->service->getAlunoWithDateFormatPtBr($aluno);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('vestibulando.edit', compact('aluno', 'loadFields'));
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
     * @return mixed
     */
    public function editNota(Request $request)
    {
        try {
            #Recuperando o aluno
            $nota  = $this->service->findNota($request->all());

            # Preparando o array de retorno
            $dados = [
                'codigo' => $nota->materia->codigo,
                'materia' => $nota->materia->nome,
                'acertos' => $nota->acertos,
                'pontuacao' => $nota->pontuacao,
            ];

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $dados]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateNota(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->updateNota($data, $id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Alteração realizada com sucesso']);
        } catch (\Throwable $e) {
            #Retorno para a view
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

    public function editInclusao($idVestibulando)
    {
        try {
            # Recuperando o vestibulando
            $vestibulando = $this->service->find($idVestibulando);
            $dadosRetorno = [];

            # Validando se existe uma inclusão cadastrada
            if(!$vestibulando->inclusao) {
                $inclusao = $vestibulando->inclusao()->create(['data_inclusao'=>null]);
            } else {
                $inclusao = $vestibulando->inclusao;
            }

            # Populando o array de retorno
            $dadosRetorno['curso_id'] = isset($inclusao->curriculo->id) ? $inclusao->curriculo->curso->id : null;
            $dadosRetorno['turno_id'] = isset($inclusao->turno->id) ? $inclusao->turno->id : null;
            $dadosRetorno['data_inclusao'] = $inclusao->data_inclusao;
            $dadosRetorno['forma_admissao_id'] = isset($inclusao->formaAdmissao->id) ? $inclusao->formaAdmissao->id : null;


            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dadosRetorno]);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateInclusao(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->updateInclusao($data, $id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Vestibulando transferido com sucesso!']);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
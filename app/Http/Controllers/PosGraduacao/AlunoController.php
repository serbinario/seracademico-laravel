<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\PosGraduacao\Aluno;
use Seracademico\Facades\ParametroMatriculaFacade;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PosGraduacao\AlunoService;
use Seracademico\Validators\PosGraduacao\AlunoValidator;
use Yajra\Datatables\Datatables;

class AlunoController extends Controller
{
    /**
     * @var AlunoService
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
        'SituacaoAluno',
        'PosGraduacao\\Curso|byCurriculoAtivo,1',
        'Turno',
        'FormaAdmissao',
        'Graduacao\\Semestre',
        'SituacaoAluno',
        'SimpleReport|byCrud,1',
        'PosGraduacao\\Turma|posGraduacao',
        'PosGraduacao\\Curso|ativo,1',
        'PosGraduacao\\CanalCaptacao',
        'PosGraduacao\\TipoPretensao'
    ];

    /**
     * @param AlunoService $service
     */
    public function __construct(AlunoService $service, AlunoValidator $validator)
    {
        $this->service    = $service;
        $this->validator  = $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try {
            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            # retorno
            return view('posGraduacao.aluno.index', compact('loadFields'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function grid(Request $request)
    {
        try {
            #Criando a consulta
            $alunos = \DB::table('pos_alunos')
                ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
                ->leftJoin('pos_alunos_cursos', function ($join) {
                    $join->on(
                        'pos_alunos_cursos.id', '=',
                        \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                    );
                })
                ->leftJoin('pos_alunos_situacoes', function ($join) {
                    $join->on(
                        'pos_alunos_situacoes.id', '=',
                        \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                        where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                    );
                })
                ->leftJoin('fac_situacao', 'fac_situacao.id', '=', 'pos_alunos_situacoes.situacao_id')
                ->leftJoin('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
                ->leftJoin('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->select([
                    'pos_alunos.id',
                    'pessoas.nome',
                    'pessoas.cpf',
                    'pos_alunos.matricula',
                    'pessoas.celular',
                    'fac_curriculos.codigo as codigoCurriculo',
                    \DB::raw('IF(pos_alunos.matricula = "", "PENDENTE",fac_situacao.nome) as nomeSituacao'),
                    'fac_cursos.codigo as codigoCurso'
                ]);

            #Editando a grid
            return Datatables::of($alunos)
                ->filter(function ($query) use ($request) {
                    # Filtrando por situação
                    if ($request->has('situacao')) {
                        $query->where('fac_situacao.id', '=', $request->get('situacao'));
                    }

                    # Filtrando Global
                    if ($request->has('globalSearch')) {
                        # recuperando o valor da requisição
                        $search = $request->get('globalSearch');

                        #condição
                        $query->where(function ($where) use ($search) {
                            $where->orWhere('pessoas.nome', 'like', "%$search%")
                                ->orWhere('pessoas.cpf', 'like', "%$search%")
                                ->orWhere('fac_alunos.matricula', 'like', "%$search%")
                                ->orWhere('fac_curriculos.codigo', 'like', "%$search%");
                        });
                    }
                })
                ->addColumn('action', function ($aluno) {
                    /**
                     *   <li><a class="btn-floating" href="edit/' . $aluno->id . '" title="Editar aluno"><i class="material-icons">edit</i></a></li>
                    <li><a class="btn-floating indigo" title="Histórico do aluno" id="modalHistorico"><i class="glyphicon glyphicon-list-alt"></i></a></li>
                    <li><a class="btn-floating indigo" title="Currículo do aluno" id="modalCurriculo"><i class="material-icons">assignment</i></a></li>
                    <li><a class="btn-floating indigo" title="Semestre do aluno"  id="modalSemestre"><i class="material-icons">date_range</i></a></li>
                    <li><a class="btn-floating indigo" title="Benefícios do Aluno" id="modalBeneficio"><i class="material-icons">account_balance_wallet</i></a></li>
                    <li><a class="btn-floating indigo" title="Financeiro do Aluno" id="modalFinanceiro"><i class="material-icons">attach_money</i></a></li>
                    <li><a class="btn-floating" target="_blank" href="contrato/' . $aluno->id . '" title="Contrato"><i class="material-icons">print</i></a></li>
                     */

                    $html = "";

                    $html .= '<div class="fixed-action-btn horizontal">';
                    $html .=    '<a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>';
                    $html .=    '<ul>';
                    $html .=        '<li><a class="btn-floating" href="edit/' . $aluno->id . '" title="Editar aluno"><i class="material-icons">edit</i></a></li>';
                    $html .=        '<li><a class="btn-floating" title="Curso / Turma" id="link_modal_curso_turma"><i class="material-icons">chrome_reader_mode</i></a></li>';
                        //if($aluno->matricula) {
                            $html .= '<li><a class="btn-floating" target="_blank" href="contrato/' . $aluno->id . '" title="Contrato"><i class="material-icons">print</i></a></li>';
                       // }
                    $html .=    '</ul>';
                    $html .=   '</div>';

                    return $html;
                })->make(true);
        } catch (\Throwable $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('posGraduacao.aluno.create', compact('loadFields'));
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
        } catch (\Throwable $e) {
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
           
            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('posGraduacao.aluno.edit', compact('aluno', 'loadFields'));
        } catch (\Throwable $e) {
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
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $dados = $this->service->search(key($data), $data[key($data)]);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contrato(Request $request, $id)
    {
        $aluno = $this->service->find($id);

        $data = new \DateTime('now');
        $curso = "";
        $turma = "";

        $curso = \DB::table('pos_alunos_cursos')
            ->join('fac_curriculos', 'pos_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id')
            ->where('pos_alunos_cursos.aluno_id', '=', $aluno->id)
            ->orderBy('pos_alunos_cursos.id', 'DESC')
            ->limit(1)
            ->select([
                'fac_curriculos.*'
            ])->first();

        $turma = \DB::table('pos_alunos_turmas')
            ->join('fac_turmas', 'pos_alunos_turmas.turma_id', '=', 'fac_turmas.id')
            ->where('pos_alunos_turmas.aluno_id', '=', $aluno->id)
            ->orderBy('pos_alunos_turmas.id', 'DESC')
            ->limit(1)
            ->select([
                'fac_turmas.*'
            ])->first();
        
        if(!$curso && !$turma) {
            return redirect()->back()->with("message", "Este aluno não foi vinculado a um curso e turma!");
        }

        if(!$turma->aula_inicio || !$turma->aula_final || !$turma->qtd_parcelas || !$turma->duracao_meses || !$turma->valor_turma) {
            return redirect()->back()->with("message", "Para gerar o contrato é necessário ter as seguintes informações em turmas: 
            aula inicial, aula final, quantidade de parcelas, duração de mêses e valor da turma");
        }

        if(!$aluno->data_contrato) {
            $aluno->data_contrato = $data->format('Y-m-d');
            $aluno->save();
        }

        return \PDF::loadView('reports.contrato', ['aluno' =>  $aluno, 'curso' => $curso, 'turma' => $turma])->stream();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reportFilter(Request $request)
    {
        try {
            # recuperando os semestres de congiruração
            $semestreVigente = ParametroMatriculaFacade::getSemestreVigente();

            #Criando a consulta
            $alunos = \DB::table('fac_alunos')
                ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
                ->join('fac_alunos_cursos', function ($join) {
                    $join->on(
                        'fac_alunos_cursos.id', '=',
                        \DB::raw('(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = fac_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                    );
                })
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_cursos.curriculo_id')
                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.aluno_id', '=', 'fac_alunos.id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
                ->join('fac_alunos_situacoes', function ($join) {
                    $join->on(
                        'fac_alunos_situacoes.id', '=',
                        \DB::raw('(SELECT situacao_secundaria.id FROM fac_alunos_situacoes as situacao_secundaria
                         where situacao_secundaria.aluno_semestre_id = fac_alunos_semestres.id ORDER BY situacao_secundaria.id DESC LIMIT 1)')
                    );
                })
                ->join('fac_situacao', 'fac_situacao.id', '=', 'fac_alunos_situacoes.situacao_id')
                ->select([
                    'fac_alunos.id',
                    'pessoas.nome',
                    'pessoas.cpf',
                    'fac_alunos.matricula',
                    'pessoas.celular',
                    'fac_semestres.id as idSemestre',
                    'fac_semestres.nome as semestre',
                    'fac_alunos_semestres.periodo',
                    'fac_curriculos.codigo as codigoCurriculo',
                    'fac_situacao.nome as nomeSituacao',
                    'fac_cursos.codigo as codigoCurso'
                ]);

            # Filtrando por semestre
            if ($request->has('semestre')) {
                $alunos->where('fac_semestres.id', '=', $request->get('semestre'));
            } else if (count($semestreVigente) == 2) {
                $alunos->where('fac_semestres.id', '=', $semestreVigente->id);
            }

            # Filtrando por situação
            if ($request->has('situacao')) {
                $alunos->where('fac_situacao.id', '=', $request->get('situacao'));
            }

            # Filtrando Global
            if ($request->has('globalSearch')) {
                # recuperando o valor da requisição
                $search = $request->get('globalSearch');

                #condição
                $alunos->where(function ($where) use ($search) {
                    $where->orWhere('pessoas.nome', 'like', "%$search%")
                        ->orWhere('pessoas.cpf', 'like', "%$search%")
                        ->orWhere('fac_alunos.matricula', 'like', "%$search%")
                        ->orWhere('fac_curriculos.codigo', 'like', "%$search%")
                        ->orWhere('fac_semestres.nome', 'like', "%$search%");
                });
            }

            # Recuperando os alunos
            $rows = $alunos->get();

            # Verificando se foi retornado registros
            if(count($rows) == 0) {
                throw new \Exception('Nunhum aluno foi encontrado');
            }

            # Retorno
            return \PDF::loadView('reports.alunos.relatorioFilter', ['rows' => $rows])->stream();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function getImgAluno($id)
    {
        #Recuperando a empresa
        $model = $this->service->find($id);

        if($model->tipo_img == 1) {
            return response($model->path_image) ->header('Content-Type', 'image/jpeg');
        } else {
            return response(base64_decode($model->path_image )) ->header('Content-Type', 'image/jpeg');
        }


    }
}
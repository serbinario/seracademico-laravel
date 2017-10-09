<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        'Turno',
        'FormaAdmissao',
        'SituacaoAluno',
        'Sede',
        'SimpleReport|byCrud,1',
        'PosGraduacao\\Turma|PosGraduacao',
        'PosGraduacao\\Curso|ativo,1',
        'PosGraduacao\\CanalCaptacao',
        'PosGraduacao\\TipoPretensao',
        'PosGraduacao\\Curso|byCurriculoAtivo,1'
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
                ->leftJoin('pos_alunos_turmas', function ($join) {
                    $join->on(
                        'pos_alunos_turmas.id', '=',
                        \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                    );
                })
                ->leftJoin('pos_alunos_situacoes', function ($join) {
                    $join->on(
                        'pos_alunos_situacoes.id', '=',
                        \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                        where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                    );
                })
                ->leftJoin('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
                ->leftJoin('fac_situacao', 'fac_situacao.id', '=', 'pos_alunos_situacoes.situacao_id')
                ->leftJoin('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
                ->leftJoin('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->where('pos_alunos.tipo_aluno_id', null)
                ->select([
                    'pos_alunos.id',
                    'pos_alunos.data_matricula',
                    'pos_alunos_turmas.id as idAlunoTurma',
                    'pos_alunos_cursos.id as idAlunoCurso',
                    'pessoas.nome',
                    \DB::raw('CONCAT(SUBSTR(pessoas.cpf,1,3), ".", SUBSTR(pessoas.cpf,4,3), ".", SUBSTR(pessoas.cpf,7,3), "-", SUBSTR(pessoas.cpf,10,2)) AS cpf'),
                    'pos_alunos.matricula',
                    'pessoas.celular',
                    'fac_curriculos.codigo as codigoCurriculo',
                    \DB::raw('IF(pos_alunos.matricula = "", "PENDENTE",fac_situacao.nome) as nomeSituacao'),
                    'fac_cursos.codigo as codigoCurso',
                    'fac_cursos.nome as nomeCurso',
                    'fac_turmas.codigo as codigoTurma'
                ]);

            # Verificando se o usuário possui sede
            if(Auth::user()->sede_id != 1) {
                $alunos->where('fac_turmas.sede_id', Auth::user()->sede_id);
            }

            #Editando a grid
            return Datatables::of($alunos)
                ->filter(function ($query) use ($request) {
                    # Filtrando por curso
                    if ($request->has('curso')) {
                        $query->where('fac_cursos.id', '=', $request->get('curso'));
                    }

                    # Filtrando por turma
                    if ($request->has('turma')) {
                        $query->where('fac_turmas.id', '=', $request->get('turma'));
                    }

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
                                ->orWhere('pessoas.telefone_fixo', 'like', "%$search%")
                                ->orWhere('pessoas.celular', 'like', "%$search%")
                                ->orWhere('pessoas.celular2', 'like', "%$search%")
                                ->orWhere('pos_alunos.matricula', 'like', "%$search%")
                                ->orWhere('fac_curriculos.codigo', 'like', "%$search%");
                        });
                    }
                })
                ->addColumn('action', function ($aluno) {
                    $html = "";

                    $html .= '<div class="fixed-action-btn horizontal">';
                    $html .=    '<a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>';
                    $html .=    '<ul>';
                    $html .=        '<li><a class="btn-floating" href="edit/' . $aluno->id . '" title="Editar aluno"><i class="material-icons">edit</i></a></li>';

                    # Verificando se o usuário possui sede
                    if(Auth::user()->sede_id == 1) {
                        $html .=    '<li><a class="btn-floating" title="Histório do Aluno" id="link_modal_curso_turma"><i class="material-icons">chrome_reader_mode</i></a></li>';
                        $html .=    '<li><a class="btn-floating" title="Currículo do Aluno" id="btnModalCurriculo"><i class="material-icons">chrome_reader_mode</i></a></li>';
                        $html .=    '<li><a class="btn-floating" title="Financeiro do Aluno" id="btnModalFinanceiro"><i class="material-icons">attach_money</i></a></li>';
                    }

                    $html .=    '<li><a class="btn-floating" id="aluno_documentos" title="Documentos"><i class="material-icons">print</i></a></li>';

                    $html .=    '</ul>';
                    $html .= '</div>';

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
            return redirect()->back()->withErrors([$e->getMessage()]);
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
            return redirect()->back()->withErrors([$e->getMessage()]);
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
            return redirect()->back()->withErrors([$e->getMessage()]);
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
            $verificador = $this->verificarMatriculaPor($data);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados, 'verificador' => $verificador]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $data
     * @return mixed
     * @author felipe
     * @description possibilita verificar, através do cpf inserido no campo de busca, se o aluno já se encontra cadas-
     * trado com situação diferente de cancelado
     */
    public function verificarMatriculaPor($data)
    {
        $retorno = false;

        $query = \DB::table('pessoas')
            ->join('pos_alunos', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->join('pos_alunos_cursos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->join('pos_alunos_situacoes', 'pos_alunos_cursos.id', '=', 'pos_alunos_situacoes.pos_aluno_curso_id')
            ->where('pessoas.cpf', '=', $data['cpf'])
            ->where('pos_alunos_situacoes.situacao_id', '!=', 10) //10 = cancelado
            ->where('pos_alunos.tipo_aluno_id', '=', null) //pos-graduacao = null
            ->get();

        if (count($query) > 0) {
            $retorno = true;
        }

        return $retorno;
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
            return redirect()->back()->withErrors([$e->getMessage()]);
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

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeProfissao(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->insertValor($data);

            #Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function findProfissao()
    {
        try{
            $profissoes = \DB::table('profissoes')
                ->select(['id', 'nome as title'])
                ->get();

            //retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'items' => $profissoes]);
        } catch (\Throwable $e) {
            dd($e->getMessage());
//            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }
}
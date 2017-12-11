<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Facades\ParametroMatriculaFacade;
use Seracademico\Facades\ParametroVestibularFacade;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\VestibulandoService;
use Seracademico\Validators\Graduacao\VestibulandoValidator;
use Seracademico\Repositories\Graduacao\VestibulandoRepository;
use Seracademico\Repositories\Vestibular\VestibularAgendamentoRepository;
use Yajra\Datatables\Datatables;

class VestibulandoController extends Controller
{
    /**
     * @var VestibulandoService
     */
    private $service;

    /**
     * @var VestibulandoValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Graduacao\\Semestre',
        'Turno',
        'Sexo',
        'EstadoCivil',
        'GrauInstrucao',
        'Profissao',
        'CorRaca',
        'TipoSanguinio',
        'Estado',
        'CorRaca',
        # [RFV003-RN005] - Documento de Requisitos
        # Esse parâmetro retornará só o vestibular ativo.
        'Graduacao\\Vestibular|ativo,1',
        'Graduacao\\Curso|ativo,1',
        'Turno',
        'Sala',
        'LinguaExtrangeira'
    ];

    /**
     * Método Construtor
     *
     * Método responsável por iniciar o objeto com duas referências
     * Service e Validator respectivamente.
     *
     * @param VestibulandoService $service
     * @param VestibulandoValidator $validator
     */
    public function __construct(
        VestibulandoService $service,
        VestibulandoValidator $validator,
        VestibulandoRepository $repository,
        VestibularAgendamentoRepository $agendamentoRepository)
    {
        $this->service    = $service;
        $this->validator  = $validator;
        $this->repository  = $repository;
        $this->agendamentoRepository  = $agendamentoRepository;
    }

    /**
     * Método Index
     *
     * Método responsável por carregar a view correspondente
     * e alguns dados necessários para seu carregamento
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        # Recuperando os loads
        $arrayLoadFields = $this->loadFields;
        $arrayLoadFields[10] = "Graduacao\\Vestibular";

        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($arrayLoadFields);
        $datas = $this->agendamentoRepository->buscarDatas();

        # Recuperando o vestibular ativo
        $vestibularAtivo = ParametroVestibularFacade::getAtivo();

        # Retorno
        return view('vestibulando.index', compact('loadFields', 'vestibularAtivo', 'datas'));
    }

    /**
     * Método Grid
     *
     * Método responsável por criar a query necessária para o
     * carregamento da grid, junto com a criação de colunas e
     * filtros personalizados.
     *
     * @return mixed
     */
    public function grid(Request $request)
    {
        #Criando a consulta
        $vestibulandos = \DB::table('fac_vestibulandos')
            ->join('pessoas', 'pessoas.id', '=', 'fac_vestibulandos.pessoa_id')
            ->join('fac_vestibulares', 'fac_vestibulares.id', '=' , 'fac_vestibulandos.vestibular_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_vestibulares.semestre_id')
            ->leftJoin('fac_vestibulandos_financeiros', 'fac_vestibulandos_financeiros.vestibulando_id', '=', 'fac_vestibulandos.id')
            ->leftJoin('fin_taxas', 'fin_taxas.id', '=', 'fac_vestibulandos_financeiros.taxa_id')
            ->leftJoin('fin_tipos_taxas', 'fin_tipos_taxas.id', '=', 'fin_taxas.tipo_taxa_id')
            ->leftJoin('fac_cursos as curso1', 'curso1.id', '=', 'fac_vestibulandos.primeira_opcao_curso_id')
            ->leftJoin('fac_cursos as curso2', 'curso2.id', '=', 'fac_vestibulandos.segunda_opcao_curso_id')
            ->leftJoin('fac_cursos as curso3', 'curso3.id', '=', 'fac_vestibulandos.terceira_opcao_curso_id')
            ->leftJoin('fac_turnos as turno1', 'turno1.id', '=', 'fac_vestibulandos.primeira_opcao_turno_id')
            ->leftJoin('fac_turnos as turno2', 'turno2.id', '=', 'fac_vestibulandos.segunda_opcao_turno_id')
            ->leftJoin('fac_turnos as turno3', 'turno3.id', '=', 'fac_vestibulandos.terceira_opcao_turno_id')
            ->leftJoin('fac_alunos', 'fac_alunos.vestibulando_id', '=', 'fac_vestibulandos.id')
            ->leftJoin('vest_agendamento', 'vest_agendamento.id', '=', 'fac_vestibulandos.agendamento_id')
            ->groupBy('fac_vestibulandos.id')
            ->select([
                'fac_vestibulandos.id',
                'fac_vestibulandos.media_enem as media_enem',
                'fac_vestibulandos.media_ficha as media_ficha',
                'pessoas.nome',
                'pessoas.cpf',
                'pessoas.celular',
                \DB::raw('IF(fac_vestibulandos.inscricao,CONCAT(fac_vestibulares.codigo,fac_vestibulandos.inscricao), "Pendente") as inscricao'),
                'curso1.nome as nomeCurso1',
                'curso2.nome as nomeCurso2',
                'curso3.nome as nomeCurso3',
                'turno1.nome as nomeTurno1',
                'turno2.nome as nomeTurno2',
                'turno3.nome as nomeTurno3',
                'fac_vestibulares.nome as vestibular',
                'fac_vestibulares.id as idVestibular',
                'fin_tipos_taxas.id as idTipoTaxa',
                'fac_vestibulandos_financeiros.pago',
                'fac_semestres.nome as nomeSemestre',
                'vest_agendamento.id as idData',
                \DB::raw('IF(fac_alunos.id, "TRANSFERIDO", "NÃO TRANSFERIDO") as transferencia'),
                \DB::raw('IF(fac_vestibulandos.enem, "ENEM", "FICHA 19") as formaAvaliacao')
            ]);

        #Editando a grid
        return Datatables::of($vestibulandos)
            ->filter(function ($query) use ($request) {
                # Filtranto por vestibular
                if ($request->has('vestibular')) {
                    $query->where('fac_vestibulares.id', '=', $request->get('vestibular'));
                }

                # Filtrando por pagos
                if ($request->has('pago')) {
                    $query->where('fac_vestibulandos_financeiros.pago', '=', $request->get('pago'));
                    $query->where('fin_tipos_taxas.id', '=', 1);
                }

                # Filtrando por forma de avaliação
                if ($request->has('formaAvaliacao')) {
                    $query->where('fac_vestibulandos.enem', '=', $request->get('formaAvaliacao'));
                }

                # Filtrando por data de realização de prova
                if ($request->has('dataAvaliacaoSearch')) {
                    $query->where('vest_agendamento.id', '=', $request->get('dataAvaliacaoSearch'));
                }

                # Filtrando Por Curso
                if ($request->has('cursoSearch')) {
                    # recuperando o valor da requisição
                    $cursoSearch = $request->get('cursoSearch');
                    $opcaoSearch = !empty($request->get('opcaoCurso')) ? $request->get('opcaoCurso')  : 4;

                    # Escolha das opções de curso para filtro
                    switch($opcaoSearch) {
                        case 1  : $query->where('curso1.id', '=', $cursoSearch); break;
                        case 2  : $query->where('curso2.id', '=', $cursoSearch); break;
                        case 3  : $query->where('curso3.id', '=', $cursoSearch); break;
                        default : $query->where(function ($where) use ($cursoSearch) {
                                    $where->orWhere('curso1.id', '=', $cursoSearch)
                                        ->orWhere('curso2.id', '=', $cursoSearch)
                                        ->orWhere('curso3.id', '=', $cursoSearch);
                                    });
                    }
                }

                # Filtrando Global
                if ($request->has('globalSearch')) {
                    # recuperando o valor da requisição
                    $search = $request->get('globalSearch');
                   
                    #condição
                    $query->where(function ($where) use ($search) {
                        $where->orWhere('pessoas.nome', 'like', "%$search%")
                            ->orWhere('pessoas.cpf', 'like', "%$search%")
                            ->orWhere(\DB::raw('CONCAT(fac_vestibulares.codigo,fac_vestibulandos.inscricao)'), 'like', "%$search%");
                    });
                }
            })
            ->addColumn('action', function ($row) {
                $html = '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                                <li><a class="btn-floating" href="edit/'.$row->id.'" title="Editar aluno"><i class="material-icons">edit</i></a></li>
                                <li><a class="btn-floating" href="delete/'.$row->id.'" title="Deletar aluno"><i class="material-icons">delete</i></a></li>
                         ';

                # regra de negócio para transferir o vestibulando
                # recuperando o vestibulando
                $vestibulando = $this->service->find($row->id);

                # Varrendo os débitos do vestibulando
                foreach ($vestibulando->debitos as $debito) {
                    # [RFV003-RN012] : Documento de Requisitos
                    # Verificando se a matrícula foi pága
                    if($debito->pago && $debito->taxa->tipoTaxa->id == 1 && !$vestibulando->aluno) {
                        $html .= '<li><a class="btn-floating" id="inclusao" title="Transferir para aluno"><i class="material-icons">portrait</i></a></li>';
                        $html .= '<li><a target="_blank" href="financeiro/gerarComprovanteInscricao/'.$row->id.'" class="btn-floating" id="comprovante" title="Gerar Comprovante de Inscriçao"><i class="material-icons">portrait</i></a></li>';
                        break;
                    }
                }

                # Fim do html
                $html .= '                                
                                <li><a class="btn-floating" id="financeiro" title="Financeiro"><i class="material-icons">attach_money</i></a></li>
                            </ul>
                        </div>';

                # retorno
                return $html;
            })->make(true);
    }

    /**
     * Método Grid (Notas)
     *
     * Método responsável por criar a query necessária para o
     * carregamento da grid, junto com a criação de colunas e
     * filtros personalizados.
     *
     * @return mixed
     */
    public function gridNotas($idVestibulando)
    {
        #Criando a consulta
        $alunos = \DB::table('fac_vestibulandos_notas_vestibulares')
            ->join('fac_materias', 'fac_materias.id', '=', 'fac_vestibulandos_notas_vestibulares.materia_id')
            ->join('fac_vestibulandos', 'fac_vestibulandos.id', '=', 'fac_vestibulandos_notas_vestibulares.vestibulando_id')
            ->where('fac_vestibulandos.id', $idVestibulando)
            ->select([
                'fac_vestibulandos_notas_vestibulares.id',
                'fac_materias.codigo',
                'fac_materias.nome',
                'fac_vestibulandos_notas_vestibulares.acertos',
                'fac_vestibulandos_notas_vestibulares.pontuacao'
            ]);

        #Editando a grid
        return Datatables::of($alunos)->addColumn('action', function ($aluno) {
            return '<a class="btn-floating" id="editarNotas" title="Editar notas do vestibulando"><i class="material-icons">edit</i></a>';
        })->make(true);
    }

    /**
     * Método Create
     *
     * Método responsável por carregar a view correspondente e alguns
     * dados necessários para seu carregamento.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        # recuperando a data atual
        $now  = new \DateTime('now');

        # recuperando os vestibulares
        $rows = \DB::table('fac_vestibulares')
            ->select('id')
            ->whereDate('data_inicial', '<=', $now->format('Y-m-d'))
            ->whereDate('data_final', '>=', $now->format('Y-m-d'))
            ->get();

        # Verificando se foi retornado linhas
        if(count($rows) == 0) {
            if(!Auth::user()->is('admin')) {
                abort(403);
            }
        }

        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('vestibulando.create', compact('loadFields'));
    }

    /**
     * Método store
     *
     * Método responsável de receber a requisição com os dados
     * para cadastro, onde acontece a validação dos dados, o encaminhamento
     * para o model responsável pela regra de negócio e o redirecionamento para
     * a página solicitante.
     *
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
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Método edit
     *
     * Método responsável por carregar a view correspondente e alguns
     * dados necessários para seu carregamento.
     *
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
            $documentos = $this->repository->dadosVestibulando($aluno->id);

            #retorno para view
            return view('vestibulando.edit', compact('aluno', 'loadFields', 'documentos'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Método update
     *
     * Método responsável de receber a requisição com os dados
     * para cadastro, onde acontece a validação dos dados, o encaminhamento
     * para o model responsável pela regra de negócio e o redirecionamento para
     * a página solicitante.
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            $vestibulando = $this->service->find($id);

            #retornando Id de pessoa
            $pessoaId = $vestibulando->pessoa_id;

            #retornando email de pessoa
            $pessoaEmail = $vestibulando->email;

            #validando se existe um cpf
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":cpf", $pessoaId);

            #validando se existe um email
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":email", $pessoaEmail);

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
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
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

    /**
     * Método edit
     *
     * Método responsável por recupearar dados necessários para seu solicitante.
     *
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
     * Método updateNota
     *
     * Método responsável de receber a requisição com os dados
     * para cadastro, onde acontece a validação dos dados, o encaminhamento
     * para o model responsável pela regra de negócio e o retorno dos dados
     * para página solicitante.
     *
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
     * Método getLoadFields
     *
     * Método responsável por carregar os registros dos models
     * vindos como parâmetros da requisição.
     *
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
     * Método editInclusao
     *
     * Método responsável por recupearar dados necessários para seu solicitante.
     *
     * @param $idVestibulando
     * @return mixed
     */
    public function editInclusao($idVestibulando)
    {
        try {
            # Recuperando o semestre vigente
            $semestreVigente = ParametroMatriculaFacade::getSemestreVigente();

            # Recuperando o vestibulando
            $vestibulando = $this->service->find($idVestibulando);
            $dadosRetorno = [];

            # Populando o array de retorno
            $dadosRetorno['curso_id'] = isset($vestibulando->aluno->id) ? $vestibulando->aluno->curriculos()->first()->curso->id : null;
            $dadosRetorno['turno_id'] = isset($vestibulando->aluno->turno->id) ? $vestibulando->aluno->turno->id : null;
            $dadosRetorno['nomeTurno'] = isset($vestibulando->aluno->turno->nome) ? $vestibulando->aluno->turno->nome : null;
            $dadosRetorno['semestre_id'] =  isset($vestibulando->aluno->id) ? $vestibulando->vestibular->semestre->id : $semestreVigente->id;
            //$dadosRetorno['periodo'] = isset($vestibulando->aluno) ? $vestibulando->aluno->semestres()->first()->pivot->periodo : null;
            $dadosRetorno['data_inclusao'] = isset($vestibulando->aluno->data_transferencia) ? $vestibulando->aluno->data_transferencia : null;
            $dadosRetorno['forma_admissao_id'] = isset($vestibulando->aluno->formaAdmissao->id) ? $vestibulando->aluno->formaAdmissao->id : null;

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dadosRetorno]);
        } catch (\Throwable $e) {dd($e->getMessage());
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * Método updateInclusao
     *
     * Método responsável de receber a requisição com os dados
     * para cadastro, onde acontece a validação dos dados, o encaminhamento
     * para o model responsável pela regra de negócio e o retorno dos dados
     * para página solicitante.
     *
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
            $mensagem = $this->service->updateInclusao($data, $id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => $mensagem]);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * Método search
     *
     * Método responsável por recuperar dados do model Pessoa
     * e retorna para o solicitante.
     *
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
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function deleteComprovante(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $comprovante = $request->get('comprovante');

            #Executando a ação
            $vestibulando = $this->service->find($id);

            # Verificando se existe comprovante para ser removido
            if(!$vestibulando->$comprovante) {
                throw new \Exception('Comprovante não exite');
            }

            # Removendo o comprovante
            $this->service->deleteFile($vestibulando, $comprovante);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param id $
     * @return mixed
     */
    public function gerarComprovanteInscricao($id)
    {
        try {
            $vestibulando = $this->service->find($id);

            return \PDF::loadView('gerarComprovanteInscricao', ['vestibulando' =>  $vestibulando])->stream();
        } catch (\Throwable $e) {

        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reportFilter(Request $request)
    {
        try {
            # Query de vestibulandos
            $vestibulandos = \DB::table('fac_vestibulandos')
                ->join('pessoas', 'pessoas.id', '=', 'fac_vestibulandos.pessoa_id')
                ->join('fac_vestibulares', 'fac_vestibulares.id', '=' , 'fac_vestibulandos.vestibular_id')
                ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_vestibulares.semestre_id')
                ->leftJoin('fac_vestibulandos_financeiros', 'fac_vestibulandos_financeiros.vestibulando_id', '=', 'fac_vestibulandos.id')
                ->leftJoin('fin_taxas', 'fin_taxas.id', '=', 'fac_vestibulandos_financeiros.taxa_id')
                ->leftJoin('fin_tipos_taxas', 'fin_tipos_taxas.id', '=', 'fin_taxas.tipo_taxa_id')
                ->leftJoin('fac_cursos as curso1', 'curso1.id', '=', 'fac_vestibulandos.primeira_opcao_curso_id')
                ->leftJoin('fac_cursos as curso2', 'curso2.id', '=', 'fac_vestibulandos.segunda_opcao_curso_id')
                ->leftJoin('fac_cursos as curso3', 'curso3.id', '=', 'fac_vestibulandos.terceira_opcao_curso_id')
                ->leftJoin('fac_turnos as turno1', 'turno1.id', '=', 'fac_vestibulandos.primeira_opcao_turno_id')
                ->leftJoin('fac_turnos as turno2', 'turno2.id', '=', 'fac_vestibulandos.segunda_opcao_turno_id')
                ->leftJoin('fac_turnos as turno3', 'turno3.id', '=', 'fac_vestibulandos.terceira_opcao_turno_id')
                ->leftJoin('fac_alunos', 'fac_alunos.vestibulando_id', '=', 'fac_vestibulandos.id')
                ->groupBy('fac_vestibulandos.id')
                ->select([
                    'fac_vestibulandos.id',
                    \DB::raw('FORMAT(fac_vestibulandos.media_enem, 2) as media_enem'),
                    \DB::raw('FORMAT(fac_vestibulandos.media_ficha, 2) as media_ficha'),
                    'pessoas.nome',
                    'pessoas.cpf',
                    'pessoas.celular',
                    \DB::raw('IF(fac_vestibulandos.inscricao,CONCAT(fac_vestibulares.codigo,fac_vestibulandos.inscricao), "Pendente") as inscricao'),
                    'curso1.nome as nomeCurso1',
                    'curso2.nome as nomeCurso2',
                    'curso3.nome as nomeCurso3',
                    'turno1.nome as nomeTurno1',
                    'turno2.nome as nomeTurno2',
                    'turno3.nome as nomeTurno3',
                    'fac_vestibulares.nome as vestibular',
                    'fac_vestibulares.id as idVestibular',
                    'fin_tipos_taxas.id as idTipoTaxa',
                    \DB::raw('IF(fac_vestibulandos_financeiros.pago, "Pago", "Não Pago") as financeiro'),
                    'fac_semestres.nome as nomeSemestre',
                    \DB::raw('IF(fac_alunos.id, "TRANSFERIDO", "NÃO TRANSFERIDO") as transferencia'),
                    \DB::raw('IF(fac_vestibulandos.enem, "ENEM", "FICHA 19") as formaAvaliacao')
                ]);

            // Filtranto por vestibular
            if ($request->has('vestibular')) {
                $vestibulandos->where('fac_vestibulares.id', '=', $request->get('vestibular'));
            }

            // Filtrando por pagos
            if ($request->has('pago')) {
                $vestibulandos->where('fac_vestibulandos_financeiros.pago', '=', $request->get('pago'));
                $vestibulandos->where('fin_tipos_taxas.id', '=', 1);
            }

            // Filtrando por forma de avaliação
            if ($request->has('formaAvaliacao')) {
                $vestibulandos->where('fac_vestibulandos.enem', '=', $request->get('formaAvaliacao'));
            }

            // Filtrando Por Curso
            if ($request->has('cursoSearch')) {
                # recuperando o valor da requisição
                $cursoSearch = $request->get('cursoSearch');
                $opcaoSearch = !empty($request->get('opcaoCurso')) ? $request->get('opcaoCurso')  : 4;

                # Escolha das opções de curso para filtro
                switch($opcaoSearch) {
                    case 1  : $vestibulandos->where('curso1.id', '=', $cursoSearch); break;
                    case 2  : $vestibulandos->where('curso2.id', '=', $cursoSearch); break;
                    case 3  : $vestibulandos->where('curso3.id', '=', $cursoSearch); break;
                    default : $vestibulandos->where(function ($where) use ($cursoSearch) {
                        $where->orWhere('curso1.id', '=', $cursoSearch)
                            ->orWhere('curso2.id', '=', $cursoSearch)
                            ->orWhere('curso3.id', '=', $cursoSearch);
                    });
                }
            }

            // Filtrando Global
            if ($request->has('globalSearch')) {
                # recuperando o valor da requisição
                $search = $request->get('globalSearch');

                #condição
                $vestibulandos->where(function ($where) use ($search) {
                    $where->orWhere('pessoas.nome', 'like', "%$search%")
                        ->orWhere('pessoas.cpf', 'like', "%$search%")
                        ->orWhere(\DB::raw('CONCAT(fac_vestibulares.codigo,fac_vestibulandos.inscricao)'), 'like', "%$search%");
                });
            }

            # Recuperando os dados
            $rows = $vestibulandos->get();

            # Verificando se houve registro
            if(count($rows) == 0) {
               throw new \Exception('Nenhum Vestibulando foi encontrado');
            }

            # Retorno
            return \PDF::loadView('reports.vestibulares.relatorio1', ['rows' => $rows])->stream();
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

    /**
     * return \PDF::loadView('reports.vestibulares.relatorio1', ['rows' => $vestibulandos])->stream();
     */
}
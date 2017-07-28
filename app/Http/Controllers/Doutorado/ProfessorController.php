<?php

namespace Seracademico\Http\Controllers\Doutorado;

use Illuminate\Http\Request;

use Seracademico\Entities\Instituicao;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Doutorado\ProfessorService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Doutorado\ProfessorValidator;
use Seracademico\Repositories\Doutorado\ProfessorRepository;
use Seracademico\Repositories\Doutorado\DisciplinaRepository;
use Illuminate\Http\Response;

class ProfessorController extends Controller
{
    /**
    * @var ProfessorService
    */
    private $service;

    /**
    * @var ProfessorValidator
    */
    private $validator;

    /**
    * @var ProfessorRespository
    */
    private $repository;

    /**
    * @var DisciplinaRepository
    */
    private $disciplinaRepository;

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
        'Titulacao',
        'Instituicao',
        'Religiao',
        'SimpleReport|byCrud,8'
    ];

    /**
    * @param ProfessorService $service
    * @param ProfessorValidator $validator
    * @param ProfessorRespository $repository
    */
    public function __construct(ProfessorService $service, 
                                ProfessorValidator $validator,
                                ProfessorRepository $repository,
                                DisciplinaRepository $disciplinaRepository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->repository =  $repository;
        $this->disciplinaRepository =  $disciplinaRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #retorno
        return view('doutorado.professor.index', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_professores')
            ->join('pessoas', 'fac_professores.pessoa_id', '=', 'pessoas.id')
            ->join('tipo_nivel_sistema', 'fac_professores.tipo_nivel_sistema_id', '=', 'tipo_nivel_sistema.id')
            ->where('tipo_nivel_sistema.id', '=' , 5)
            ->select([
                'fac_professores.id',
                'pessoas.nome',
                'pessoas.cpf'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a href="edit/'.$row->id.'" class="btn-floating" title="Editar Professor"><i class="material-icons">edit</i></a></li>
                        </ul>
                    </div>';
                    /*<li><a class="btn-floating" id="professor_documentos" title="Documentos"><i class="material-icons">print</i></a></li>*/
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
        return view('doutorado.professor.create', compact('loadFields'));
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
            #Recuperando a empresa
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('doutorado.professor.edit', compact('model', 'loadFields'));
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
     * @param $id
     * @return $this
     * @throws \Exception
     */
    public function getImg($id)
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
     * @param $id
     * @return Response
     */
    public function visualizarAnexo($id, $tipo)
    {
        try { 
            # Retorno
            return new Response(file_get_contents($this->service->getPathArquivo($id, "path_$tipo")), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'inline; filename="'.'anexo.jpeg'.'"'
            ]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createInstituicao(Request $request)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->all();
            
            # Salvando os dados
            Instituicao::create($dados);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
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

    /**
     * @return mixed
     */
    public function getProfessor()
    {
        try {
            $professores = $this->repository->getProfessores();

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['dados' => $professores, 'success' => true]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function getDisciplina($idProfessor)
    {
        try {
            $disciplinas = $this->disciplinaRepository->getDisciplinas($idProfessor);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['dados' => $disciplinas, 'success' => true]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

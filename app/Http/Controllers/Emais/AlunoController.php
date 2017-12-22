<?php

namespace Seracademico\Http\Controllers\Emais;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Repositories\Emais\ModalidadeRepository;
use Seracademico\Repositories\Graduacao\MateriaRepository;
use Seracademico\Services\Emais\AlunoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Emais\AlunoValidator;

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
     * @var ModalidadeRepository
     */
    private $repositoryModalidade;

    /**
    * @var array
    */
    private $loadFields = [
        'Emais\\Modalidade',
        'Sexo',
        'Estado'
    ];

    /**
     * AlunoController constructor.
     * @param AlunoService $service
     * @param AlunoValidator $validator
     * @param ModalidadeRepository $modalidadeRepository
     * @param MateriaRepository $materiaRepository
     */
    public function __construct(
        AlunoService $service,
        AlunoValidator $validator,
        ModalidadeRepository $modalidadeRepository,
        MateriaRepository $materiaRepository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->repositoryModalidade =  $modalidadeRepository;
        $this->materiaRepository =  $materiaRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('emais.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('pre_alunos')
            ->join('pessoas', 'pessoas.id', '=', 'pre_alunos.pessoa_id')
            ->select([
                'pre_alunos.id',
                'pessoas.nome',
              //  'pre_turnos.nome as turno',
                'pre_alunos.tel_celular',
                \DB::raw('DATE_FORMAT(pre_alunos.created_at, "%d/%m/%Y") as data_criacao'),
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Objeto vestibular
            $inscricao = $this->service->find($row->id);

            # Html principal
            $html =  '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar Inscrição"><i class="material-icons">edit</i></a></li>
                            <li><a class="btn-floating" title="Financeiro do Aluno" id="btnModalFinanceiro"><i class="material-icons">attach_money</i></a></li>
                        ';

            # Verificando a possibilida de deleção
            /*if(count($inscricao->inscritos) == 0 && count($inscricao->cursos) == 0) {
                $html .= '<li><a class="btn-floating indigo" href="delete/'.$row->id.'" title="Editar Inscrição"><i class="material-icons">delete</i></a></li>';
            }*/

            # Html Principal
            $html .= '</ul></div>';

            # Retorno
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
        $modalidades = $this->repositoryModalidade->all();
        $materias = $this->materiaRepository->all();

        #Retorno para view
        return view('emais.create', compact('loadFields', 'modalidades', 'materias'));
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
        } catch (\Throwable $e) {dd($e);
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
            //dd($model['modalidades'][0]);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);
            $modalidades = $this->repositoryModalidade->all();
            $materias = $this->materiaRepository->all();

            #retorno para view
            return view('emais.edit', compact('model', 'loadFields', 'modalidades', 'materias'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->delete($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (\Throwable $e) { dd($e);
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

}

<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\CurriculoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Graduacao\CurriculoValidator;

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
        'Curso|ativo,1'
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
        return view('graduacao.curriculo.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_curriculos')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->join('tipo_nivel_sistema', 'fac_curriculos.tipo_nivel_sistema_id', '=', 'tipo_nivel_sistema.id')
            ->where('tipo_nivel_sistema.id', 1)
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
                        <li><a class="grid-curricular btn-floating green" data-id="'.$row->id.'" href="#" title="Adicionar Disciplinas ao Currículo"><i class="material-icons">add_to_photos</i></a></li>
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
                    'fac_disciplinas.qtd_falta',
                    'fac_tipo_disciplinas.nome as tipo_disciplina',
                    'fac_tipo_avaliacoes.nome as tipo_avaliacao']
            )
            ->where('fac_curriculos.id', $id);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # variáveis de uso
            $html       = '';
            $curriculo  = $this->service->find($row->idCurriculo);
            $tumas      = $curriculo->turmas;
            $boolReturn = true;

            # percorre as turmas
            foreach ($tumas as $turma) {
                if(count($turma->disciplinas) > 0) {
                    $boolReturn = false;
                    break;
                }
            }

            # Verifica a se a condição é válida
            if($boolReturn) {
                $html .= '<a href="#" class="removerDisciplina btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i>Remover</a>';
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
        return view('graduacao.curriculo.create', compact('loadFields'));
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

            #Tratando as datas
           // $aluno = $this->service->getAlunoWithDateFormatPtBr($aluno);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('graduacao.curriculo.edit', compact('model', 'loadFields'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function adicionarDisciplinas(Request $request)
    {
        try {
            #Recuperando os valores da requisição e salvando no banco
            $this->service->adicionarDisciplinas($request->all());

            #retorno sucesso
            return response()->json(['sucess' => true, 'msg' => "Disciplinas adicionadas com sucesso!"]);
        } catch (\Throwable $e) {
            #retorno falido
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removerDisciplina(Request $request)
    {
        try {
            #Recuperando os valores da requisição e salvando no banco
            $this->service->removerDisciplina($request->all());

            #retorno sucesso
            return response()->json(['sucess' => true, 'msg' => "Disciplinas adicionadas com sucesso!"]);
        } catch (\Throwable $e) {
            #retorno falido
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
        }
    }
}

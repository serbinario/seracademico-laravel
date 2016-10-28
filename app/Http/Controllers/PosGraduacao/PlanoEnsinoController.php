<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

use Seracademico\Validators\Graduacao\PlanoEnsinoValidator;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\PlanoEnsinoService;

class PlanoEnsinoController extends Controller
{
    /**
    * @var PlanoEnsinoService
    */
    private $service;

    /**
    * @var PlanoEnsinoValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'PosGraduacao\\Disciplina|posGraduacao'
    ];

    /**
    * @param PlanoEnsinoService $service
    * @param PlanoEnsinoValidator $validator
    */
    public function __construct(PlanoEnsinoService $service, PlanoEnsinoValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('posGraduacao.planoEnsino.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_plano_ensino')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_plano_ensino.disciplina_id')
            ->where('fac_disciplinas.tipo_nivel_sistema_id', 2)
            ->select([
                'fac_plano_ensino.id',
                'fac_plano_ensino.vigencia',
                'fac_plano_ensino.nome',
                'fac_plano_ensino.carga_horaria',
                'fac_plano_ensino.ementa',
                'fac_plano_ensino.obj_gerais',
                'fac_plano_ensino.obj_especifico',
                'fac_plano_ensino.metodologia',
                'fac_plano_ensino.recurso_audivisual',
                'fac_plano_ensino.avaliacao',
                'fac_plano_ensino.bibliografia_basica',
                'fac_plano_ensino.competencia',
                'fac_plano_ensino.aula_pratica',
                'fac_disciplinas.nome as nomeDisciplina',
                \DB::raw('IF(fac_plano_ensino.ativo = 1,"SIM","NÃO") as ativo')
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating indigo" title="Planos de aula" id="modalPlanoAula"><i class="material-icons">assignment</i></a></li>
                            <li><a href="edit/'.$row->id.'" class="btn-floating"><i class="material-icons">edit</i></a></li>
                        </ul>
                     </div>        
                        ';

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

        #Retorno para view
        return view('posGraduacao.planoEnsino.create', compact('loadFields'));
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
            return view('posGraduacao.planoEnsino.edit', compact('model', 'loadFields'));
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
     * @return mixed
     */
    public function gridConteudoProgramatico($idPlanoEnsino)
    {
        #Criando a consulta
        $rows = \DB::table('fac_conteudos_programaticos')
            ->join('fac_plano_ensino', 'fac_plano_ensino.id', '=', 'fac_conteudos_programaticos.plano_ensino_id')
            ->where('fac_plano_ensino.id', $idPlanoEnsino)
            ->select(['fac_conteudos_programaticos.id','fac_conteudos_programaticos.nome']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = '<a id="btnRemoverConteudoEditar" class="btn-floating"><i class="material-icons">delete</i></a>';

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function storeConteudoProgramatico(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->storeConteudoProgramatico($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Cadastro realizado com sucesso']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteConteudoProgramatico($id)
    {
        try {
            #Executando a ação
            $this->service->deleteConteudoProgramatico($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Conteúdo removido com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function deleteAnexo(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $anexo = $request->get('anexo');

            #Executando a ação
            $planoEnsino = $this->service->find($id);

            # Verificando se existe comprovante para ser removido
            if(!$planoEnsino->$anexo) {
                throw new \Exception('Anexo não exite');
            }

            # Removendo o comprovante
            $this->service->deleteFile($planoEnsino, $anexo);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

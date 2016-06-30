<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\VestibularService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Graduacao\VestibularValidator;

class VestibularController extends Controller
{
    /**
    * @var VestibularService
    */
    private $service;

    /**
    * @var VestibularValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'Taxa',
        'Banco',
        'TipoVencimento',
        'Graduacao\\Semestre'
    ];

    /**
    * @param VestibularService $service
    * @param VestibularValidator $validator
    */
    public function __construct(VestibularService $service, VestibularValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('vestibular.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_vestibulares')
            ->select([
                'id',
                'nome',
                'codigo',
                'data_prova',
                'data_inicial',
                'data_final',
                \DB::raw('IF(ativo, "Ativo", "Desativado") as ativo'),
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Objeto vestibular
            $vestibular = $this->service->find($row->id);

            # Html principal
            $html =  '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>
                            <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar Vestibular"><i class="material-icons">edit</i></a></li>
                            <li><a class="btn-floating green" href="#" id="btnAdicionarCursos" title="Adicionar Cursos ao vestibular"><i class="material-icons">add_to_photos</i></a></li>
                        ';

            # Verificando a possibilida de deleção
            if(count($vestibular->vestibulandos) == 0 && count($vestibular->cursos) == 0) {
                $html .= '<li><a class="btn-floating indigo" href="delete/'.$row->id.'" title="Editar Vestibular"><i class="material-icons">delete</i></a></li>';
            }

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

        #Retorno para view
        return view('vestibular.create', compact('loadFields'));
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

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('vestibular.edit', compact('model', 'loadFields'));
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function relatorio1(Request $request)
    {
        #Criando a consulta
        $vestibulandos = \DB::table('fac_vestibulandos')
            ->join('pessoas', 'pessoas.id', '=', 'fac_vestibulandos.pessoa_id')
            ->join('fac_vestibulares', 'fac_vestibulares.id', '=' , 'fac_vestibulandos.vestibular_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_vestibulares.semestre_id')
            ->leftJoin('fac_vestibulandos_financeiros', 'fac_vestibulandos_financeiros.vestibulando_id', '=', 'fac_vestibulandos.id')
            ->leftJoin('taxas', 'taxas.id', '=', 'fac_vestibulandos_financeiros.taxa_id')
            ->leftJoin('tipos_taxas', 'tipos_taxas.id', '=', 'taxas.tipo_taxa_id')
            ->leftJoin('fac_cursos as curso1', 'curso1.id', '=', 'fac_vestibulandos.primeira_opcao_curso_id')
            ->leftJoin('fac_cursos as curso2', 'curso2.id', '=', 'fac_vestibulandos.segunda_opcao_curso_id')
            ->leftJoin('fac_cursos as curso3', 'curso3.id', '=', 'fac_vestibulandos.terceira_opcao_curso_id')
            ->leftJoin('fac_turnos as turno1', 'turno1.id', '=', 'fac_vestibulandos.primeira_opcao_turno_id')
            ->leftJoin('fac_turnos as turno2', 'turno2.id', '=', 'fac_vestibulandos.segunda_opcao_turno_id')
            ->leftJoin('fac_turnos as turno3', 'turno3.id', '=', 'fac_vestibulandos.terceira_opcao_turno_id')
            ->groupBy('fac_vestibulandos.id')
            ->select([
                'fac_vestibulandos.id',
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
                'tipos_taxas.id as idTipoTaxa',
                \DB::raw('IF(fac_vestibulandos_financeiros.pago, "Pago", "Não Pago") as financeiro')
            ])->get();


        return \PDF::loadView('reports.vestibulares.relatorio1', ['rows' => $vestibulandos])->stream();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function relatorio2(Request $request)
    {
        return \PDF::loadView('reports.vestibulares.relatorio2')->stream();
    }


    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function getByValidDate()
    {
        try {
            #Executando a ação
            $dados = $this->service->getByValidDate();

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'dados' => $dados]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

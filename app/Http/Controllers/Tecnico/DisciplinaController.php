<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Tecnico\DisciplinaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Tecnico\DisciplinaValidator;

class DisciplinaController extends Controller
{
    /**
    * @var DisciplinaService
    */
    private $service;

    /**
    * @var DisciplinaValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [
        'TipoDisciplina',
        'TipoAvaliacao'
    ];

    /**
    * @param DisciplinaService $service
    * @param DisciplinaValidator $validator
    */
    public function __construct(DisciplinaService $service, DisciplinaValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('tecnico.disciplina.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            //->leftjoin('fac_tipo_avaliacoes', 'fac_disciplinas.tipo_avaliacao_id', '=', 'fac_tipo_avaliacoes.id')
            ->where('fac_disciplinas.tipo_nivel_sistema_id', 4)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_tipo_disciplinas.nome as tipo_disciplina']
                //'fac_tipo_avaliacoes.nome as tipo_avaliacao']
            );

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Recuperando a disciplina
            $disciplina = $this->service->find($row->id);

            # Variáveis de uso
            $html       = '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                            <li><a class="btn-floating" href="edit/'.$row->id.'" title="Editar disciplina"><i class="material-icons">edit</i></a></li>';

            # Verificando se existe vinculo com o currículo e turma
            if(count($disciplina->curriculos) == 0 && count($disciplina->turmas) == 0) {
                $html .= '<li><a class="btn-floating" href="delete/'.$row->id.'" title="Excluir disciplina"><i class="material-icons">delete</i></a></li>                        
                            </ul>
                           </div>';
            }

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
        return view('tecnico.disciplina.create', compact('loadFields'));
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
        } catch (\Throwable $e) {print_r($e->getMessage());
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
            return view('tecnico.disciplina.edit', compact('model', 'loadFields'));
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
}

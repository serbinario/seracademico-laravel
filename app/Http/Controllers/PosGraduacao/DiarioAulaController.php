<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PosGraduacao\DiarioAulaService;
use Seracademico\Validators\PosGraduacao\DiarioAulaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;

class DiarioAulaController extends Controller
{

    /**
     * @var DiarioAulaService
     */
    private $service;

    /**
     * @var DiarioAulaValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Professor|getValues',
        'Sala'
    ];

    /**
     * TurmaDisciplinaController constructor.
     * @param DiarioAulaService $service
     * @param DiarioAulaValidator $validator
     */
    public function __construct(DiarioAulaService $service, DiarioAulaValidator $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function grid($idTurmaDisciplina)
    {
        #Criando a consulta
        $rows = \DB::table('fac_diarios_aulas')
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_diarios_aulas.turma_disciplina_id')
            ->join('fac_turmas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
            ->leftJoin('fac_professores', 'fac_professores.id', '=', 'fac_diarios_aulas.professor_id')
            ->leftJoin('pessoas', 'pessoas.id', '=', 'fac_professores.pessoa_id')
            ->where('fac_turmas_disciplinas.id',  $idTurmaDisciplina)
            ->select([
                'fac_diarios_aulas.id',
                'fac_diarios_aulas.numero_aula',
                'fac_diarios_aulas.data',
                'fac_diarios_aulas.carga_horaria',
                'fac_diarios_aulas.hora_inicial',
                'fac_diarios_aulas.hora_final',
                'fac_diarios_aulas.assunto_ministrado',
                'pessoas.nome'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<div class="fixed-action-btn horizontal">
                    <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                    <ul>
                        <li><a class="btn-floating indigo" id="btnEditDiarioAula" title="Editar Diário de Aula"><i class="material-icons">edit</i></a></li>
                        <li><a class="btn-floating indigo" id="btnDeleteDiarioAula" title="Remover Diário de Aula"><i class="material-icons">delete</i></a></li>
                    </ul>
                    </div>';
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function gridDisciplinas($idTurma)
    {
        #Criando a consulta
        $rows = \DB::table('fac_turmas_disciplinas')
            ->join('fac_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
            ->join('fac_curriculos', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->select([
                'fac_disciplinas.codigo',
                'fac_turmas_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.id as idDisciplina',
                'fac_curriculos.id as idCurriculo',
                'fac_turmas.periodo',
                'fac_turmas.id as idTurma',
                'fac_disciplinas.id as idDisciplina',
                'fac_turmas_disciplinas.plano_ensino_id'
            ])
            ->where('fac_turmas.id', '=', $idTurma);

        #Editando a grid
        return Datatables::of($rows)->make(true);
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
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            #incluindo disciplina as Disciplinas
            $this->service->store($request->all());

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        try {
            #Recuperando o calendario e declarando variáveis
            $model = $this->service->find($id);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'data' => $model]);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
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
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Edição realizada com sucesso!']);
        } catch (ValidatorException $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            #Executando a ação
            $this->service->delete($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Diário removido com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
    * @return mixed
    */
    public function gridConteudoProgramatico($idDiarioAula)
    {
        #Criando a consulta
        $rows = \DB::table('fac_conteudos_programaticos')
            ->join('fac_diarios_aulas_conteudos_programaticos', 'fac_diarios_aulas_conteudos_programaticos.conteudo_programatico_id', '=', 'fac_conteudos_programaticos.id')
            ->join('fac_diarios_aulas', 'fac_diarios_aulas.id', '=', 'fac_diarios_aulas_conteudos_programaticos.diario_aula_id')
            ->where('fac_diarios_aulas.id', $idDiarioAula)
            ->select(['fac_conteudos_programaticos.id','fac_conteudos_programaticos.nome']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = '<a id="btnRemoverConteudoProgramaticoDiarioAulaEditar" class="btn-floating"><i class="material-icons">delete</i></a>';

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function getConteudosProgramaticos(Request $request)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fac_conteudos_programaticos')
                ->whereIn('fac_conteudos_programaticos.id', $request->get('conteudos'))
                ->select(['fac_conteudos_programaticos.id','fac_conteudos_programaticos.nome'])->get();

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $rows]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $idDiarioAula
     * @return mixed
     */
    public function attachConteudo(Request $request, $idDiarioAula)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->get('conteudos');

            # Recuperando o benefício
            $diarioAula = $this->service->find($idDiarioAula);

            # Vinculando as taxas ao benefício
            $diarioAula->conteudos()->attach($dados);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Conteúdo adicionado com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $idDiarioAula
     * @return mixed
     */
    public function detachConteudo(Request $request, $idDiarioAula)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->get('conteudos');

            # Recuperando o benefício
            $diarioAula = $this->service->find($idDiarioAula);

            # Vinculando as taxas ao benefício
            $diarioAula->conteudos()->detach($dados);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Conteúdo removido com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\PosGraduacao\PlanoAulaService;
use Seracademico\Validators\PosGraduacao\PlanoAulaValidator;
use Yajra\Datatables\Datatables;

class PlanoAulaController extends Controller
{
    /**
     * @var PlanoAulaService
     */
    private $service;

    /**
     * @var PlanoAulaValidator
     */
    private $validator;

    /**
     * PlanoAulaController constructor.
     * @param PlanoAulaService $service
     * @param PlanoAulaValidator $validator
     */
    public function __construct(PlanoAulaService $service, PlanoAulaValidator $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function grid(Request $request, $idPlanoEnsino)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('fac_planos_aulas')
                ->join('fac_plano_ensino', 'fac_plano_ensino.id', '=', 'fac_planos_aulas.plano_ensino_id')
                ->leftJoin('fac_professores as prof1', 'prof1.id', '=', 'fac_planos_aulas.professor_1_id')
                ->leftJoin('pessoas as pes1', 'pes1.id', '=', 'prof1.pessoa_id')
                ->leftJoin('fac_professores as prof2', 'prof2.id', '=', 'fac_planos_aulas.professor_2_id')
                ->leftJoin('pessoas as pes2', 'pes2.id', '=', 'prof2.pessoa_id')
                ->leftJoin('fac_professores as prof3', 'prof3.id', '=', 'fac_planos_aulas.professor_3_id')
                ->leftJoin('pessoas as pes3', 'pes3.id', '=', 'prof3.pessoa_id')
                ->leftJoin('fac_professores as prof4', 'prof4.id', '=', 'fac_planos_aulas.professor_4_id')
                ->leftJoin('pessoas as pes4', 'pes4.id', '=', 'prof4.pessoa_id')
                ->leftJoin('fac_professores as prof5', 'prof5.id', '=', 'fac_planos_aulas.professor_5_id')
                ->leftJoin('pessoas as pes5', 'pes5.id', '=', 'prof5.pessoa_id')
                ->where('fac_plano_ensino.id', $idPlanoEnsino)
                ->select([
                    'fac_planos_aulas.id',
                    'fac_planos_aulas.data',
                    'fac_planos_aulas.hora_inicial',
                    'fac_planos_aulas.hora_final',
                    'fac_planos_aulas.numero_aula',
                    \DB::raw('IF(pes1.nome != "", pes1.nome, "") as nomeProf1'),
                    \DB::raw('IF(pes2.nome != "", pes2.nome, "") as nomeProf2'),
                    \DB::raw('IF(pes3.nome != "", pes3.nome, "") as nomeProf3'),
                    \DB::raw('IF(pes4.nome != "", pes4.nome, "") as nomeProf4'),
                    \DB::raw('IF(pes5.nome != "", pes5.nome, "") as nomeProf5')
                ]);

            #Editando a grid
            return Datatables::of($rows)
                ->addColumn('action', function ($row) {
                    return '<div class="fixed-action-btn horizontal">
                        <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                        <ul>                  
                            <li><a class="btn-floating indigo" title="Editar" id="btnEditPlanoAula"><i class="material-icons">edit</i></a></li>
                            <li><a class="btn-floating indigo" title="Editar" id="btnDestroyPlanoAula"><i class="material-icons">delete</i></a></li>                                             
                        </ul>
                        </div>';
                })->make(true);
        } catch (\Throwable $e) {
            return abort(500, $e->getMessage());
        }
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
           
            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso']);
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
            #Recuperando o aluno
            $planoAula = $this->service->find($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $planoAula]);
        } catch (\Throwable $e) {
            #Retorno para a view
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

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Edição realizada com sucesso']);
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
            #Recuperando o aluno
            $this->service->delete($id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Plano de Aula removido com sucesso!']);
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
     * @param Request $request
     * @return mixed
     */
    public function getConteudosIn(Request $request)
    {
        try {
            // Recuperando os ids dos conteúdos da requisição
            $dados = $request->get('conteudos');

            #Criando a consulta
            $rows = \DB::table('fac_conteudos_programaticos')
                ->whereIn('id', $dados)
                ->select(['id', 'nome'])->get();

            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $rows]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idPlanoAula
     * @return mixed
     */
    public function gridConteudos($idPlanoAula)
    {
        #Criando a consulta
        $rows = \DB::table('fac_conteudos_programaticos')
            ->join('fac_planos_aulas_conteudos_programaticos', 'fac_planos_aulas_conteudos_programaticos.conteudo_programatico_id', '=', 'fac_conteudos_programaticos.id')
            ->join('fac_planos_aulas', 'fac_planos_aulas.id', '=', 'fac_planos_aulas_conteudos_programaticos.plano_aula_id')
            ->where('fac_planos_aulas.id', $idPlanoAula)
            ->select(['fac_conteudos_programaticos.id','fac_conteudos_programaticos.nome']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = '<a id="btnDistroyPlanoAulaEditar" class="btn-floating"><i class="material-icons">delete</i></a>';

            # Retorno
            return $html;
        })->make(true);
    }


    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function attachConteudo(Request $request, $idPlanoAula)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->get('conteudos');

            # Recuperando o plano de aula
            $planoAula = $this->service->find($idPlanoAula);

            # Vinculando as taxas ao benefício
            $planoAula->conteudos()->attach($dados);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Conteúdo adicionado com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function detachConteudo(Request $request, $idPlanoAula)
    {
        try {
            # Recuperando os dados da requisição
            $dados = $request->get('conteudos');

            # Recuperando o plano de aula
            $planoAula = $this->service->find($idPlanoAula);

            # Vinculando as taxas ao benefício
            $planoAula->conteudos()->detach($dados);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Conteúdo removido com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
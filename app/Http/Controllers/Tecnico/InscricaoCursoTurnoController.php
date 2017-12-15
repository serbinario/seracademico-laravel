<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Tecnico\InscricaoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Tecnico\InscricaoValidator;

class InscricaoCursoTurnoController extends Controller
{
    /**
    * @var InscricaoService
    */
    private $service;

    /**
    * @var array
    */
    private $loadFields = [
    ];

    /**
    * @param InscricaoService $service
    */
    public function __construct(InscricaoService $service)
    {
        $this->service   =  $service;
    }


    /**
     * @return mixed
     */
    public function grid($idInscricaoCurso)
    {
        #Criando a consulta
        $rows = \DB::table('pos_inscricoes_cursos_turnos')
            ->join('fac_turnos', 'fac_turnos.id', '=', 'pos_inscricoes_cursos_turnos.turno_id')
            ->join('pos_inscricoes_cursos', 'pos_inscricoes_cursos.id', '=', 'pos_inscricoes_cursos_turnos.inscricao_curso_id')
            ->join('pos_incricoes', 'pos_incricoes.id', '=', 'pos_inscricoes_cursos.incricao_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'pos_inscricoes_cursos.curso_id')
            ->where('pos_inscricoes_cursos.id', $idInscricaoCurso)
            ->select([
                'pos_inscricoes_cursos_turnos.id',
                'fac_turnos.id as idTurno',
                'fac_turnos.nome',
                'fac_cursos.id as idCurso',
                'pos_inscricoes_cursos_turnos.quantidade',
                'pos_incricoes.id as idInscricao'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # html de retonto
            $html = "";

            #recuperando o vestibular
            $inscricao = $this->service->find($row->idInscricao);

            #regra de negócio
            if(count($inscricao->inscritos) == 0) {
                $html .= '<a class="btn-floating indigo" id="removerCursoTurno" title="remover Curso"><i class="material-icons">delete</i></a>';
            }

            #retorno
            return $html;
        })->make(true);
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
    public function delete(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->deleteCursoTurno($data);

            #retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Remoção realizada com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
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

            #Executando a ação
            $this->service->storeCursoTurno($data);

            #retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Cadastro realizado com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTurnosByCurso(Request $request)
    {
        try {
            $dados = \DB::table('fac_turnos')
                ->select(['fac_turnos.id', 'fac_turnos.nome'])
                ->join('pos_inscricoes_cursos_turnos', 'pos_inscricoes_cursos_turnos.turno_id', '=', 'fac_turnos.id')
                ->join('pos_inscricoes_cursos', 'pos_inscricoes_cursos.id', '=', 'pos_inscricoes_cursos_turnos.inscricao_curso_id')
                ->join('pos_incricoes', 'pos_incricoes.id', '=', 'pos_inscricoes_cursos.incricao_id')
                ->join('fac_cursos', 'fac_cursos.id', '=', 'pos_inscricoes_cursos.curso_id')
                ->groupBy('fac_turnos.id')
                ->where('fac_cursos.id', $request->get('idCurso'))
                ->where('pos_incricoes.id', $request->get('idInscricao'))->get();

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'data' => $dados]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

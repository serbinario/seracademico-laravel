<?php

namespace Seracademico\Http\Controllers\Doutorado;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Doutorado\TurmaService;
use Yajra\Datatables\Datatables;

class TurmaPlanoEnsinoController extends Controller
{
    /**
     * @var TurmaService
     */
    private $service;

    /**
     * TurmaPlanoEnsinoController constructor.
     * @param TurmaService $service
     */
    public function __construct(TurmaService $service)
    {
        $this->service = $service;
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
            ->join('fac_curriculo_disciplina',function ($join) {
                $join->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
                    ->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id');
            })
            ->leftJoin('fac_plano_ensino', 'fac_plano_ensino.id', '=', 'fac_turmas_disciplinas.plano_ensino_id')
            ->select([
                'fac_disciplinas.codigo',
                'fac_turmas_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.id as idDisciplina',
                'fac_curriculos.id as idCurriculo',
                'fac_turmas.periodo',
                'fac_turmas.id as idTurma',
                'fac_disciplinas.id as idDisciplina',
                'fac_disciplinas.carga_horaria',
                \DB::raw('IF(fac_plano_ensino.id, "SIM", "NÃO") as planoEnsino')
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
            # Recuperando os dados para retorno
            $loadFields = $this->service->load($request->get("models"), true);
            $objTurma   = $this->service->find($request->get('idTurma'));
            $objPivot   = $objTurma->disciplinas()->find($request->get('disciplinaId'))->pivot;

            # Armazenando no array
            $loadFields['turmaDisciplina'] = $objPivot;

            # Retorno
            return $loadFields;
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
    public function attachPlanoEnsino(Request $request) {
        try {
            # Recuperando os dados para retorno
            $objTurma   = $this->service->find($request->get('idTurma'));
            $objPivot   = $objTurma->disciplinas()->find($request->get('disciplinaId'))->pivot;

            // Vinculando o plano de ensino
            $objPivot->plano_ensino_id = $request->get('planoEnsinoId');
            $objPivot->save();

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Plano de ensino vinculado com sucesso']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}

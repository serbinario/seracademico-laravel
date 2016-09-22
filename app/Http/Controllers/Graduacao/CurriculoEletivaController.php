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

class CurriculoEletivaController extends Controller
{
    /**
    * @var CurriculoService
    */
    private $service;

    /**
     * CurriculoEletivaController constructor.
     * @param CurriculoService $service
     */
    public function __construct(CurriculoService $service)
    {
        $this->service   =  $service;
    }


    /**
     * @return mixed
     */
    public function grid($idCurriculo)
    {
        #Criando a consulta
        $rows = \DB::table('fac_disciplinas')
            ->join('fac_tipo_disciplinas', 'fac_tipo_disciplinas.id', '=', 'fac_disciplinas.tipo_disciplina_id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
            ->where('fac_tipo_disciplinas.id', 2)
            ->where('fac_curriculos.id', $idCurriculo)
            ->select([
                'fac_curriculo_disciplina.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param $idCurriculoDisciplinaEletiva
     * @return mixed
     */
    public function gridOpcoesEletivas($idCurriculoDisciplinaEletiva)
    {
        #Criando a consulta
        $rows = \DB::table('fac_curriculo_disciplina')
            ->join('fac_eletivas_semestres', 'fac_eletivas_semestres.turma_disciplina_id', '=', 'fac_curriculo_disciplina.id')
            ->join('fac_eletivas_disciplinas', 'fac_eletivas_disciplinas.eletiva_semestre_id', '=', 'fac_eletivas_semestres.id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_eletivas_disciplinas.disciplina_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_eletivas_semestres.semestre_id')
            ->select([
                    'fac_eletivas_semestres.id',
                    'fac_semestres.nome as semestre',
                    'fac_disciplinas.nome as disciplina'
                ])
            ->where('fac_curriculo_disciplina.id', $idCurriculoDisciplinaEletiva);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Retorno
            return '<a class="btn-floating indigo" href="deleteOpcaoEletiva/'.$row->id.'" title="Editar Currículo"><i class="material-icons">delete</i></a>';
        })->make(true);
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function storeOpcaoEletiva(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->storeOpcaoEletiva($data);

            #retorno sucesso
            return response()->json(['sucess' => true, 'msg' => "Opção cadastrada com sucesso!"]);
        } catch (\Throwable $e) {
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idOpcao
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOpcaoEletiva($idOpcao)
    {
        try {
            # Removendo a opcao de disciplina de opcao de eletiva
            $this->service->deleteOpcaoEletiva($idOpcao);

            #retorno sucesso
            return response()->json(['sucess' => true, 'msg' => "Opção removida com sucesso!"]);
        } catch (\Throwable $e) {
            return response()->json(['sucess' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return array
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
}

<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\VestibularService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\VestibularValidator;

class VestibularCursoTurnoController extends Controller
{
    /**
    * @var VestibularService
    */
    private $service;

    /**
    * @var array
    */
    private $loadFields = [
    ];

    /**
    * @param VestibularService $service
    */
    public function __construct(VestibularService $service)
    {
        $this->service   =  $service;
    }


    /**
     * @return mixed
     */
    public function grid($idVestibularCurso)
    {
        #Criando a consulta
        $rows = \DB::table('fac_vestibular_curso_turno')
            ->join('fac_turnos', 'fac_turnos.id', '=', 'fac_vestibular_curso_turno.turno_id')
            ->join('fac_vestibulares_cursos', 'fac_vestibulares_cursos.id', '=', 'fac_vestibular_curso_turno.vestibular_curso_id')
            ->join('fac_vestibulares', 'fac_vestibulares.id', '=', 'fac_vestibulares_cursos.vestibular_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_vestibulares_cursos.curso_id')
            ->where('fac_vestibulares_cursos.id', $idVestibularCurso)
            ->select([
                'fac_vestibular_curso_turno.id',
                'fac_turnos.id as idTurno',
                'fac_turnos.nome',
                'fac_cursos.id as idCurso',
                'fac_vestibular_curso_turno.descricao',
                'fac_vestibular_curso_turno.qtd_vagas',
                'fac_vestibulares.id as idVestibular'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # html de retonto
            $html = "";

            #recuperando o vestibular
            $vestibular = $this->service->find($row->idVestibular);

            #regra de negócio
            if(count($vestibular->vestibulandos) == 0) {
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
}

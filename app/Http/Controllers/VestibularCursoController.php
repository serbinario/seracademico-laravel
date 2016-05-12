<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\VestibularService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\VestibularValidator;

class VestibularCursoController extends Controller
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
    public function __construct(VestibularService $service, VestibularValidator $validator)
    {
        $this->service   =  $service;
    }


    /**
     * @return mixed
     */
    public function grid($idVestibular)
    {
        #Criando a consulta
        $rows = \DB::table('vestibulares_cursos')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'vestibulares_cursos.curso_id')
            ->join('vestibulares', 'vestibulares.id', '=', 'vestibulares_cursos.vestibular_id')
            ->where('vestibulares.id', $idVestibular)
            ->select([
                'vestibulares_cursos.id',
                'fac_cursos.nome',
                'fac_cursos.codigo',
                'fac_cursos.id as idCurso'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) use ($idVestibular) {
            # Html
            $html = '';

            #Recuperando o vestibular e o pivot de curso
            $objVestibular = $this->service->find($idVestibular);
            $pivotCurso    = $objVestibular->cursos()->find($row->idCurso)->pivot;

            # Regra para remoção do curso
            if(count($pivotCurso->materias) == 0 && count($pivotCurso->turnos) == 0) {
                $html .= '<a class="btn-floating indigo" id="removerCurso" title="remover Curso"><i class="material-icons">delete</i></a>';
            }

            #Retorno
            return $html;
        })->make(true);
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
            $this->service->deleteCurso($data);

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
            $this->service->storeCurso($data);

            #retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => 'Inclusão realizada com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

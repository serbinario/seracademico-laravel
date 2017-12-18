<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Tecnico\InscricaoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class InscricaoCursoController extends Controller
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
    public function grid($idInscricao)
    {
        #Criando a consulta
        $rows = \DB::table('pos_inscricoes_cursos')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'pos_inscricoes_cursos.curso_id')
            ->join('pos_incricoes', 'pos_incricoes.id', '=', 'pos_inscricoes_cursos.incricao_id')
            ->where('pos_incricoes.id', $idInscricao)
            ->select([
                'pos_inscricoes_cursos.id',
                'fac_cursos.nome',
                'fac_cursos.codigo',
                'fac_cursos.id as idCurso'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) use ($idInscricao) {
            # Html
            $html = '';

            #Recuperando o vestibular
            $objInscricao = $this->service->find($idInscricao);

            # pegando os turnos
            $turnos = \DB::table('pos_inscricoes_cursos_turnos')
                ->join('pos_inscricoes_cursos', 'pos_inscricoes_cursos.id', '=', 'pos_inscricoes_cursos_turnos.inscricao_curso_id')
                ->where('pos_inscricoes_cursos.curso_id', $row->idCurso)->get();

            # Regra para remoção do curso
            if(count($objInscricao->inscritos) == 0 && count($turnos) == 0) {
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

<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\TabelaPrecoCursoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class TabelaPrecoCursoController extends Controller
{
    /**
     * @var TabelaPrecoCursoService
     */
    private $service;
//
//    /**
//    * @var CursoValidator
//    */
//    private $validator;
//

    /**
     * @param TabelaPrecoCursoService $service
     */
    public function __construct(TabelaPrecoCursoService $service)
    {
        $this->service   =  $service;
    }

    /**
     * @return mixed
     */
    public function grid($idCurso)
    {
        #Criando a consulta
        $rows = \DB::table('fac_precos_cursos')
            ->join('fac_cursos', 'fac_precos_cursos.curso_id', '=', 'fac_cursos.id')
            ->join('fac_turnos', 'fac_precos_cursos.turno_id', '=', 'fac_turnos.id')
            ->join('fac_periodos', 'fac_precos_cursos.periodo_id', '=', 'fac_periodos.id')
            ->join('fac_tipos_precos_cursos', 'fac_precos_cursos.tipo_preco_curso_id', '=', 'fac_tipos_precos_cursos.id')
            ->where('fac_cursos.id', $idCurso)
            ->select([
                'fac_precos_cursos.id',
                \DB::raw('DATE_FORMAT(fac_precos_cursos.virgencia, "%d/%m/%Y") as virgencia'),
                'fac_periodos.nome as periodo',
                'fac_tipos_precos_cursos.nome as tipo'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html     = '<a title="Editar Curso" id="btnEditarTabelaPreco" class="btn-floating indigo"><i class="material-icons">edit</i></a>';
            $objPreco = $this->service->find($row->id);

            if(count($objPreco->precosDisciplaCurso) == 0) {
                $html .= '<a title="Remover Calendário" id="btnRemoverTabelaPreco" class="btn-floating red"><i class="material-icons">delete</i></a>';
            }

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
            return $this->service->load($request->get("models"));
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
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

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Cadastro realizado com sucesso"]);
       // } catch (ValidatorException $e) {
       //     return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
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
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($request->all(), $id);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Alteração realizada com sucesso"]);
            // } catch (ValidatorException $e) {
            //     return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($idPrecoCurso)
    {
        try {
            #Recuperando o calendario e declarando variáveis
            $model      = $this->service->find($idPrecoCurso);
            $precoCurso = [];

            # Preparando o array de retorno
            $precoCurso['virgencia']           = $model->virgencia;
            $precoCurso['curso_id']            = $model->curso_id;
            $precoCurso['periodo_id']          = $model->periodo_id;
            $precoCurso['tipo_preco_curso_id'] = $model->tipo_preco_curso_id;
            $precoCurso['turno_id']            = $model->turno_id;
            $precoCurso['preco_curso_id']      = $model->id;

            # Dados de retorno
            $dados      = compact('precoCurso');

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        try {
            #Executando a ação
            $this->service->delete($request->get('idPrecoCurso'));

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Remoção realizada com sucesso"]);
        } catch (\Throwable $e) { dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

}
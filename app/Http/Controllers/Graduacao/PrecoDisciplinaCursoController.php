<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Graduacao\PrecoDisciplinaCursoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class PrecoDisciplinaCursoController extends Controller
{
    /**
     * @var PrecoDisciplinaCursoService
     */
    private $service;
//
//    /**
//    * @var CursoValidator
//    */
//    private $validator;
//

    /**
     * @param PrecoDisciplinaCursoService $service
     */
    public function __construct(PrecoDisciplinaCursoService $service)
    {
        $this->service   =  $service;
    }

    /**
     * @return mixed
     */
    public function grid($idPrecoCurso)
    {
        #Criando a consulta
        $rows = \DB::table('fac_precos_discplina_curso')
            ->join('fac_precos_cursos', 'fac_precos_discplina_curso.preco_curso_id', '=', 'fac_precos_cursos.id')
            ->where('fac_precos_cursos.id', $idPrecoCurso)
            ->select([
                'fac_precos_discplina_curso.id',
                'fac_precos_discplina_curso.qtd_disciplinas',
                'fac_precos_discplina_curso.preco'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html  = '<a title="Editar Curso" id="btnEditarPrecoDisciplinaCurso" class="btn-floating indigo"><i class="material-icons">edit</i></a>';
            $html .= '<a title="Remover Calendário" id="btnPrecoDisciplinaCurso" class="btn-floating red"><i class="material-icons">delete</i></a>';

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
    public function edit($id)
    {
        try {
            #Recuperando o calendario e declarando variáveis
            $model           = $this->service->find($id);
            $precoDisciplina = [];

            # Preparando o array de retorno
            $precoCurso['preco']            = $model->preco;
            $precoCurso['qtd_disciplinas']  = $model->qtd_disciplinas;
            $precoCurso['idPrecoDisciplina']= $model->id;


            # Dados de retorno
            $dados = compact('precoCurso');

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
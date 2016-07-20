<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoService;
use Yajra\Datatables\Datatables;

class HistoricoAlunoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $alunoService;

    /**
     * @var array
     */
    private $loadFields = [
    ];

    /**
     * @param AlunoService $service
     */
    public function __construct(AlunoService $service)
    {
        $this->alunoService = $service;
    }

    /**
     * @return mixed
     */
    public function gridHistorico($idAluno)
    {
        #Criando a consulta
        $alunos = \DB::table('fac_alunos')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.aluno_id', '=', 'fac_alunos.id')
            ->leftJoin('fac_alunos_situacoes', function ($join) {
                $join->on(
                    'fac_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_secundaria.id FROM fac_alunos_situacoes as situacao_secundaria 
                    where situacao_secundaria.aluno_semestre_id = fac_alunos_semestres.id ORDER BY situacao_secundaria.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('fac_situacao', 'fac_situacao.id', '=', 'fac_alunos_situacoes.situacao_id')
            ->join('fac_alunos_cursos', function ($join) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_secundario.id FROM fac_alunos_cursos as curso_secundario 
                    where curso_secundario.aluno_id = fac_alunos.id ORDER BY curso_secundario.id DESC LIMIT 1)')
                );
            })
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_cursos.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_alunos.id',
                'pessoas.nome as nomeAluno',
                'fac_alunos.matricula',
                'fac_alunos_semestres.id as idAlunoSemestre',
                'fac_semestres.id as idSemestre',
                'fac_semestres.nome as nomeSemestre',
                'fac_cursos.codigo as codigoCurso',
                'fac_curriculos.codigo as codigoCurriculo',
                'fac_situacao.nome as nomeSituacao',
                'fac_alunos_semestres.periodo as periodo'
            ]);

        #Editando a grid
        return Datatables::of($alunos)->addColumn('action', function ($aluno) {
            # Html de retorno
            $html = '<a class="btn-floating" id="btnEditarPeriodo" title="Editar Histórico"><i class="material-icons">edit</i></a>';

            # recuperando o aluno
            $objAluno = $this->alunoService->find($aluno->id);

            # recuperando o semestre corrente
            $semestre = $objAluno->semestres()->get()->filter(function ($item) use ($aluno) {
                return $item->pivot->id == $aluno->idAlunoSemestre;
            })->first();

            # verificando se o histórico tem situações
            if(isset($semestre->id) && count($semestre->pivot->situacoes) == 0) {
                $html .= '<a class="btn-floating" id="btnDeleteHistorico" title="Remover Hitórico"><i class="material-icons">delete</i></a>';
            }

            #retorno
            return $html;
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function gridSituacao($idAlunoSemestre)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_situacoes')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_situacoes.aluno_semestre_id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->join('fac_situacao', 'fac_situacao.id', '=', 'fac_alunos_situacoes.situacao_id')
            ->leftJoin('fac_curriculos as curriculoOrigem', 'curriculoOrigem.id', '=', 'fac_alunos_situacoes.curriculo_origem_id')
            ->leftJoin('fac_curriculos as curriculoDestino', 'curriculoDestino.id', '=', 'fac_alunos_situacoes.curriculo_destino_id')
            ->leftJoin('fac_cursos as cursoOrigem', 'cursoOrigem.id', '=', 'curriculoOrigem.curso_id')
            ->leftJoin('fac_cursos as cursoDestino', 'cursoDestino.id', '=', 'curriculoDestino.curso_id')
            ->where('fac_alunos_semestres.id', $idAlunoSemestre)
            ->select([
                'fac_alunos_situacoes.id',
                'fac_situacao.nome as nomeSituacao',
                'cursoOrigem.codigo as codigoCursoOrigem',
                'cursoDestino.codigo as codigoCursoDestino',
                'fac_alunos_situacoes.observacao',
                \DB::raw("DATE_FORMAT(fac_alunos_situacoes.data, '%d/%m/%Y') as data")
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            //<a class="btn-floating" id="btnEditSituacao" title="Editar Histórico"><i class="material-icons">edit</i></a>
            return '<a class="btn-floating" id="btnDeleteSituacao" title="Remover Hitórico"><i class="material-icons">delete</i></a>';
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
            return $this->alunoService->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @param $idAluno
     * @return mixed
     */
    public function saveHistorico(Request $request, $idAluno)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $mensagem = $this->alunoService->saveHistorico($data, $idAluno);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Histórico cadastrado com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idAlunoSemestre
     * @return mixed
     */
    public function deleteHistorico($idAlunoSemestre)
    {
        try {
            #Executando a ação
            $this->alunoService->deleteHistorico($idAlunoSemestre);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Histórico cadastrado com sucesso!']);
        } catch (\Throwable $e) {dd($e);
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idAlunoSituacao
     * @return mixed
     */
    public function deleteSituacao($idAlunoSituacao)
    {
        try {
            #Executando a ação
            $this->alunoService->deleteSituacao($idAlunoSituacao);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Situação removida com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $idSemestre
     * @return mixed
     */
    public function saveSituacao(Request $request, $idSemestre)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $mensagem = $this->alunoService->saveSituacao($data, $idSemestre);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Situação cadastrada com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updatePeriodo(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->alunoService->updatePeriodo($data);

            #retorno para view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Período alterado com sucesso!']);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}
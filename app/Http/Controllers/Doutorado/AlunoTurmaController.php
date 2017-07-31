<?php

namespace Seracademico\Http\Controllers\Doutorado;

use Illuminate\Http\Request;

use Seracademico\Entities\Doutorado\AlunoTurma;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Doutorado\AlunoRepository;
use Seracademico\Services\Doutorado\AlunoTurmaService;
use Yajra\Datatables\Datatables;

class AlunoTurmaController extends Controller
{
    /**
     * @var AlunoTurmaService
     */
    private $service;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @param AlunoTurmaService $service
     */
    public function __construct(AlunoTurmaService $service, AlunoRepository $alunoRepository)
    {
        $this->service = $service;
        $this->alunoRepository = $alunoRepository;
    }

      /**
     * @return mixed
     */
    public function grid($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos_cursos')
            ->join('fac_curriculos', 'pos_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->leftJoin('pos_alunos_turmas', function ($join) {
                $join->on(
                    'pos_alunos_turmas.id', '=',
                    \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->leftJoin('pos_alunos_situacoes', function ($join) {
                $join->on(
                    'pos_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                        where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                );
            })
            ->leftJoin('fac_situacao', 'pos_alunos_situacoes.situacao_id', '=', 'fac_situacao.id')
            ->where('pos_alunos.id', $idAluno)
            ->orderBy('pos_alunos_cursos.id')
            ->groupBy('pos_alunos_turmas.id')
            ->select([
                'pos_alunos_turmas.id',
                'pos_alunos.id as idAluno',
                'pos_alunos_cursos.id as idAlunoCurso',
                'fac_turmas.codigo as codigo_turma',
                'fac_curriculos.codigo as codigo_curriculo',
                'fac_curriculos.nome as nome_curriculo',
                'fac_cursos.codigo as codigo_curso',
                'fac_cursos.nome as nome_curso',
                'fac_situacao.nome as situacao_aluno',
                \DB::raw('DATE_FORMAT(fac_turmas.aula_inicio, "%d/%m/%Y") as aula_inicio'),
            ]);

        #Editando a grid <a id="btnEditAlunoCurso" title="Editar" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
        #<a href="#" class="btn btn-xs btn-danger" title="Remover Curso/Turma"><i class="glyphicon glyphicon-remove"></i></a>
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Variável que armazenará o html
            $html = '';

            # Recuperando o objeto aluno
            $objAluno = $this->alunoRepository->find($row->idAluno);

            # Verificando se o curso possui situação
            if(count($objAluno->curriculos()->where('pos_alunos_cursos.id', $row->idAlunoCurso)->first()->pivot->situacoes()->get()) == 0) {
                $html = '<a id="btnRemoverCurso" class="btn btn-xs btn-danger" title="Remover Curso/Turma"><i class="glyphicon glyphicon-remove"></i></a>';
            }

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @param int $idAlunoCurso
     * @return mixed
     */
    public function gridSituacoes(int $idAlunoCurso)
    {
        #Criando a consulta
        $rows = \DB::table('pos_alunos_situacoes')
            ->join('pos_alunos_cursos', 'pos_alunos_cursos.id', '=', 'pos_alunos_situacoes.pos_aluno_curso_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_cursos.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->leftJoin('fac_turmas as origem', 'origem.id', '=', 'pos_alunos_situacoes.turma_origem_id')
            ->leftJoin('fac_turmas as destino', 'destino.id', '=', 'pos_alunos_situacoes.turma_destino_id')
            ->join('fac_situacao', 'pos_alunos_situacoes.situacao_id', '=', 'fac_situacao.id')
            ->where('pos_alunos_cursos.id', $idAlunoCurso)
            ->select([
                'pos_alunos_situacoes.id',
                'fac_curriculos.codigo as codigoCurriculo',
                'fac_cursos.codigo as codigoCurso',
                'origem.codigo as codigoOrigem',
                'destino.codigo as codigoDestino',
                'fac_situacao.nome as nomeSituacao'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            return '<a id="btnRemoverSituacao" class="btn btn-xs btn-danger" title="Remover Situação"><i class="glyphicon glyphicon-remove"></i></a>';
        })->make(true);
    }

    /**
     * @return mixed
     */
    public function getCursos()
    {
        try {
            return $this->service->getCursos();
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function getTurmas($idCurriculo)
    {
        try {
            return $this->service->getTurmas($idCurriculo);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function getTurmaOrigem($idAlunoCurso)
    {
        try {
            # Fazendo a consulta da turma
            $row = \DB::table('pos_alunos_turmas')
                    ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
                    ->join('pos_alunos_cursos', 'pos_alunos_cursos.id', '=', 'pos_alunos_turmas.pos_aluno_curso_id')
                    ->where('pos_alunos_cursos.id', $idAlunoCurso)
                    ->orderBy('pos_alunos_turmas.id', 'DESC')
                    ->take(1)
                    ->select([
                        'fac_turmas.id',
                        'fac_turmas.codigo as nome'
                    ])
                    ->get();

            # Retorno
            return $row;
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
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
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->store($data);

            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Cadastro realizado com sucesso"]);
        }  catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idAluno
     * @param $idAlunoCurso
     * @return mixed
     */
    public function destroy($idAluno, $idAlunoCurso)
    {
        try {
            # Recuperando o registro
            $curriculo = $this->alunoRepository->find($idAluno)->curriculos()
                ->where('pos_alunos_cursos.id', $idAlunoCurso)->first();

            # Removendo as dependências
            $curriculo->pivot->situacoes()->detach();

            # Iterando quanda turma para remover as notas
            foreach($curriculo->pivot->turmas()->get() as $turma) {
                $turma->pivot->notas()->delete();
            }
            
            # Removendoas dependências
            $curriculo->pivot->turmas()->detach();

            # removendo o curso
            \DB::table('pos_alunos_cursos')
                ->where('pos_alunos_cursos.id', $idAlunoCurso)
                ->delete();

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Curso removido com sucesso!"]);
        }  catch (\Throwable $e) {dd($e->getMessage());
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }

    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeSituacao(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $this->service->storeSituacao($data);

            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Cadastro realizado com sucesso"]);
        }  catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }


    /**
     * @param $idSituacao
     * @return mixed
     */
    public function destroySituacao($idSituacao)
    {
        try {
            # Recuperado o curso do aluno
           \DB::table('pos_alunos_situacoes')
                ->where('pos_alunos_situacoes.id', $idSituacao)
                ->delete();

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true,'msg' => "Situação removida com sucesso!"]);
        }  catch (\Throwable $e) {var_dump($e->getMessage());
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }

    }

//    /**
//     * @param $id
//     * @return mixed
//     */
//    public function edit($id)
//    {
//        try {
//            #Recuperando o aluno
//            $dados = $this->service->edit($id);
//
//            #retorno para view
//            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
//        } catch (\Throwable $e) {
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }
//
//    /**
//     * @param Request $request
//     * @param $id
//     * @return mixed
//     */
//    public function update(Request $request, $id)
//    {
//        try {
//            #Recuperando os dados da requisição
//            $dados = $request->all();
//
//            #Executando a ação
//            $this->service->update($dados, $id);
//
//            #retorno para view
//            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Dados atualizados com sucesso!']);
//        } catch (\Throwable $e) {
//            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
//        }
//    }
}

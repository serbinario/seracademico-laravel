<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PosGraduacao\AlunoService;

class AlunoDocumentoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;

    /**
     * AlunoDocumentoController constructor.
     * @param AlunoService $service
     */
    public function __construct(AlunoService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $tipoDoc
     * @param $idAluno
     * @return mixed
     */
    public function checkDocumento($tipoDoc, $idAluno)
    {
        try {
            # Escolhendo o tipo de documento
            switch ($tipoDoc) {
                case "1" :
                    $this->contrato($idAluno);
                    break;
                case "2" :
                    $this->certificadoConclusao($idAluno);
                    break;
                case "3" :
                    $this->certificadoConclusao($idAluno);
                    break;
            }

            # Retorno
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gerarDocumento($tipoDoc, $idAluno)
    {
        try {
            # Variáveis úteis
            $result   = [];
            $nameView = "";

            # Escolhendo o tipo de documento
            switch ($tipoDoc) {
                case "1" :
                    $result = $this->contrato($idAluno);
                    $nameView = "reports.contrato";
                    break;
                case "2" :
                    $result = $this->certificadoConclusao($idAluno);
                    $nameView = "reports.declaracaoVinculo";
                    break;
                case "3" :
                    $result = $this->certificadoConclusao($idAluno);
                    $nameView = "reports.certificadoConclusao";
                    break;
            }
               
            # Verificando foi vinculado a um curso e turma
            if(!$result['curso'] && !$result['turma']) {
                throw new \Exception("Este aluno não foi vinculado a um curso e turma!");
            }

            # Retorno do arquivo pdf
            return \PDF::loadView($nameView, $result)->stream();
        } catch (\Throwable $e) { dd($e);
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function contrato($id)
    {
        # Recuperando o aluno
        $aluno = $this->service->find($id);

        # Declaração e inicialização de variáveis úteis
        $data = new \DateTime('now');
        $curso = "";
        $turma = "";

        # Recuperando as informações no banco
        $curso = \DB::table('pos_alunos_cursos')
            ->join('fac_curriculos', 'pos_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id')
            ->where('pos_alunos_cursos.aluno_id', '=', $aluno->id)
            ->orderBy('pos_alunos_cursos.id', 'DESC')
            ->limit(1)
            ->select([
                'fac_curriculos.*',
                'pos_alunos_cursos.id as idCurso'
            ])->first();

        # Verificando o retorno da consulta
        if ($curso) {
            # Recuperando outras informações no banco de dados
            $turma = \DB::table('pos_alunos_turmas')
                ->join('fac_turmas', 'pos_alunos_turmas.turma_id', '=', 'fac_turmas.id')
                ->where('pos_alunos_turmas.pos_aluno_curso_id', '=', $curso->idCurso)
                ->orderBy('pos_alunos_turmas.id', 'DESC')
                ->limit(1)
                ->select([
                    'fac_turmas.*'
                ])->first();
        }

        # Verificando se a data do contrato está preenchida
        if(!$aluno->data_contrato) {
            $aluno->data_contrato = $data->format('Y-m-d');
            $aluno->save();
        }

        # Verificando se o aluno possui as informações necessárias
        if(!$turma->aula_inicio || !$turma->aula_final || !$turma->qtd_parcelas ||
            !$turma->duracao_meses || !$turma->valor_turma) {
            throw new \Exception("Para gerar o contrato é necessário ter
                        as seguintes informações em turmas: aula inicial, aula final, quantidade de parcelas, duração de mêses e valor da turma");
        }

        # Retorno
        return ['aluno' =>  $aluno, 'curso' => $curso, 'turma' => $turma];
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function declaracaoVinculo($id)
    {
        # Recuperando o registro do aluno
        $aluno = $this->service->find($id);

        # Declaração e inicialização de variáveis úteis
        $data = new \DateTime('now');
        $curso = "";
        $turma = "";

        # Recuperando as informações no banco
        $curso = \DB::table('pos_alunos_cursos')
            ->join('fac_curriculos', 'pos_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->where('pos_alunos_cursos.aluno_id', '=', $aluno->id)
            ->orderBy('pos_alunos_cursos.id', 'DESC')
            ->limit(1)
            ->select([
                'fac_curriculos.*',
                'fac_cursos.*',
                'pos_alunos_cursos.id as idCurso'
            ])->first();

        # Verificando o retorno da consulta
        if ($curso) {
            # Recuperando outras informações no banco de dados
            $turma = \DB::table('pos_alunos_turmas')
                ->join('fac_turmas', 'pos_alunos_turmas.turma_id', '=', 'fac_turmas.id')
                ->where('pos_alunos_turmas.pos_aluno_curso_id', '=', $curso->idCurso)
                ->orderBy('pos_alunos_turmas.id', 'DESC')
                ->limit(1)
                ->select([
                    'fac_turmas.*'
                ])->first();

        }

        # Verificando se a data do contrato está preenchida
        if(!$aluno->data_contrato) {
            $aluno->data_contrato = $data->format('Y-m-d');
            $aluno->save();
        }

        # Verificando se o aluno possui as informações necessárias
        if(!$turma->aula_inicio || !$turma->aula_final ) {
            throw new \Exception("Para gerar o contrato é necessário ter as seguintes
                     informações em turmas: aula inicial e aula final");
        }

        # Retorno
        return ['aluno' =>  $aluno, 'curso' => $curso, 'turma' => $turma];
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function certificadoConclusao($id)
    {
        # Recuperando o registro do aluno
        $aluno = $this->service->find($id);

        # Declaração e inicialização de variáveis úteis
        $data = new \DateTime('now');
        $curso = "";
        $turma = "";

        # Recuperando as informações no banco
        $curso = \DB::table('pos_alunos_cursos')
            ->join('fac_curriculos', 'pos_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->where('pos_alunos_cursos.aluno_id', '=', $aluno->id)
            ->orderBy('pos_alunos_cursos.id', 'DESC')
            ->limit(1)
            ->select([
                'fac_curriculos.*',
                'fac_cursos.*',
                'pos_alunos_cursos.id as idCurso'
            ])->first();

        # Verificando o retorno da consulta
        if ($curso) {
            # Recuperando outras informações no banco de dados
            $turma = \DB::table('pos_alunos_turmas')
                ->join('fac_turmas', 'pos_alunos_turmas.turma_id', '=', 'fac_turmas.id')
                ->where('pos_alunos_turmas.pos_aluno_curso_id', '=', $curso->idCurso)
                ->orderBy('pos_alunos_turmas.id', 'DESC')
                ->limit(1)
                ->select([
                    'fac_turmas.*'
                ])->first();

        }

        # Verificando se a data do contrato está preenchida
        if(!$aluno->data_contrato) {
            $aluno->data_contrato = $data->format('Y-m-d');
            $aluno->save();
        }

        # Verificando se o aluno possui as informações necessárias
        if(!$turma->aula_inicio || !$turma->aula_final ) {
            throw new \Exception("Para gerar o contrato é necessário ter as seguintes
                        informações em turmas: aula inicial e aula final");
        }

        # Retorno
        return ['aluno' =>  $aluno, 'curso' => $curso, 'turma' => $turma];
    }
}

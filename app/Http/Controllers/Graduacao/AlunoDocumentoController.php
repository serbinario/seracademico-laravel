<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoService;
use Seracademico\Services\Graduacao\Documento\DocumentoHelper;

class AlunoDocumentoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;

    /**
     * @var DocumentoHelper
     */
    private $documentoHelper;

    /**
     * AlunoDocumentoController constructor.
     * @param AlunoService $service
     * @param DocumentoHelper $documentoHelper
     */
    public function __construct(AlunoService $service, DocumentoHelper $documentoHelper)
    {
        $this->service = $service;
        $this->documentoHelper = $documentoHelper;
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
                case "26" :
                    $this->contrato($idAluno);
                    break;
                case "27" :
                    $this->declaracaoMatricula($idAluno);
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
        // Setando a localidade da aplicação
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        try {
            # Variáveis úteis
            $result = [];
            $nameView = "";

            # Escolhendo o tipo de documento
            switch ($tipoDoc) {
                case "26" :
                    $result = $this->contrato($idAluno);
                    $nameView = "reports.contrato_graduacao";
                    break;
                case "27" :
                    $result = $this->declaracaoMatricula($idAluno);
                    $nameView = "reports.graduacao.declaracao_matricula";
                    break;
            }

            # Verificando foi vinculado a um curso e turma
            if (!$result['curso'] && !$result['turma']) {
                throw new \Exception("Este aluno não foi vinculado a um curso e turma!");
            }

            # Retorno do arquivo pdf
            return \PDF::loadView($nameView, $result)->stream();
        } catch (\Throwable $e) {
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
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # Validação de dados necessários para geração desse documento
        /*if (!$result['turma']->aula_inicio || !$result['turma']->aula_final || !$result['turma']->qtd_parcelas ||
            !$result['turma']->duracao_meses || !$result['turma']->valor_turma) {
            throw new \Exception("Para gerar o contrato é necessário ter
                        as seguintes informações em turmas: aula inicial, aula final, quantidade de parcelas, duração de mêses e valor da turma");
        }*/

        # retorno dos dados
        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    public function declaracaoMatricula($id)
    {
        $result = $this->getDadosPadraoParaGerarDocumento($id);
        $aluno = $result['aluno'];
        $pivotSemestre = $aluno->semestres()->get()->last()->pivot;
        $result['semestre']['periodo'] = $pivotSemestre->periodo;
        $result['turno'] = $aluno->turno;

        return $result;
    }

    /**
     * @param $idAluno
     * @return array
     * @throws \Exception
     *
     * Método padrão para recuperar os dados necessários
     * para geração de documentos
     */
    private function getDadosPadraoParaGerarDocumento($idAluno)
    {
        # Recuperando o registro do aluno
        $aluno = $this->service->find($idAluno);

        # Declaração e inicialização de variáveis úteis
        $data = new \DateTime('now');
        $turma = null;

        # Recuperando as informações no banco
        $curso = $this->getCursoAtivoDoAluno($aluno->id);

        # Verificando o retorno da consulta
        if ($curso) {
            # Recuperando outras informações no banco de dados
            $turma = $this->getTurmaDoCurso($curso->idCurso);
        }

        # Verificando se a data do contrato está preenchida
        if (!$aluno->data_contrato) {
            $aluno->data_contrato = $data->format('Y-m-d');
            $aluno->save();
        }

        # Retorno
        return ['aluno' => $aluno, 'curso' => $curso, 'turma' => $turma];
    }

    /**
     * @param $idAluno
     * @return mixed
     *
     * Método retorna o corrículo ativo do aluno informado
     * por parêmetro através do id.
     */
    private function getCursoAtivoDoAluno($idAluno)
    {
        # Retorno o resultado da consulta
        return  \DB::table('pos_alunos_cursos')
            ->join('fac_curriculos', 'pos_alunos_cursos.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->where('pos_alunos_cursos.aluno_id', '=', $idAluno)
            ->orderBy('pos_alunos_cursos.id', 'DESC')
            ->limit(1)
            ->select([
                'fac_curriculos.*',
                'fac_cursos.*',
                'pos_alunos_cursos.id as idCurso'
            ])->first();
    }

    /**
     * @param $idCurso
     * @return mixed
     *
     * Método retorna a turma ativa do curso informado
     * por parêmetro através do id.
     */
    private function getTurmaDoCurso($idCurso)
    {
        #Retorna o resultado da consulta
        return \DB::table('pos_alunos_turmas')
            ->join('fac_turmas', 'pos_alunos_turmas.turma_id', '=', 'fac_turmas.id')
            ->where('pos_alunos_turmas.pos_aluno_curso_id', '=', $idCurso)
            ->orderBy('pos_alunos_turmas.id', 'DESC')
            ->limit(1)
            ->select([
                'fac_turmas.*'
            ])->first();
    }

    /**
     * @param $tipoDoc
     * @param $idAluno
     * @return mixed
     */
    /*public function checkDocumento($tipoDoc, $idAluno)
    {
        try {
            $this->documentoHelper->obtemDocumento($tipoDoc);

            # Retorno
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function gerarDocumento($tipoDoc, $idAluno)
    {
        # Setando a localidade da aplicação
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        try {
            $documento = $this->documentoHelper->obtemDocumento($tipoDoc);
            $resultado = $documento->processaDocumento($idAluno, []);

            # Retorno do arquivo pdf
            return \PDF::loadView($resultado['nomeDaView'], $resultado)->stream();
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }*/
}
<?php

namespace Seracademico\Http\Controllers\PosGraduacao;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Seracademico\Entities\PosGraduacao\Disciplina;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\PosGraduacao\CalendarioDisciplinaTurmaRepository;
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
                    $this->declaracaoVinculo($idAluno);
                    break;
                case "3" :
                    $this->certificadoConclusao($idAluno);
                    break;
                case "4" :
                    $this->contratoFasup($idAluno);
                    break;
                case "9" :
                    $this->inscricao($idAluno);
                    break;
                case "10":
                    $this->historico($idAluno);
                    break;
                case "12":
                    $this->declaracaoVinculoModelo($idAluno);
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
                case "1" :
                    $result = $this->contrato($idAluno);
                    $nameView = "reports.contrato";
                    break;
                case "2" :
                    $result = $this->declaracaoVinculo($idAluno);
                    $nameView = "reports.declaracaoVinculo";
                    break;
                case "3" :
                    $result = $this->certificadoConclusao($idAluno);
                    $nameView = "reports.certificadoConclusao";
                    break;
                case "4" :
                    $result = $this->contratoFasup($idAluno);
                    $nameView = "reports.contratoFasup";
                    break;
                case "9" :
                    $result = $this->inscricao($idAluno);
                    $nameView = "reports.inscricao_fasup";
                    break;
                case "12" :
                    $result = $this->declaracaoVinculoModelo($idAluno);
                    $nameView = "reports.declaracaoVinculoModelo";
                    break;
                case "10" :
                    $result = $this->historico($idAluno);
                    $nameView = "reports.historico_fasup";

                    # Recuperando o serviço de pdf / dompdf
                    $PDF = App::make('dompdf.wrapper');

                    # Carregando a página
                    $PDF->loadView($nameView, $result);

                    # Retornando para página
                    return $PDF->stream();
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
    public function contratoFasup($id)
    {
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # Verificando se o aluno possui as informações necessárias
        if (!$result['turma']->aula_inicio || !$result['turma']->aula_final || !$result['turma']->qtd_parcelas ||
            !$result['turma']->duracao_meses || !$result['turma']->valor_turma) {
            throw new \Exception("Para gerar o contrato é necessário ter
                        as seguintes informações em turmas: aula inicial, aula final,
                         quantidade de parcelas, duração de mêses e valor da turma");
        }

        # retorno dos dados
        return $result;
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
        if (!$result['turma']->aula_inicio || !$result['turma']->aula_final || !$result['turma']->qtd_parcelas ||
            !$result['turma']->duracao_meses || !$result['turma']->valor_turma) {
            throw new \Exception("Para gerar o contrato é necessário ter
                        as seguintes informações em turmas: aula inicial, aula final, quantidade de parcelas, duração de mêses e valor da turma");
        }

        # retorno dos dados
        return $result;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function declaracaoVinculo($id)
    {
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # Verificando se o aluno possui as informações necessárias
        if (!$result['turma']->aula_inicio || !$result['turma']->aula_final) {
            throw new \Exception("Para gerar o contrato é necessário ter as seguintes
                     informações em turmas: aula inicial e aula final");
        }

        # retorno dos dados
        return $result;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function declaracaoVinculoModelo($id)
    {
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # Verificando se o aluno possui as informações necessárias
        if (!$result['turma']->aula_inicio || !$result['turma']->aula_final) {
            throw new \Exception("Para gerar o contrato é necessário ter as seguintes
                     informações em turmas: aula inicial e aula final");
        }

        # retorno dos dados
        return $result;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function certificadoConclusao($id)
    {
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # Verificando se o aluno possui as informações necessárias
        if (!$result['turma']->aula_inicio || !$result['turma']->aula_final) {
            throw new \Exception("Para gerar o contrato é necessário ter as seguintes
                        informações em turmas: aula inicial e aula final");
        }

        # retorno dos dados
        return $result;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function inscricao($id)
    {
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # Verificando se o aluno possui as informações necessárias
        if (!$result['turma']->aula_inicio || !$result['turma']->aula_final) {
            throw new \Exception("Para gerar o contrato é necessário ter as seguintes
                     informações em turmas: aula inicial e aula final");
        }

        # retorno dos dados
        return $result;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function historico($id)
    {
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # Recuperando as notas do aluno
        $notasDoAluno = $result['aluno']->curriculos->last()
            ->pivot->turmas->last()
            ->pivot->notas()
            ->with('disciplina', 'turma')
            ->get();

        $arrayDeNotas = [];
        $count = 0;

        # Alterando a carga horária para a do currículo
        foreach($notasDoAluno->toArray() as $nota) {
            $carga_horaria_curriculo = $this->getCargaHorariaDoCurriculo(
                $nota['disciplina']['id'],
                $nota['turma']['curriculo_id']
            );

            $arrayDeNotas[$count]['disciplina']['nome'] = $nota['disciplina']['nome'];
            $arrayDeNotas[$count]['disciplina']['carga_horaria'] = $nota['disciplina']['carga_horaria'];
            $arrayDeNotas[$count]['disciplina']['carga_horaria_total'] = $carga_horaria_curriculo[0] ?? null;
            $arrayDeNotas[$count]['disciplina']['professor'] = $nota['frequencias'][0]['calendario']['professor']['pessoa']['nome'] ?? "";
            $arrayDeNotas[$count]['nota_final'] = $nota['nota_final'];

            $count++;
        }

        #Adicionando as notas ao array de resultado
        $result['notas'] = $arrayDeNotas;

        # Verificando se o aluno possui as informações necessárias
        if (!$result['turma']->aula_inicio || !$result['turma']->aula_final) {
            throw new \Exception("Para gerar o contrato é necessário ter as seguintes
                     informações em turmas: aula inicial e aula final");
        }

        # retorno dos dados
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
     * @param $idDisciplina
     * @param $idCurriculo
     * @return mixed
     */
    private function getCargaHorariaDoCurriculo($idDisciplina, $idCurriculo)
    {
        return \DB::table('fac_curriculo_disciplina')
            ->where('fac_curriculo_disciplina.disciplina_id', $idDisciplina)
            ->where('fac_curriculo_disciplina.curriculo_id', $idCurriculo)
            ->lists('carga_horaria_total');
    }
}
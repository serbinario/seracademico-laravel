<?php

namespace Seracademico\Http\Controllers\Report;

use Illuminate\Http\Request;

use Seracademico\Contracts\ReportAluno;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class ReportAlunoController extends Controller
{
    /**
     * @var Report
     */
    private $repot;

    /**
     * ReportController constructor.
     * @param ReportAluno $report
     */
    public function __construct(ReportAluno $report)
    {
        $this->report = $report;
    }

    /**
     * @return mixed
     */
    public function reportViewGeralAlunoCandidato()
    { 
        return view('posGraduacao.aluno.report.reportViewGeralAlunoCandidato');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gridReportGeralAlunoCandidato($tipo)
    {
        # Query principal da grid
        $query = $this->report->getBuilderGeral()
            ->select([
                'pessoas.nome',
                'pessoas.cpf',
                \DB::raw('IF(enderecos.bairros_id != NULL, CONCAT(enderecos.logradouro, ", ", enderecos.numero, bairros.nome, " - ", cidades.nome), "") as endereco'),
                'pessoas.celular',
                'pessoas.email'
            ]);

        # Verificando o tipo do gráfico
        if($tipo != 2) {
            switch ($tipo) {
                case 0 : $query->where('pos_alunos.matricula', '!=', ''); break;
                case 1 : $query->where('pos_alunos.matricula', ''); break;
            }
        }

        # Retorno
        return Datatables::of($query)->make(true);
    }

    /**
     * @return array
     */
    public function graphicBuilderGeral()
    {
        # Recuperando todos os registros
        $rows = $this->report->getBuilderGeral()
            ->select([
                'pos_alunos.id',
                'pos_alunos.matricula'
            ])
            ->get();

        # Filtrando os matriculados
        $matriculados = array_filter($rows, function ($row) {
            return $row->matricula != "";
        });

        # Filtrando os pretendentes
        $pretendentes = array_filter($rows, function ($row) {
            return $row->matricula == "";
        });

        # array de retorno
        $arrayResult = [
            'alunos' => count($matriculados),
            'pretendentes' => count($pretendentes),
            'total' => count($rows)
        ];

        # Retorno
        return $arrayResult;
    }
}

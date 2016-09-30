<?php

namespace Seracademico\Http\Controllers\Report\Simple;

use Illuminate\Http\Request;

use Seracademico\Contracts\Report;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;

class ReportController extends Controller
{

    /**
     * @var Report
     */
    private $report;

    /**
     * ReportController constructor.
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request, $idReport)
    {
        # Recuperando os dados de filtros
        $dados = $request->all();

        # Recuperando os dados do relatório
        $report = $this->report->generate($idReport, $dados);

        # Criando o relatório
        return \PDF::loadView('reports.report', ['dados' => $report])->stream();
    }
}

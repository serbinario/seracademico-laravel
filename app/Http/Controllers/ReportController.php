<?php

namespace Seracademico\Http\Controllers;

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
    public function report($idReport)
    {
        # Recuperando os dados do relatório
        $report = $this->report->generate($idReport);
        
        # Criando o relatório
        return \PDF::loadView('reports.report', ['dados' => $report])->stream();
    }
}

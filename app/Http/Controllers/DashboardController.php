<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Biblioteca\ArcevoRepository;
use Seracademico\Services\Biblioteca\ArcevoService;
use Seracademico\Services\Biblioteca\ExemplarService;

class DashboardController extends Controller
{
    /**
     * @var ArcevoService
     */
    private $serviceAcervo;

    /**
     * @var ExemplarService
     */
    private $serviceExemplar;

    public function __construct(ArcevoService $serviceAcervo, ExemplarService $serviceExemplar)
    {
        $this->serviceAcervo   =  $serviceAcervo;
        $this->serviceExemplar =  $serviceExemplar;
    }
    
    public function index()
    {
        return view('default.index');
    }

    public function dashboardBliblioteca()
    {
        $acervoNP = $this->serviceAcervo->countAcervoNPeriodico();
        $acervoP = $this->serviceAcervo->countAcervoPeriodico();
        
        $exemplarNP = $this->serviceExemplar->countExemplarNPeriodico();
        $exemplarP = $this->serviceExemplar->countExemplarPeriodico();

        return view('dashboards.biblioteca.dashboard', compact('acervoNP', 'acervoP', 'exemplarNP', 'exemplarP'));
    }
}

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
        $acervo = $this->serviceAcervo->countAcervo();
        $exemplar = $this->serviceExemplar->countExemplar();
        
        return view('dashboards.biblioteca.dashboard', ['acervo' => $acervo, 'exemplar' => $exemplar]);
    }
}

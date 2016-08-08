<?php

namespace Seracademico\Http\Controllers\Portal;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PortalService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use \Prettus\Validator\Contracts\ValidatorInterface;

class DisciplinasACursarController extends Controller
{
    /**
     * @var PortalService
     */
    private $service;
    
    /**
     * @var array
     */
    private $loadFields = [];

    /**
     * @param PortalService $service
     */
    public function __construct(PortalService $service)
    {
        $this->service   = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('sala.index');
    }
    
}

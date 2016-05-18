<?php

namespace Seracademico\Http\Controllers\Portal;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;

class PortalController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        return view('portal.inicio.login');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        return redirect()->route('seracademico.portal.dashboard');
    }

    /**
     * @return mixed
     */
    public function Dashboard()
    {
        return view('portal.inicio.dashboard');
    }

    /**
     * @return mixed
     */
    public function Academico()
    {
        return view('portal.inicio.academico');
    }

    /**
     * @return mixed
     */
    public function Financeiro()
    {
        return view('portal.inicio.financeiro');
    }

    /**
     * @return mixed
     */
    public function Secretaria()
    {
        return view('portal.inicio.secretaria');
    }
}

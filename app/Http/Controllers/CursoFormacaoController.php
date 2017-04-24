<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\CursoFormacaoService;

class CursoFormacaoController extends Controller
{
    /**
     * @var CursoFormacaoService
     */
    private $service;

    /**
     * @param CursoFormacaoService $service
     */
    public function __construct(CursoFormacaoService $service)
    {
        $this->service = $service;
    }

    /**
     * Metodo de controle de inserção de dados no select de pós-graduação
     */
    public function storeCursoFormacao(Request $request)
    {
        try {
            #
            $dados = $request->all();

            #Executando a ação
            $novoCursoFormacao = $this->service->inserirCursoFormacaoSelect($dados);

            #
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $novoCursoFormacao]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\CursoPosGraduacaoService;

class CursoPosGraduacaoController extends Controller
{
    /**
     * @var
     */
    private $service;

    /**
     * @param CursoPosGraduacaoService $service
     */
    public function __construct(CursoPosGraduacaoService $service)
    {
        $this->service = $service;
    }

    /**
     * Metodo de controle de inserção de dados no select de pós-graduação
     */
    public function storeCursoPosGraduacao(Request $request) {

        try {
            #
            $dados = $request->all();

            #Executando a ação
            $novoCursoPosGraduacao = $this->service->inserirCursoPosGraduacaoSelect($dados);

            #
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $novoCursoPosGraduacao]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

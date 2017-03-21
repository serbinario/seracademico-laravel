<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\PosGraduacao\InstituicaoService;

class InstituicaoController extends Controller
{

    /**
     * @var
     */
    private $service;

    /**
     * @param InstituicaoService $service
     */
    public function __construct(InstituicaoService $service)
    {
        $this->service = $service;

    }
    /**
     * Metodo de controle de inserção de dados no select de instituição
     */
    public function storeInstituicao(Request $request) {

        try {
            #
            $dados = $request->all();

            #Executando a ação
            $novaInstituicao = $this->service->inserirInstituicaoSelect($dados);

            #
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $dados]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

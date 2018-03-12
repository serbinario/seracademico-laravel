<?php

namespace Seracademico\Http\Controllers\Doutorado;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Mestrado\ProfessorService;

class ProfessorDocumentoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;

    /**
     * AlunoDocumentoController constructor.
     * @param ProfessorService $service
     */
    public function __construct(ProfessorService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $tipoDoc
     * @param $idProfessor
     * @return mixed
     */
    public function checkDocumento($tipoDoc, $idProfessor)
    {
        try {
            # Escolhendo o tipo de documento
            switch ($tipoDoc) {
                case "1" :
                    $this->declaracaoVinculo($idProfessor);
                    break;
            }

            # Retorno
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gerarDocumento($tipoDoc, $idProfessor)
    {
        // Setando a localidade da aplicação
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        try {
            # Variáveis úteis
            $result = [];
            $nameView = "";

            # Escolhendo o tipo de documento
            switch ($tipoDoc) {
                case "1" :
                    $result = $this->declaracaoVinculo($idProfessor);
                    $nameView = "reports.declaracao_vinculo_mestrado_professor";
                    break;
            }

            # Retorno do arquivo pdf
            return \PDF::loadView($nameView, $result)->stream();
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function declaracaoVinculo($id)
    {
        # Recuperando os dados padrões para esse documento
        $result = $this->getDadosPadraoParaGerarDocumento($id);

        # retorno dos dados
        return $result;
    }

    /**
     * @param $idProfessor
     * @return array
     * @throws \Exception
     *
     * Método padrão para recuperar os dados necessários
     * para geração de documentos
     */
    private function getDadosPadraoParaGerarDocumento($idProfessor)
    {
        # Recuperando o registro do aluno
        $professor = $this->service->find($idProfessor);

        # Retorno
        return ['professor' => $professor];
    }
}
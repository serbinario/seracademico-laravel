<?php

namespace Seracademico\Http\Controllers\Graduacao;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Graduacao\AlunoService;
use Seracademico\Services\Graduacao\Documento\DocumentoHelper;

class AlunoDocumentoController extends Controller
{
    /**
     * @var AlunoService
     */
    private $service;

    /**
     * @var DocumentoHelper
     */
    private $documentoHelper;

    /**
     * AlunoDocumentoController constructor.
     * @param AlunoService $service
     * @param DocumentoHelper $documentoHelper
     */
    public function __construct(AlunoService $service, DocumentoHelper $documentoHelper)
    {
        $this->service = $service;
        $this->documentoHelper = $documentoHelper;
    }

    /**
     * @param $tipoDoc
     * @param $idAluno
     * @return mixed
     */
    public function checkDocumento($tipoDoc, $idAluno)
    {
        try {
            $this->documentoHelper->obtemDocumento($tipoDoc);

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
    public function gerarDocumento($tipoDoc, $idAluno)
    {
        # Setando a localidade da aplicação
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        try {
            $documento = $this->documentoHelper->obtemDocumento($tipoDoc);
            $resultado = $documento->processaDocumento($idAluno, []);

            # Retorno do arquivo pdf
            return \PDF::loadView($resultado['nomeDaView'], $resultado)->stream();
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

}
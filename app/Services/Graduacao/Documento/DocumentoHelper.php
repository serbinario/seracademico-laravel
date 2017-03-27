<?php

namespace Seracademico\Services\Graduacao\Documento;

class DocumentoHelper
{
    private $listaDeDocumentos;

    public function __construct()
    {
        $this->listaDeDocumentos = [
            '12' => new Historico()
        ];
    }

    public function obtemDocumento($idDoDocumento)
    {
        $objetoDoDocumento = $this->listaDeDocumentos[$idDoDocumento];

        if(!$objetoDoDocumento) {
            throw new \Exception('Documento não encontrado');
        }

        return $objetoDoDocumento;
    }
}
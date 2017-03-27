<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 24/03/2017
 * Time: 08:10
 */

namespace Seracademico\Services\Graduacao\Documento;


interface DocumentoInterface
{
    public function processaDocumento(int $idDoAluno, array $paremetros);
}
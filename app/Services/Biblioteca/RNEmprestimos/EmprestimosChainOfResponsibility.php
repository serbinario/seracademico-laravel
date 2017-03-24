<?php
/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 08:33
 */

namespace Seracademico\Services\Biblioteca\RNEmprestimos;


class EmprestimosChainOfResponsibility
{

    /**
     * @param $dados
     * @param $data
     * @return bool
     */
    public static function processChain($dados, $data, &$return)
    {
        $firstOfChain = new EmprestimoEmAtraso();
        
        return $firstOfChain->getResult($dados, $data, $return);
    }
    
}
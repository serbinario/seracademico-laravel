<?php

namespace Seracademico\Services\Biblioteca\RNEmprestimos;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class EmprestimoEmAtraso
{

    private $next;

    /**
     * EmprestimoEmAtraso constructor.
     */
    public function __construct()
    {
        $this->next = new ExemplarEmEmprestimo();
    }

    /**
     * @param $dados
     * @param $data
     * @return bool
     */
    public function getResult($dados, $data, &$return)
    {
        //validando se a pessoa possui empréstimo em atraso
        $emprestimoAtraso = \DB::table('bib_emprestimos')->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->whereDate('bib_emprestimos.data_devolucao', '<', $data->format('Y-m-d'))
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->orWhere('bib_emprestimos.status_pagamento', '=', '1')
            ->select('bib_emprestimos.*')
            ->first();

        if (!$emprestimoAtraso) {
            return $this->next->getResult($dados, $data, $return);
        }

        $return[1] = "Esta pessoa possui um empréstimo em atraso";
        $return[2] = false;
        return $return;
    }
    
}
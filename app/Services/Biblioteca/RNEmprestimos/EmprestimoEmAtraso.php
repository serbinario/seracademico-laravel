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
        //dd($dados['pessoas_id']);

        //validando se a pessoa possui empréstimo em atraso
        $emprestimoAtrasoEntrega = \DB::table('bib_emprestimos')
            ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->whereDate('bib_emprestimos.data_devolucao', '<', $data->format('Y-m-d'))
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->select('bib_emprestimos.*')
            ->first();

        //validando se a pessoa possui empréstimo em atraso
        $emprestimoAtrasoPagamento = \DB::table('bib_emprestimos')
            ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_emprestimos.status_devolucao', '=', '1')
            ->where('bib_emprestimos.status_pagamento', '=', '0')
            ->select('bib_emprestimos.*')
            ->first();

        if (!$emprestimoAtrasoEntrega && !$emprestimoAtrasoPagamento) {
            return $this->next->getResult($dados, $data, $return);
        }

        $return[1] = "Esta pessoa possui um empréstimo em atraso ou faltando pagamento";
        $return[2] = false;
        return $return;
    }
    
}
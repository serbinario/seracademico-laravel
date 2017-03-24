<?php

namespace Seracademico\Services\Biblioteca\RNEmprestimos;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class ExemplarEmEmprestimo
{

    private $next;

    /**
     * QuantidadeDeEmprestimo constructor.
     */
    public function __construct()
    {
        $this->next = new QuantidadeDeEmprestimo();
    }

    public function getResult($dados, $data, &$return)
    {
        //validando se o exemplar selecionado já foi incluído para empréstimo antes
        $validarEmprestimo = \DB::table('bib_emprestimos')
            ->join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->where('bib_emprestimos_exemplares.exemplar_id', '=', $dados['id'])
            ->where('bib_emprestimos.status', '=', '0')
            ->select('bib_emprestimos_exemplares.*')
            ->get();

        if (!$validarEmprestimo) {
            return $this->next->getResult($dados, $data, $return);
        }

        $return[1] = 'Este exemplar já está sendo emprestado no momento';
        $return[2] = false;
        return $return;
    }
    
}
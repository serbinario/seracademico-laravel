<?php

namespace Seracademico\Services\Biblioteca\RNReservas;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class LivroJaEmEmprestimoPelaPessoa
{

    private $next;

    /**
     * EmprestimoEmAtraso constructor.
     */
    public function __construct()
    {
        $this->next = null;
    }

    /**
     * @param $dados
     * @param $data
     * @return bool
     */
    public function getResult($dados, $data, &$return)
    {
        //Verificando se a pessoa está tentando reservar um livro que o mesmo já tenha pego emprestado
        $acervoEmprestado = \DB::table('bib_emprestimos_exemplares')
            ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.id', '=', $dados['id_acervo'])
            ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_emprestimos.status', '=', '1')
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->select([
                'bib_arcevos.id'
            ])->first();

        if (!$acervoEmprestado) {
            return false;
        }

        $return[1] = "Este livro consta como emprestado para esta pessoa!";
        $return[2] = false;
        return $return;
    }
    
}
<?php

namespace Seracademico\Services\Biblioteca\RNEmprestimos;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class DuplicidadeDeExemplarNoEmprestimo
{

    private $next;

    /**
     * ExemplarEmReserva constructor.
     */
    public function __construct()
    {
        $this->next = new ExemplarEmReserva();
    }

    public function getResult($dados, $data, &$return)
    {

        //validando se a pessoa possui empréstimo em atraso
        $validarAcervo = \DB::table('bib_emprestimos')
            ->join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.id', '=', $dados['acervo_id'])
            ->where('bib_arcevos.titulo', '=', $dados['titulo'])
            ->where('bib_arcevos.cutter', '=', $dados['cutter'])
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->where('bib_emprestimos.pessoas_id', $dados['pessoas_id'])
            ->whereIn('bib_emprestimos.status', [0,1])
            ->select('bib_emprestimos_exemplares.id')
            ->first();

        if (!$validarAcervo) {
            return $this->next->getResult($dados, $data, $return);
        }

        $return[1] = "Este exemplar já foi incluído em um empréstimo ativo da pessoa!";
        $return[2] = false;
        return $return;
    }
    
}
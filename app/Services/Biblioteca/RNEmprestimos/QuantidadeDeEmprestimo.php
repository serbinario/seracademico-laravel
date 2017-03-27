<?php

namespace Seracademico\Services\Biblioteca\RNEmprestimos;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class QuantidadeDeEmprestimo
{

    private $next;

    /**
     * ExemplarEmEmprestimo constructor.
     */
    public function __construct()
    {
        $this->next = new DuplicidadeDeExemplarNoEmprestimo();
    }

    /**
     * @param $dados
     * @param $data
     * @param $return
     * @return bool
     */
    public function getResult($dados, $data, &$return)
    {
        # Pegas os parâmetros para saber a quantidade de exemplares por tipo de pessoa
        $qtdEmprestimos = \DB::table('bib_parametros')->select('bib_parametros.*')
            ->whereIn('bib_parametros.codigo',['003', '007', '009'] )->get();
        
        //Pega a quantidade de emprestimo da pessoa
        $validarQtdEmprestimo = \DB::table('bib_emprestimos')
            ->join('bib_emprestimos_exemplares', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_exemplares.situacao_id', '=', '5')
            ->groupBy('bib_emprestimos.pessoas_id')
            ->select([
                \DB::raw('count(bib_emprestimos_exemplares.emprestimo_id) as qtd'),
            ])
            ->first();

        if (!$validarQtdEmprestimo) {
            return $this->next->getResult($dados, $data, $return);
        }
        
        if ($validarQtdEmprestimo && $dados['tipo_pessoa'] == '1' && $validarQtdEmprestimo->qtd >= $qtdEmprestimos[0]->valor) { # Aluno Graduação
            $return[1] = "Limite de até {$qtdEmprestimos[0]->valor} empréstimos foi atingido";
        } else if ($validarQtdEmprestimo && ($dados['tipo_pessoa'] == '2' || $dados['tipo_pessoa'] == '3')
            && $validarQtdEmprestimo->qtd >= $qtdEmprestimos[2]->valor) {  # Aluno pós-graduação, mestrado, doutorado
            $return[1] = "Limite de até {$qtdEmprestimos[2]->valor} empréstimos foi atingido";
        } else if ($validarQtdEmprestimo && $dados['tipo_pessoa'] == '4' && $validarQtdEmprestimo->qtd >= $qtdEmprestimos[1]->valor) { # Professores
            $return[1] = "Limite de até {$qtdEmprestimos[1]->valor} empréstimos foi atingido";
        } else {
            return $this->next->getResult($dados, $data, $return);
        }
        

        $return[2] = false;
        return $return;
        
        
    }
    
}
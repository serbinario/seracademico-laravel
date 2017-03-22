<?php

namespace Seracademico\Services\Biblioteca\RNReservas;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class QuantidadeDeReserva
{

    private $next;

    /**
     * ExemplarEmEmprestimo constructor.
     */
    public function __construct()
    {
        $this->next = new LivroJaEmEmprestimoPelaPessoa();
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
        $qtdReservas = \DB::table('bib_parametros')->select('bib_parametros.*')
            ->whereIn('bib_parametros.codigo',['003', '007', '009'] )->get();
        
        //pega a quantidade de reservas
        $validarQtdReserva = \DB::table('bib_reservas')->join('bib_reservas_exemplares', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->where('bib_reservas.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->groupBy('bib_reservas.pessoas_id')
            ->select([
                \DB::raw('count(bib_reservas_exemplares.reserva_id) as qtd'),
            ])
            ->first();

        if (!$validarQtdReserva) {
            return $this->next->getResult($dados, $data, $return);
        }
        
        if ($validarQtdReserva && $dados['tipo_pessoa'] == '1' && $validarQtdReserva->qtd >= $qtdReservas[0]->valor) { # Aluno Graduação
            $return[1] = "Limite de até {$qtdReservas[0]->valor} reservas foi atingido";
        } else if ($validarQtdReserva && ($dados['tipo_pessoa'] == '2' || $dados['tipo_pessoa'] == '3')
            && $validarQtdReserva->qtd >= $qtdReservas[2]->valor) {  # Aluno pós-graduação, mestrado, doutorado
            $return[1] = "Limite de até {$qtdReservas[2]->valor} reservas foi atingido";
        } else if ($validarQtdReserva && $dados['tipo_pessoa'] == '4' && $validarQtdReserva->qtd >= $qtdReservas[1]->valor) { # Professores
            $return[1] = "Limite de até {$qtdReservas[1]->valor} reservas foi atingido";
        } else {
            return $this->next->getResult($dados, $data, $return);
        }
        
        $return[2] = false;
        return $return;
        
        
    }
    
}
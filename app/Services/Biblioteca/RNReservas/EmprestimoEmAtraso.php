<?php

namespace Seracademico\Services\Biblioteca\RNReservas;

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
        $this->next = new QuantidadeDeReserva();
    }

    /**
     * @param $dados
     * @param $data
     * @return bool
     */
    public function getResult($dados, $data, &$return)
    {
        //validando se a pessoa possui empréstimo em atraso
        $emprestimoAtraso = \DB::table('bib_emprestimos')->
        where('bib_emprestimos.pessoas_id', '=', $dados['pessoas_id'])
            ->where('bib_emprestimos.status_devolucao', '=', '0')
            ->select('bib_emprestimos.*')
            ->first();
            
        if (!$emprestimoAtraso) {
            return $this->next->getResult($dados, $data, $return);
        }

        $return[1] = "Esta pessoa possui empréstimo em atraso!";
        $return[2] = false;
        return $return;
    }
    
}
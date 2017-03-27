<?php

namespace Seracademico\Services\Biblioteca\RNEmprestimos;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class ExemplarEmReserva
{

    private $next;

    /**
     * ExemplarEmReserva constructor.
     */
    public function __construct()
    {
        $this->next = null;
    }
    
    public function getResult($dados, $data, &$return)
    {

        //validando se a pessoa possui empréstimo em atraso
        $validarReserva = \DB::table('bib_reservas_exemplares')
            ->join('bib_reservas', 'bib_reservas.id', '=', 'bib_reservas_exemplares.reserva_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_reservas_exemplares.arcevos_id')
            ->join('bib_exemplares', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_exemplares.id', '=', $dados['id'])
            ->where('bib_reservas_exemplares.status', '=', '0')
            ->where('bib_reservas.data_vencimento', '>', $data->format('Y-m-d H:i:s'))
            ->select([
                'bib_exemplares.id'
            ])->first();

        if (!$validarReserva) {
            return false;
        }

        $return[1] = "Não será possível o empréstimo desse livro, pois o mesmo está em reserva!";
        $return[2] = false;
        return $return;
    }
}
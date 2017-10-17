<?php
namespace Seracademico\Uteis;


class NumeroOrdianalPorExtenso
{
    private $numerosUnidade = [
        0 => '',
        1 => 'primeiro',
        2 => 'segundo',
        3 => 'terceiro',
        4 => 'quarto',
        5 => 'quinto',
        6 => 'sexto',
        7 => 'sétimo',
        8 => 'oitavo',
        9 => 'nono'
    ];

    private $numerosDezena = [
        1 => 'décimo',
        2 => 'vigésimo ',
        3 => 'trigésimo'
    ];

    private $meses = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    ];

    public function porExtenso(\DateTime $data)
    {
        # Recuperando os dados da data
        $dia = (int) $data->format('d');
        $mes = ((int) $data->format('m')) - 1;
        $ano = $data->format('Y');

        return "{$this->tratamentoDoDia($dia)} dia do mês de {$this->meses[$mes]} de {$ano} ";
    }

    private function tratamentoDoDia($dia)
    {
        # Recortando a string
        $arrayNumero = str_split($dia);

        if(count($arrayNumero) == 1) {
            return "{$this->numerosUnidade[$arrayNumero[0]]}";
        }

        # Retornando a string formatada
        return "{$this->numerosDezena[$arrayNumero[0]]} {$this->numerosUnidade[$arrayNumero[1]]}";
    }
}
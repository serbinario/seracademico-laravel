<?php

namespace Seracademico\Services\Biblioteca\RNEmprestimos;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class GerarDataDeDevolucaoDoEmprestimo
{


    /**
     * @param $dados
     * @param $data
     * @return bool
     */
    public static function getResult($dataObj, $dados)
    {
        # Pegas os parâmetros para saber a quantidade de dias para empréstimo por tipo de pessoa
        $qtdDias = \DB::table('bib_parametros')->select('bib_parametros.valor')
            ->whereIn('bib_parametros.codigo', ['001', '002', '006', '008'])->get();

        // Variáveis
        $tipoPessoa = isset($dados['tipo_pessoa']) ? $dados['tipo_pessoa'] : "";
        $dia        = 0;
        $emprestimoEspecial = $dados['emprestimo_especial'] ? $dados['emprestimo_especial'] : "0";

        //Pegando a quantidade de dia para definição da data de devolução
        if($dados['tipo_emprestimo'] == '1' && $emprestimoEspecial == '0') {
            if($tipoPessoa == '1') {
                $dia = $qtdDias[1]->valor;
            } else if ($tipoPessoa == '2' || $tipoPessoa == '3') {
                $dia = $qtdDias[3]->valor - 1;
            } else if ($tipoPessoa == '4') {
                $dia = $qtdDias[2]->valor;
            }
        } else if ($dados['tipo_emprestimo'] == '2' || $emprestimoEspecial == '1') {
            $dia = $qtdDias[0]->valor - 1;
        }

        // Determinando a data de devolução do empréstimo
        $dataObj->add(new \DateInterval("P{$dia}D"));
        $data       = $dataObj->format('d/m/Y'); // Data para gerar o dia da semana
        $dataReal   = $dataObj->format('Y-m-d'); // Data real no formato americano para inserir no banco

        $index = false;
        # Loop para validar se a(s) data(s) gerada(a) está para um dia letivo de funcionamento da biblioteca
        while ($index == false) {

            // Pegando o dia da semana
            $diaDaSemana = GerarDataDeDevolucaoDoEmprestimo::getDiaDaSemana($data);

            //valida se a data gerada está dentro dos dias letivos de funcionamento da biblioteca
            $validarDataPorDiaLetivo = \DB::table('bib_dias_letivos_emprestimo')
                ->where('nome', '=', $diaDaSemana)
                ->where('ativo', '=', '0')
                ->select('nome')->first();

            // Validando o retorno da consulta e se a data para empréstimo não será para ser entregue no mesmo dia
            if($validarDataPorDiaLetivo && $dados['tipo_emprestimo'] == '1' && $emprestimoEspecial == '0'
               && ($tipoPessoa == '1' || $tipoPessoa == '4')) {

                $dia = $dia + 1;
                #Gerando uma nova data para devolução
                $novaDataObj   = new \DateTime('now');
                $novaDataObj->add(new \DateInterval("P{$dia}D"));
                $data       = $novaDataObj->format('d/m/Y');
                $dataReal   = $novaDataObj->format('Y-m-d');

            } else {
                $index = true;
            }

        }

        return $dataReal;
    }

    /**
     * @param $data
     * @return string
     */
    public static function getDiaDaSemana($data)
    {
        $dia_semana = "";

        $dia = substr($data,0,2);

        $mes = substr($data,3,2);

        $ano = substr($data,6,4);

        // Recupera índice do dia da semana
        $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

        // Retorna o dia da semana por extenso
        switch($diasemana) {

            case"0": $dia_semana = "Domingo"; break;

            case"1": $dia_semana = "Segunda"; break;

            case"2": $dia_semana = "Terça"; break;

            case"3": $dia_semana = "Quarta"; break;

            case"4": $dia_semana = "Quinta"; break;

            case"5": $dia_semana = "Sexta"; break;

            case"6": $dia_semana = "Sábado"; break;

        }

        return $dia_semana;
    }
}
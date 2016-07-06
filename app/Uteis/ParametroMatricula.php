<?php
/**
 * Created by PhpStorm.
 * User: serbinario
 * Date: 05/07/16
 * Time: 10:15
 */

namespace Seracademico\Uteis;


class ParametroMatricula
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSemestreVigente()
    {
        return $this->getSemestre(2);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSemestreSelMatricula()
    {
        return $this->getSemestre(3);
    }

    /**
     * @return mixed
     * @throws \Exception
     *
     * Esse método retorna o semestre correspondente ao parametro selecionado
     */
    private static function getSemestre($idItemParametro)
    {
        # Recuperando o item de parâmetro do semestre vigente
        $queryParameter = \DB::table('fac_parametros')
            ->join('fac_parametros_itens', 'fac_parametros_itens.parametro_id', '=', 'fac_parametros.id')
            ->select(['fac_parametros_itens.valor', 'fac_parametros_itens.nome'])
            ->where('fac_parametros_itens.id', $idItemParametro)
            ->get();

        # Validando o parametro
        if(count($queryParameter) !== 1) {
            throw new \Exception('Parâmetro do semestre vigente não configurado');
        }

        # Recuperando o semestre
        $querySemestre = \DB::table('fac_semestres')
            ->select(['fac_semestres.id', 'fac_semestres.nome'])
            ->where('fac_semestres.nome', $queryParameter[0]->valor)
            ->where('fac_semestres.ativo', 1)
            ->get();

            # Validando o parametro
        if(count($querySemestre) !== 1) {
            throw new \Exception('Semestre não encontrado, verifique o parâmetro "Matrícula" em configurações.');
        }

        #Retorno
        return $querySemestre[0];
    }
}
<?php

namespace Seracademico\Services;

use Seracademico\Repositories\EventoRepository;
use Seracademico\Entities\Evento;

class EventoService
{
    /**
     * @var
     */
    private $repository;

    /**
     * @param EventoRepository $repository
     */
    public function __construct(EventoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return Evento
     * @throws \Exception
     */
    public function store(array $data) : Evento
    {
//        # Regras de negócios
//        $this->tratamentoCampos($data);

        #Salvando o registro pincipal
        $evento =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$evento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $evento;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Evento
     * @throws \Exception
     */
    public function update(array $data, int $id) : Evento
    {
//        # Regras de negócios
//        $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $evento = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$evento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $evento;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarDiaSemana($dados)
    {
        # Valida se o campo data existe
        if($dados['data'] && $dados['data'] != "") {

            $dia_semana = "";

            // Pega a data requisitada
            $dia = $dados['data'];
            $diaa = substr($dia,0,2);
            $mes = substr($dia,3,2);
            $ano = substr($dia,6,4);

            // Recupera o dia da semana
            $diasemana = date("w", mktime(0,0,0,$mes,$diaa,$ano) );

            switch($diasemana) {

                case"0": $dia_semana = "DOMINGO"; break;
                case"1": $dia_semana = "SEGUNDA"; break;
                case"2": $dia_semana = "TERÇA"; break;
                case"3": $dia_semana = "QUARTA"; break;
                case"4": $dia_semana = "QUINTA"; break;
                case"5": $dia_semana = "SEXTA"; break;
                case"6": $dia_semana = "SÁBADO"; break;
            }

            #retorno
            $retorno = $dia_semana;

            return $retorno;
        }

        #retorno
        $retorno = "";

        return $retorno;
    }
}
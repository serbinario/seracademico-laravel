<?php

namespace Seracademico\Http\Controllers\Report\Simple;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Seracademico\Contracts\Report;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Uteis\RelatorioCadernetaFrequencia;

class ReportController extends Controller
{

    /**
     * @var Report
     */
    private $report;

    /**
     * @var RelatorioCadernetaFrequencia
     */
    private $relatorioCadernetaFrequencia;

    /**
     * ReportController constructor.
     * @param Report $report
     */
    public function __construct(Report $report, RelatorioCadernetaFrequencia $relatorioCadernetaFrequencia)
    {
        $this->report = $report;
        $this->relatorioCadernetaFrequencia = $relatorioCadernetaFrequencia;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFunction($id)
    {
        try {
            # Recuperando a função de execução do relatório
            $row = \DB::table('reports')->select('function')->where('id', $id)->get();

            # Validando a consulta
            if(!count($row) == 1) {
                throw new \Exception('Nenhum regitro encontrado!');
            }

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $row[0]]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request, $idReport)
    {
        # Recuperando os dados de filtros
        $dadosDaRequisicao = $request->all();
        $dadosParaRelatorio = [];
        $view  = "";

        if($idReport == 22) {
            $dadosParaRelatorio = $this->relatorioCadernetaFrequencia->obtemDados($dadosDaRequisicao);
        } else {
            # Recuperando os dados do relatório
            $dadosParaRelatorio = $this->report->generate($idReport, $dadosDaRequisicao);
        }

        # Recuperando a view
        $view = $dadosParaRelatorio['view'] ?? 'report';

        # Recuperando o serviço de pdf / dompdf
        $PDF = App::make('dompdf.wrapper');
        //dd($dadosParaRelatorio);
        # Carregando a página
        $PDF->loadView("reports.simple.{$view}", ['dados' => $dadosParaRelatorio, 'request' => $dadosDaRequisicao]);

        # Retornando para página
        return $PDF->stream();
    }

    /**
     * @param Request $request
     * @return mixed
     *
     */
    public function getLoadFields(Request $request)
    {
        try {
            return $this->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Método load
     *
     * Método responsável por recuperar todos os models (com seus repectivos
     * métodos personalizados para consulta, se for o caso) do array passado
     * por parâmetro.
     *
     * @param array $models || Melhorar esse código
     * @return array
     */
    public function load(array $models, $ajax = false) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
                }
            }

            # Limpando a expressão
            $expressao = [];
        }

        #retorno
        return $result;
    }
}

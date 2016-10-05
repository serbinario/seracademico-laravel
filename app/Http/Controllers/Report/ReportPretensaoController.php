<?php

namespace Seracademico\Http\Controllers\Report;

use Seracademico\Contracts\ReportPretensao;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class ReportPretensaoController extends Controller
{
    /**
     * @var ReportPretensao
     */
    private $repot;

    /**
     * ReportPretensaoController constructor.
     * @param ReportPretensao $report
     */
    public function __construct(ReportPretensao $report)
    {
        $this->report = $report;
    }

    /**
     * @return mixed
     */
    public function reportViewPretensao()
    { 
        return view('posGraduacao.aluno.report.reportViewPretensao');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gridReportPretensao($tipo)
    {
        # Query principal da grid
        $query = $this->report->getBuilderGeral()
            ->select([
                'pessoas.nome',
                'pessoas.cpf',
                \DB::raw('IF(enderecos.bairros_id != NULL, CONCAT(enderecos.logradouro, ", ", enderecos.numero, bairros.nome, " - ", cidades.nome), "") as endereco'),
                'pessoas.celular',
                'pessoas.email'
            ]);

        # Verificando o tipo do gráfico
        if($tipo != 2) {
            switch ($tipo) {
                case 0 : $query->where('pos_tipos_pretensoes.codigo', 'CF'); break;
                case 1 : $query->where('pos_tipos_pretensoes.codigo', 'NI'); break;
            }
        }

        # Retorno
        return Datatables::of($query)->make(true);
    }

    /**
     * @return array
     */
    public function graphicBuilderGeral()
    {
        # Recuperando todos os registros
        $rows = $this->report->getBuilderGeral()
            ->where('pos_alunos.matricula', '')
            ->select([
                'pos_tipos_pretensoes.codigo'
            ])
            ->get();

        # Filtrando as captações futuras
        $capFutura = array_filter($rows, function ($row) {
            return $row->codigo == "CF";
        });

        # Filtrando os não interessados
        $naoInteresse = array_filter($rows, function ($row) {
            return $row->codigo == "NI";
        });

        # array de retorno
        $arrayResult = [
            'capFutura' => count($capFutura),
            'naoInteresse' => count($naoInteresse),
            'total' => count($rows)
        ];

        # Retorno
        return $arrayResult;
    }
}

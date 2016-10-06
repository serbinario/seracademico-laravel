<?php

namespace Seracademico\Http\Controllers\Report;

use Illuminate\Http\Request;
use Seracademico\Contracts\ReportPretensao;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;
use Seracademico\Repositories\PosGraduacao\TipoPretensaoRepository;
use Yajra\Datatables\Datatables;

class ReportPretensaoController extends Controller
{
    /**
     * @var ReportPretensao
     */
    private $report;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @var TipoPretensaoRepository
     */
    private $pretensaoRepository;

    /**
     * ReportPretensaoController constructor.
     * @param ReportPretensao $report
     * @param AlunoRepository $alunoRepository
     * @param TipoPretensaoRepository $pretensaoRepository
     */
    public function __construct(ReportPretensao $report,
                                AlunoRepository $alunoRepository,
                                TipoPretensaoRepository $pretensaoRepository)
    {
        $this->report = $report;
        $this->alunoRepository = $alunoRepository;
        $this->pretensaoRepository = $pretensaoRepository;
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
                'pos_alunos.id',
                'pessoas.nome',
                'pessoas.cpf',
                \DB::raw('IF(enderecos.bairros_id != NULL, CONCAT(enderecos.logradouro, ", ", enderecos.numero, bairros.nome, " - ", cidades.nome), "") as endereco'),
                'pessoas.celular',
                'pessoas.email',
                'pos_tipos_pretensoes.nome as pretensao',
                'pos_tipos_pretensoes.id as idPretensao'
            ]);

        # Verificando o tipo do gráfico
        if($tipo != 5) {
            switch ($tipo) {
                case 0 : $query->where('pos_tipos_pretensoes.codigo', 'CF'); break;
                case 1 : $query->where('pos_tipos_pretensoes.codigo', 'NI'); break;
                case 2 : $query->where('pos_tipos_pretensoes.codigo', 'AAT'); break;
                case 3 : $query->where('pos_tipos_pretensoes.codigo', 'EE'); break;
                case 4 : $query->where('pos_tipos_pretensoes.codigo', 'EA'); break;
            }
        }

        # Retorno
        return Datatables::of($query) ->addColumn('action', function () {
            return '<a class="btn-floating" id="btnEditPretensao" title="Editar pretensão"><i class="material-icons">edit</i></a>';
        })->make(true);
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

        # Filtrando as aguardando abertura de turma
        $abTurma = array_filter($rows, function ($row) {
            return $row->codigo == "AAT";
        });

        # Filtrando as de email enviado
        $eEnviado = array_filter($rows, function ($row) {
            return $row->codigo == "EE";
        });

        # Filtrando as de email enviado
        $emAndamento = array_filter($rows, function ($row) {
            return $row->codigo == "EA";
        });

        # array de retorno
        $arrayResult = [
            'abTurma' => count($abTurma),
            'eEnviado' => count($eEnviado),
            'capFutura' => count($capFutura),
            'naoInteresse' => count($naoInteresse),
            'emAndamento' => count($emAndamento),
            'total' => count($rows)
        ];

        # Retorno
        return $arrayResult;
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function editPretensao($idAluno)
    {
        try {
            # Recuperando os registros a ser utilizados
            $aluno = $this->alunoRepository->find($idAluno);
            
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $aluno->tipoPretensao]);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public function updatePretensao(Request $request, $idAluno)
    {
        try {
            # Dados da requisição
            $dados = $request->all();

            # Recuperando os registros a ser utilizados
            $aluno = $this->alunoRepository->find($idAluno);

            # Alterando a prentesão do aluno
            $aluno->tipo_pretensao_id = $dados['tipo_pretensao_id'];
            $aluno->save();

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Pretensão editada com sucesso!']);
        } catch (\Throwable $e) {
            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => false,'msg' => $e->getMessage()]);
        }
    }
}

<?php
namespace Seracademico\Http\Controllers\Graduacao;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Entities\Graduacao\Disciplina;
use Seracademico\Facades\ParametroBancoFacade;
use Seracademico\Facades\ParametroMatriculaFacade;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Financeiro\DebitoRepository;
use Seracademico\Repositories\Financeiro\TaxaRepository;
use Seracademico\Repositories\Graduacao\AlunoRepository;
use Seracademico\Services\Financeiro\DebitoService;
use Yajra\Datatables\Datatables;

class AlunoFinanceiroController extends Controller
{
    /**
     * @var DebitoRepository
     */
    private $debitoRepository;

    /**
     * @var DebitoService
     */
    private $debitoService;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @var TaxaRepository
     */
    private $taxaRepository;


    /**
     * AlunoFinanceiroController constructor.
     * @param DebitoRepository $debitoRepository
     * @param DebitoService $debitoService
     * @param AlunoRepository $alunoRepository
     * @param TaxaRepository $taxaRepository
     */
    public function __construct(
        DebitoRepository $debitoRepository,
        DebitoService $debitoService,
        AlunoRepository $alunoRepository,
        TaxaRepository $taxaRepository)
    {
        $this->debitoRepository = $debitoRepository;
        $this->debitoService = $debitoService;
        $this->alunoRepository = $alunoRepository;
        $this->taxaRepository = $taxaRepository;
    }


    /**
     * @param Request $request
     * @return mixed
     *
     */
    public function getLoadFields(Request $request)
    {
        try {
            return $this->debitoService->load($request->get("models"), true);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function gridDebitos(Request $request, $id)
    {
        try {
            $consulta = $this->debitoRepository
                ->obtemConsultaDebitosPorDebitante($id,Aluno::class)
                ->leftJoin('fin_carnes', 'fin_debitos.carne_id', '=', 'fin_carnes.id')
                ->leftJoin('fin_boletos', 'fin_debitos.id', '=', 'fin_boletos.debito_id')
                ->leftJoin('fin_status_gnet', 'fin_boletos.gnet_status_id', '=', 'fin_status_gnet.id')
                ->addSelect(\DB::raw("IF(fin_status_gnet.nome!='', fin_status_gnet.nome, 'Não gerado') as situacaoBoleto"))
                ->addSelect('fin_carnes.gnet_carnet_id');

            return DataTables::of($consulta)
                ->addColumn('action', function () {
                    $html = "";
                    $html .= '<div class="fixed-action-btn horizontal">';
                    $html .=    '<a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>';
                    $html .=    '<ul>';
                    $html .= '       <li><a class="btn-floating" id="btnEditarDebito" title="Editar aluno"><i class="material-icons">edit</i></a></li>';
                    $html .= '       <li><a class="btn-floating" id="btnGerarBoleto" title="Gerar boleto"><i class="material-icons">account_balance_wallet</i></a></li>';
                    $html .= '       <li><a class="btn-floating" id="btnInfoDebito" title="Visualizar informações do débito"><i class="material-icons">search</i></a></li>';
                    $html .= '  </ul>';
                    $html .= '</div>';
                    return $html;
                })->make(true);
        } catch (\Throwable $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function gridCarnes(Request $request, $id)
    {
        try {
            $consulta = $this->debitoRepository
                ->obtemConsultaDebitosPorDebitante($id,Aluno::class)
                ->join('fin_carnes', 'fin_debitos.carne_id', '=', 'fin_carnes.id')
                ->addSelect(\DB::raw('count(fin_debitos.id) as qtd_parcelas'))
                ->addSelect('fin_carnes.gnet_carnet_id')
                ->addSelect('fin_carnes.gnet_link')
                ->addSelect(\DB::raw("DATE_FORMAT(fin_carnes.created_at, '%d/%m/%Y') as data_criacao"))
                ->groupBy('fin_carnes.id', 'fin_taxas.id');

            return DataTables::of($consulta)
                ->addColumn('link', function ($row) {
                    return '<a target="_blank" href="'. $row->gnet_link .'">Visualizar carnê em outra página</a>';
                })->make(true);
        } catch (\Throwable $e) {
            abort(500, $e->getMessage());
        }
    }


    /**
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDebito($idDebito)
    {
        try {
            $debito = $this->debitoService->find($idDebito);

            return response()->json(['success' => true, 'data' => $debito]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDebito(Request $request, $id)
    {
        try {
            $aluno = $this->alunoRepository->find($id);
            $debito = $this->debitoService->store($aluno, $request->all());
            $message = 'Débito cadastrado com sucesso';

            $this->updateSituacaoPeloDebito($debito, $aluno);

            return response()->json(['success' => true, 'msg' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }


    /**
     * @param Request $request
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDebito(Request $request, $idDebito)
    {
        try {
            $debito = $this->debitoService->update($request->all(), $idDebito);
            $message = "Débito atualizado com sucesso";

            $this->updateSituacaoPeloDebito($debito, $debito->debitante);

            return response()->json(['success' => true, 'msg' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $aluno
     */
    private function updateSituacaoPeloDebito($debito, $aluno)
    {
        if ($debito->taxa->tipo_taxa_id == 2 && $debito->pago) {
            $aluno->semestres()->get()
                ->last()->pivot->situacoes()
                ->attach(2, ['data'=> new \DateTime('now')]);
        }
    }


    /**
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function gerarBoleto($idDebito)
    {
        try {
            $boleto = $this->debitoService->gerarBoleto($idDebito);

            return response()->json(['success' => true, 'boleto' => $boleto]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param $idDebito
     * @return \Illuminate\Http\JsonResponse
     */
    public function infoDebito($idDebito)
    {
        try {
            $debito = $this->debitoService->find($idDebito);

            return response()->json(['success' => true, 'debito' => $debito]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param $idAluno
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMensalidade(Request $request, $idAluno)
    {
        try {
            $taxa = $this->taxaRepository->find($request->get('idTaxa'));

            if ($taxa->tipoTaxa->nome !== 'Mensalidade') {
                throw new \Exception('Taxa infornada não é uma mensalidade');
            }

            $retorno = ['valor'  => 0, 'taxa' => $taxa];
            $semestreAtivo =  ParametroMatriculaFacade::getSemestreVigente();
            $aluno = $this->alunoRepository->find($idAluno);
            $cursoAtivo = $aluno->curriculos()->get()->last()->curso;
            $precoAtivo = $cursoAtivo->precosCursos()->get()
                ->filter(function ($preco) use ($semestreAtivo, $aluno) {
                    return $preco->turno_id == $aluno->turno_id
                        && $preco->semestre_id == $semestreAtivo->id;
            })->first();

            $disciplinas = \DB::table('fac_alunos')
                ->join('fac_alunos_semestres', 'fac_alunos_semestres.aluno_id', '=', 'fac_alunos.id')
                ->join('fac_alunos_semestres_horarios', 'fac_alunos_semestres_horarios.aluno_semestre_id', '=', 'fac_alunos_semestres.id')
                ->join('fac_horarios', 'fac_horarios.id', '=', 'fac_alunos_semestres_horarios.horario_id')
                ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.id', '=', 'fac_horarios.turma_disciplina_id')
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_turmas_disciplinas.disciplina_id')
                ->where('fac_alunos.id', $aluno->id)
                ->where('fac_alunos_semestres.semestre_id', $semestreAtivo->id)
                ->select([
                    'fac_disciplinas.qtd_credito'
                ])->get();


            if ($precoAtivo->tipo->nome == 'Crédito') {
                $configuracaoAtiva = $precoAtivo->precosDisciplaCurso()->get()->last();
                $valorCredito = $configuracaoAtiva->preco;
                $quantidadeCredito = $configuracaoAtiva->qtd_disciplinas;
                $qtdCreditoDisciplinas = 0;

                foreach ($disciplinas as $disciplina) {
                    $qtdCreditoDisciplinas += $disciplina->qtd_credito;
                }

                $retorno['valor'] = (float) (((int) $qtdCreditoDisciplinas / $quantidadeCredito) * $valorCredito);
            }

            return response()->json(['success' => true, 'dados' => $retorno]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
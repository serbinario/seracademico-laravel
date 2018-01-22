<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Biblioteca\GeneroService;
use Seracademico\Uteis\SerbinarioDateFormat;
use Seracademico\Validators\SalaValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use \Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Entities\Biblioteca\Exemplar;

class RelatorioController extends Controller
{
    /**
     * @var GeneroService
     */
    private $service;

    /**
     * @var SalaValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'PosGraduacao\Curso',
        'Biblioteca\Genero',
        'Biblioteca\TipoAcervo'
    ];

    /**
     * @param GeneroService $service
     * @param SalaValidator $validator
     */
    public function __construct(GeneroService $service, SalaValidator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRelatorioLivrosPorCurso()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('biblioteca.relatorios.report_acervoByCurso', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function relatorioLivrosPorCurso(Request $request)
    {

        $requisicao = $request->request->all();

        // Pegando os cursos
        $cursos = \DB::table('fac_cursos')->select('nome', 'id');

        // Validando se um curso foi selecioando e realizando o filtro com o msm
        if($request->has('curso') && $request->get('curso') != "") {
            $cursos->where('id', '=', $request->get('curso'));
        }

        $cursos = $cursos->get();


        // Varrendo todos os livros e inserindo seus respectivos cursos
        foreach($cursos as $chave => $curso) {

            // Selecioando os livros por curso
            $livros = \DB::table('bib_exemplares')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->leftJoin('primeira_entrada', 'bib_arcevos.id', '=', 'primeira_entrada.arcevos_id')
                ->leftJoin('responsaveis', 'responsaveis.id', '=', 'primeira_entrada.responsaveis_id')
                ->leftJoin('segunda_entrada', 'bib_arcevos.id', '=', 'segunda_entrada.arcevos_id')
                ->leftJoin('responsaveis as outro_responsavel', 'outro_responsavel.id', '=', 'segunda_entrada.responsaveis_id')
                ->leftJoin('bib_tipos_acervos', 'bib_tipos_acervos.id', '=', 'bib_arcevos.tipos_acervos_id')
                ->leftJoin('bib_arcevos_cursos', 'bib_arcevos.id', '=', 'bib_arcevos_cursos.arcevos_id')
                ->leftJoin('fac_cursos', 'fac_cursos.id', '=', 'bib_arcevos_cursos.cursos_id')
                ->leftJoin('bib_editoras', 'bib_editoras.id', '=', 'bib_exemplares.editoras_id')
                ->leftJoin('bib_genero', 'bib_genero.id', '=', 'bib_arcevos.genero_id')
                //->where('bib_tipos_acervos.tipo', '=', '1')
                ->where('bib_exemplares.exemp_principal', '=', '1')
                ->where('fac_cursos.id', '=', $curso->id)
                ->groupBy('bib_arcevos.id')
                ->orderBy('bib_arcevos.titulo','DESC')
                ->select([
                    'bib_arcevos.id',
                    'bib_arcevos.cdd',
                    'bib_arcevos.cutter',
                    'bib_arcevos.etial_autor',
                    'bib_arcevos.etial_outros',
                    'bib_arcevos.titulo',
                    'bib_arcevos.subtitulo',
                    'bib_arcevos.tipo_periodico',
                    'bib_arcevos.assunto',
                    'bib_exemplares.ano',
                    'bib_exemplares.ilustracoes_id',
                    'bib_exemplares.numero_pag',
                    'bib_exemplares.isbn',
                    'bib_exemplares.issn',
                    'bib_exemplares.edicao',
                    'bib_exemplares.local',
                    'bib_exemplares.num_periodico',
                    'bib_exemplares.ampliada',
                    'bib_exemplares.revisada',
                    'bib_exemplares.atualizada',
                    'bib_exemplares.vol_periodico',
                    'bib_exemplares.numero_pag',
                    'bib_exemplares.ilustracoes_id',
                    'bib_editoras.nome as editora',
                    'bib_genero.nome as area'
                ]);

            if($request->has('tipo_acervo') && $request->get('tipo_acervo') != "") {
                $livros->where('bib_tipos_acervos.tipo', '=', $request->get('tipo_acervo'));
            }

            if($request->has('area') && $request->get('area') != "") {
                $livros->where('bib_genero.id', '=', $request->get('area'));
            }

            if($request->has('assunto') && $request->get('assunto') != "") {
                $livros->where("bib_arcevos.assunto", 'like', "%{$request->get('assunto')}%");
            }

            if($request->has('responsavel') && $request->get('responsavel') != "") {
                $livros->where("responsaveis.id", '=', $request->get('responsavel'));
            }

            if($request->has('outro_responsavel') && $request->get('outro_responsavel') != "") {
                $livros->where("outro_responsavel.id", '=', $request->get('outro_responsavel'));
            }

            if($request->has('titulo') && $request->get('titulo') != "") {
                $livros->where("bib_arcevos.titulo", 'like', "%{$request->get('titulo')}%");
            }

            if($request->has('cdd') && $request->get('cdd') != "") {
                $livros->where("bib_arcevos.cdd", '=', $request->get('cdd'));
            }

            if($request->has('cutter') && $request->get('cutter') != "") {
                $livros->where("bib_arcevos.cutter", '=', $request->get('cutter'));
            }

            $livros = $livros->get();

            // Pegando os autores e outros pespons�veis de cada livro
            foreach($livros as $ch => $livro) {

                // Autores
                $autores = \DB::table('primeira_entrada')
                    ->join('responsaveis', 'responsaveis.id', '=', 'primeira_entrada.responsaveis_id')
                    ->where('primeira_entrada.arcevos_id', '=', $livro->id)
                    ->select([
                        'responsaveis.nome',
                        'responsaveis.sobrenome',
                        'responsaveis.tipo_reponsavel_id'
                    ])->get();

                // Outros respons�veis
                $outros = \DB::table('segunda_entrada')
                    ->join('responsaveis', 'responsaveis.id', '=', 'segunda_entrada.responsaveis_id')
                    ->where('segunda_entrada.arcevos_id', '=', $livro->id)
                    ->select([
                        'responsaveis.nome',
                        'responsaveis.sobrenome',
                        'responsaveis.tipo_reponsavel_id',
                        'segunda_entrada.tipo_autor_id',
                        'segunda_entrada.para_referencia1',
                        'segunda_entrada.para_referencia2',
                        'segunda_entrada.para_referencia3',
                        'segunda_entrada.exibir_tipo1',
                        'segunda_entrada.exibir_tipo2',
                        'segunda_entrada.exibir_tipo3',
                    ])->get();

                // Pegando a quantidade de exemplares
                $qtdExemplares = \DB::table('bib_exemplares')
                    ->where('bib_exemplares.arcevos_id', '=', $livro->id)
                    ->select([
                        \DB::raw('COUNT(bib_exemplares.id) as qtdExemplares'),
                    ])->first();

                // Organizando os autores, outros respons�veis e quantidade de exemplares por livro
                $arrayTempLivros = (array) $livros[$ch];
                $livros[$ch] = (object) array_merge($arrayTempLivros, [
                    'autores' => $autores,
                    'outros' => $outros,
                    'qtdExemplares' => $qtdExemplares->qtdExemplares,
                ]);

            }

            // Organizando os livros por curso
            $arrayTemp = (array) $cursos[$chave];
            $cursos[$chave] = (object) array_merge($arrayTemp, ['livros' => $livros]);

            // Tirando os cursos que n�o possuem livros na consulta realizada
            if(count($livros) <= 0) {
                unset($cursos[$chave]);
            }
        }

        if($request->get('tipo_relatorio') == '1') {
            #Gerando o pdf
            return \PDF::loadView('reports.biblioteca.relatorioLivroPorCursoCampos', compact('cursos', 'requisicao'))->setOrientation('landscape')->stream();
        } else {
            #Gerando o pdf
            return \PDF::loadView('reports.biblioteca.relatorioLivroPorCursoReferencia', compact('cursos'))->setOrientation('landscape')->stream();
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRelatorioDeAtividades()
    {
        return view('biblioteca.relatorios.report_atividades');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function relatorioDeAtividades(Request $request)
    {

        $ano = $request->has('ano') ? $request->get('ano') : "";

        $qtdLivros = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '1')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd'),
            ]);

        if($request->has('ano') && $request->get('ano') != "") {
            $qtdLivros->where(\DB::raw('DATE_FORMAT(bib_exemplares.data_aquisicao,"%Y")'), '=', $request->get('ano'));
        }

        $qtdLivros = $qtdLivros->first();

        ###################################################################

        $qtdLivrosComprados = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '1')
            ->where('bib_exemplares.aquisicao_id', '=', '1')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd'),
            ]);


        if($request->has('ano') && $request->get('ano') != "") {
            $qtdLivrosComprados->where(\DB::raw('DATE_FORMAT(bib_exemplares.data_aquisicao,"%Y")'), '=', $request->get('ano'));
        }

        $qtdLivrosComprados = $qtdLivrosComprados->first();

        ###################################################################

        $qtdLivrosDoados = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '1')
            ->where('bib_exemplares.aquisicao_id', '=', '2')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd'),
            ]);

        if($request->has('ano') && $request->get('ano') != "") {
            $qtdLivrosDoados->where(\DB::raw('DATE_FORMAT(bib_exemplares.data_aquisicao,"%Y")'), '=', $request->get('ano'));
        }

        $qtdLivrosDoados = $qtdLivrosDoados->first();

        ###################################################################

        $qtdEmprestimos = \DB::table('bib_emprestimos_exemplares')
            ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->select([
                \DB::raw('COUNT(bib_emprestimos_exemplares.id) as qtd'),
            ]);

        if($request->has('ano') && $request->get('ano') != "") {
            $qtdEmprestimos->where(\DB::raw('DATE_FORMAT(bib_emprestimos.data,"%Y")'), '=', $request->get('ano'));
        }

        $qtdEmprestimos = $qtdEmprestimos->first();

        ###################################################################

        $qtdTotalLivros = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '1')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd'),
                \DB::raw('SUM(bib_exemplares.valor) as valorTotal'),
            ])->first();

        return \PDF::loadView('reports.biblioteca.relatorio_deAtividades',
            compact('qtdLivros', 'qtdLivrosComprados', 'qtdLivrosDoados',
                'qtdEmprestimos','qtdTotalLivros', 'ano'))->stream();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRelatorioDeEmprestimos()
    {
        return view('biblioteca.relatorios.relatorio_emprestimos');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function relatorioDeEmprestimos(Request $request)
    {

        $requisicao = $request->request->all();

        $dataIni = SerbinarioDateFormat::toUsa($requisicao['data_inicial']);
        $dataFim = SerbinarioDateFormat::toUsa($requisicao['data_final']);

        $emprestimos = \DB::table('bib_emprestimos_exemplares')
            ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
            ->join('bib_tipos_acervos', 'bib_tipos_acervos.id', '=', 'bib_arcevos.tipos_acervos_id')
            ->where('bib_emprestimos.status_devolucao', 0)
            ->select([
                'pessoas.identidade',
                'pessoas.nome',
                \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as registro'),
                'bib_arcevos.titulo',
                \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                'bib_tipos_acervos.nome as tipo_acervo'
            ]);

        if($dataIni && $dataIni) {
            $emprestimos->whereBetween('bib_emprestimos.data', array($dataIni, $dataFim));
        };

        $emprestimos = $emprestimos->get();

        return \PDF::loadView('reports.biblioteca.relatorioDeEmprestimos', compact('emprestimos', 'requisicao'))->setOrientation('landscape')->stream();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRelatorioDeDevolucao()
    {
        return view('biblioteca.relatorios.relatorio_devolucao');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function relatorioDeDevolucao(Request $request)
    {

        $requisicao = $request->request->all();

        $dataIni = SerbinarioDateFormat::toUsa($requisicao['data_inicial']);
        $dataFim = SerbinarioDateFormat::toUsa($requisicao['data_final']);

        $emprestimos = \DB::table('bib_emprestimos_exemplares')
            ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
            ->join('bib_tipos_acervos', 'bib_tipos_acervos.id', '=', 'bib_arcevos.tipos_acervos_id')
            ->where('bib_emprestimos.status_devolucao', 1)
            ->select([
                'pessoas.identidade',
                'pessoas.nome',
                \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as registro'),
                'bib_arcevos.titulo',
                \DB::raw('DATE_FORMAT(bib_emprestimos.data,"%d/%m/%Y") as data'),
                'bib_tipos_acervos.nome as tipo_acervo'
            ]);

        if($dataIni && $dataIni) {
            $emprestimos->whereBetween('bib_emprestimos.data', array($dataIni, $dataFim));
        };

        $emprestimos = $emprestimos->get();

        return \PDF::loadView('reports.biblioteca.relatorioDeDevolucao', compact('emprestimos', 'requisicao'))->setOrientation('landscape')->stream();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexEditBiblioteca()
    {
        return view('biblioteca.relatorios.relatorio_editBiblioteca');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editBiblioteca(Request $request)
    {

        $ano = $request->has('ano') ? $request->get('ano') : "";

        $qtdLivrosPeriodicos = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '2')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd'),
            ]);

        if($request->has('ano') && $request->get('ano') != "") {
            $qtdLivrosPeriodicos->where(\DB::raw('DATE_FORMAT(bib_exemplares.data_aquisicao,"%Y")'), '=', $request->get('ano'));
        }

        $qtdLivrosPeriodicos = $qtdLivrosPeriodicos->first();

        ##########################################################

        $qtdLivrosNaoPeriodicos = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '1')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd'),
            ]);

        if($request->has('ano') && $request->get('ano') != "") {
            $qtdLivrosNaoPeriodicos->where(\DB::raw('DATE_FORMAT(bib_exemplares.data_aquisicao,"%Y")'), '=', $request->get('ano'));
        }

        $qtdLivrosNaoPeriodicos = $qtdLivrosNaoPeriodicos->first();

        ##########################################################

        $qtdEmprestimos = \DB::table('bib_emprestimos_exemplares')
            ->join('bib_emprestimos', 'bib_emprestimos.id', '=', 'bib_emprestimos_exemplares.emprestimo_id')
            ->select([
                \DB::raw('COUNT(bib_emprestimos_exemplares.id) as qtd'),
            ]);

        if($request->has('ano') && $request->get('ano') != "") {
            $qtdEmprestimos->where(\DB::raw('DATE_FORMAT(bib_emprestimos.data,"%Y")'), '=', $request->get('ano'));
        }

        $qtdEmprestimos = $qtdEmprestimos->first();

        return \PDF::loadView('reports.biblioteca.relatorio_biblioteca',
            compact('qtdLivrosPeriodicos', 'qtdLivrosNaoPeriodicos', 'qtdEmprestimos', 'ano'))->stream();
    }
}

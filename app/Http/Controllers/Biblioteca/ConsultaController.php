<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Biblioteca\ArcevoRepository;
use Seracademico\Services\Biblioteca\ArcevoService;
use Seracademico\Services\Biblioteca\ExemplarService;

class ConsultaController extends Controller
{

    /**
     * @var ExemplarService
     */
    private $serviceExem;

    /**
     * @var ArcevoService
     */
    private $serviceAcer;

    /**
     * @var
     */
    private $data;

    /**
     * @var array
     */
    private $loadFields = [
        'Biblioteca\TipoAcervo',
    ];

    /**
     * @param ExemplarService $service
     */
    public function __construct(ExemplarService $serviceExem, ArcevoService $serviceAcer)
    {
        $this->serviceExem   =  $serviceExem;
        $this->serviceAcer   =  $serviceAcer;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->serviceAcer->load($this->loadFields);

        return view('portal.biblioteca.consulta.index', compact('loadFields'));

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function seachSimple(Request $request)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->serviceAcer->load($this->loadFields);

        $dados = $request->request->all();

        $request->session()->set('dados', $dados);
        $data = $request->session()->get('dados');

        $resultado = $this->query($data);

        return \View::make('portal.biblioteca.consulta.resultado')->with(compact('resultado', 'loadFields'));

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function seachSimplePage(Request $request)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->serviceAcer->load($this->loadFields);

        $dados = $request->request->all();

        $data = $request->session()->get('dados');
        $data['page'] = $dados['page'];

        $resultado = $this->query($data);

        return \View::make('portal.biblioteca.consulta.resultado')->with(compact('resultado', 'loadFields'));

    }
    
    /**
     * @param $dados
     * @return mixed
     */
    public function query($dados){

        $this->data = $dados;
        $campoLike = "";

        if($this->data['busca_por'] == '2') {
            $campoLike = 'bib_arcevos.titulo';
        } else if ($this->data['busca_por'] == '3' && $this->data['tipo_obra'] == '1') {
            $campoLike = 'bib_arcevos.assunto';
        } else if ($this->data['busca_por'] == '4') {
            $campoLike = 'responsaveis.nome';
        } else if ($this->data['busca_por'] == '3' && $this->data['tipo_obra'] == '2') {
            $campoLike = 'bib_exemplares.assunto_p';
        } else if ($this->data['busca_por'] == '5' && $this->data['tipo_obra'] == '1') {
            $campoLike = 'bib_arcevos.palavras_chaves';
        } else if ($this->data['busca_por'] == '5' && $this->data['tipo_obra'] == '2') {
            $campoLike = 'bib_exemplares.palavras_chaves';
        } else if ($this->data['busca_por'] == '6') {
            $campoLike = 'bib_arcevos.sumario';
        }

        if($this->data['busca_por'] == '2' || $this->data['busca_por'] == '3' 
            || $this->data['busca_por'] == '4' || $this->data['busca_por'] == '5' || $this->data['busca_por'] == '6') {

            $my_query = \DB::table('bib_exemplares')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->leftJoin('primeira_entrada', 'bib_arcevos.id', '=', 'primeira_entrada.arcevos_id')
                ->leftJoin('responsaveis', 'responsaveis.id', '=', 'primeira_entrada.responsaveis_id')
                ->select('responsaveis.*', 'bib_arcevos.*', 'bib_arcevos.id as id_acervo', 'bib_exemplares.*')
                ->where('bib_arcevos.tipos_acervos_id', '=', $this->data['tipo_obra'])
                ->where($campoLike, 'like', "%{$this->data['busca']}%")
                ->orWhere('responsaveis.sobrenome', 'like', "%{$this->data['busca']}%")
                ->groupBy('bib_exemplares.edicao', 'bib_exemplares.ano', 'bib_exemplares.isbn')
                ->orderBy('bib_arcevos.titulo','DESC')
                ->paginate(10);

        } else {
            $my_query = \DB::table('bib_exemplares')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->leftJoin('primeira_entrada', 'bib_arcevos.id', '=', 'primeira_entrada.arcevos_id')
                ->leftJoin('responsaveis', 'responsaveis.id', '=', 'primeira_entrada.responsaveis_id')
                ->select('responsaveis.*', 'bib_arcevos.*', 'bib_arcevos.id as id_acervo','bib_exemplares.*')
                ->where('bib_arcevos.tipos_acervos_id', '=', $this->data['tipo_obra'])
                ->Where(function ($query) {
                    $query->orWhere('responsaveis.nome', 'like', "%{$this->data['busca']}%")
                        ->orWhere('responsaveis.sobrenome', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_arcevos.assunto', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_arcevos.titulo', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_exemplares.assunto_p', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_arcevos.palavras_chaves', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_exemplares.palavras_chaves', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_arcevos.sumario', 'like', "%{$this->data['busca']}%");
                })
                ->groupBy('bib_exemplares.edicao', 'bib_exemplares.ano', 'bib_exemplares.isbn')
                ->orderBy('bib_arcevos.titulo','DESC')
                ->paginate(10);
        }

        $my_query->setPath(url('seracademico/biblioteca/seachSimplePage'));

        return $my_query;

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function seachDetalhe($exemplar)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->serviceAcer->load($this->loadFields);

        $data = $this->serviceExem->detalheAcervo($exemplar);
        $exemplar = $data['exemplar'];
        $exemplares = $data['exemplares'];

        return view('portal.biblioteca.consulta.detalhe', compact('loadFields', 'exemplar', 'exemplares'));

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function meusEmprestimos()
    {
        return view('portal.biblioteca.consulta.emprestimos');
    }
}

<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\Biblioteca\ArcevoRepository;
use Seracademico\Services\Biblioteca\ArcevoService;

class ConsultaController extends Controller
{

    /**
     * @var ArcevoService
     */
    private $service;

    private $data;

    /**
     * @var array
     */
    private $loadFields = [
        'Biblioteca\TipoAcervo',
    ];

    /**
     * @param ArcevoService $service
     * @param ArcevoValidator $validator
     */
    public function __construct(ArcevoService $service)
    {
        $this->service   =  $service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        return view('biblioteca.consulta.index', compact('loadFields'));

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function seachSimple(Request $request)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        $dados = $request->request->all();

        $request->session()->set('dados', $dados);
        $data = $request->session()->get('dados');

        $resultado = $this->query($data);

        //dd($resultado);

        return \View::make('biblioteca.consulta.resultado2')->with(compact('resultado', 'loadFields'));

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function seachSimplePage(Request $request)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        $dados = $request->request->all();

        $data = $request->session()->get('dados');
        $data['page'] = $dados['page'];

        $resultado = $this->query($data);

        return \View::make('biblioteca.consulta.resultado2')->with(compact('resultado', 'loadFields'));

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
        } else if ($this->data['busca_por'] == '3') {
            $campoLike = 'bib_arcevos.assunto';
        } else if ($this->data['busca_por'] == '4') {
            $campoLike = 'responsaveis.nome';
        }

        if($this->data['busca_por'] == '2' || $this->data['busca_por'] == '3' || $this->data['busca_por'] == '4') {
            $my_query = \DB::table('bib_arcevos')
                ->join(\DB::raw('(SELECT arcevos_id, id, responsaveis_id FROM primeira_entrada ORDER BY id ASC LIMIT 1)entrada'), function ($join) {
                    $join->on('entrada.arcevos_id', '=', 'bib_arcevos.id');
                })
                ->join('responsaveis', 'responsaveis.id', '=', 'entrada.responsaveis_id')
                ->select('bib_arcevos.*', 'bib_arcevos.id as id_acervo','responsaveis.*')
                ->where('bib_arcevos.tipos_acervos_id', '=', $this->data['tipo_obra'])
                ->where($campoLike, 'like', "%{$this->data['busca']}%")
                ->orderBy('bib_arcevos.titulo','DESC')
                ->paginate(10);
        } else {
            $my_query = \DB::table('bib_arcevos')
                ->join(\DB::raw('(SELECT arcevos_id, id, responsaveis_id FROM primeira_entrada ORDER BY id ASC LIMIT 1)entrada'), function ($join) {
                    $join->on('entrada.arcevos_id', '=', 'bib_arcevos.id');
                })
                ->join('responsaveis', 'responsaveis.id', '=', 'entrada.responsaveis_id')
                ->select('bib_arcevos.*', 'bib_arcevos.id as id_acervo','responsaveis.*')
                ->where('bib_arcevos.tipos_acervos_id', '=', $this->data['tipo_obra'])
                ->Where(function ($query) {
                    $query->orWhere('responsaveis.nome', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_arcevos.assunto', 'like', "%{$this->data['busca']}%")
                        ->orWhere('bib_arcevos.titulo', 'like', "%{$this->data['busca']}%");
                })
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
    public function seachDetalhe($acervo)
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        $acervo = $this->service->detalheAcervo($acervo);

        //dd(compact('acervo'));

        return view('biblioteca.consulta.detalhe', compact('loadFields', 'acervo'));

    }
}

<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Biblioteca\ExemplarService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Biblioteca\ExemplarValidator;

class ExemplarController extends Controller
{
    /**
    * @var ExemplarService
    */
    private $service;

    /**
    * @var ExemplarValidator
    */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Aquisicao',
        'Ilustracao',
        'Idioma',
        'Situacao',
        'Emprestimo',
        'Genero',
        'Editora',
        'Responsavel'
    ];

    /**
    * @param ExemplarService $service
    * @param ExemplarValidator $validator
    */
    public function __construct(ExemplarService $service, ExemplarValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('biblioteca.exemplar.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->join('bib_emprestimo', 'bib_emprestimo.id', '=', 'bib_exemplares.emprestimo_id')
            ->join('bib_situacao', 'bib_situacao.id', '=', 'bib_exemplares.situacao_id')
            ->where('bib_arcevos.tipo_periodico', '=', '1')
            ->select('bib_exemplares.id as id',
                'bib_arcevos.titulo',
                'bib_arcevos.cutter',
                'bib_exemplares.edicao',
                 'bib_situacao.nome as nome_sit',
                'bib_arcevos.subtitulo as subtitulo',
                \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo')
                );

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html       = '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                            <li><a class="btn-floating" href="editExemplar/'.$row->id.'" title="Editar disciplina"><i class="material-icons">edit</i></a></li>
                            <li><a class="btn-floating" target="_blank" href="fixaFrente/'.$row->id.'" title="Fixa frente"><i class="material-icons">undo</i></a></li>
                            <li><a class="btn-floating" target="_blank" href="fixaVerso/'.$row->id.'" title="Fixa verso"><i class="material-icons">redo</i></a></li>';

            $emprestimo = $this->service->find($row->id);
            # Verificando se existe vinculo com o currículo
           if(count($emprestimo->emprestimos) == 0) {
                $html .= '<li><a class="btn-floating excluir" href="deleteExemplar/'.$row->id.'" title="Excluir disciplina"><i class="material-icons">delete</i></a></li>
                            </ul>
                           </div>';
           }

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);
        $acervo = $this->service->acervos($this->loadFields);

        #Retorno para view
        return view('biblioteca.exemplar.create', compact('loadFields', 'acervo'));
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->find($id);
            
            #Tratando as datas
            $model = $this->service->getDateFormatPtBr($model);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);
            $acervo = $this->service->acervos($this->loadFields);

            #retorno para view
            return view('biblioteca.exemplar.edit', compact('model', 'loadFields', 'acervo'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function getImg($id)
    {
        #Recuperando a empresa
        $model = $this->service->find($id);

        return response($model->path_image) ->header('Content-Type', 'image/jpeg');
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function delete($id)
    {
        try {
            #Executando a ação
            $this->service->delete($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function fixaFrente($id)
    {
        #Recuperando a empresa
        $result = $this->service->findFixa($id);

        return \PDF::loadView('biblioteca.fixas.frente', ['result' => $result])->stream();
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function fixaVerso($id)
    {
        #Recuperando a empresa
        $result = $this->service->findFixa($id);

        $query = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_exemplares.edicao', '=', $result->edicao)
            ->where('bib_exemplares.ano', '=', $result->ano)
            ->where('bib_arcevos.id', '=', $result->arcevos_id)
            ->select([
                \DB::raw("COUNT(bib_exemplares.id) as qtd_exemplar")
            ])->first();

        //dd($result);

        return \PDF::loadView('biblioteca.fixas.verso', ['result' => $result, 'qtdExemplar' => $query->qtd_exemplar])->stream();
    }

}

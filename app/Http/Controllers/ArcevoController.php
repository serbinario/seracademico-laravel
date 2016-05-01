<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\ArcevoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\ArcevoValidator;

class ArcevoController extends Controller
{
    /**
    * @var ArcevoService
    */
    private $service;

    /**
    * @var ArcevoValidator
    */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'TipoAcervo',
        'Responsavel',
        'TipoAutor',
        'Corredor',
        'Estante',
        'Colecao',
        'Genero',
        'Situacao',
        'Curso'
    ];

    /**
    * @param ArcevoService $service
    * @param ArcevoValidator $validator
    */
    public function __construct(ArcevoService $service, ArcevoValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('biblioteca.acervo.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_arcevos')
            ->select([
            'bib_arcevos.id',
            'bib_arcevos.titulo',
            'bib_arcevos.subtitulo',
            'bib_arcevos.cutter',
            'bib_arcevos.cdd',
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html       = '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                            <li><a class="btn-floating" href="editAcervo/'.$row->id.'" title="Editar disciplina"><i class="material-icons">edit</i></a></li>';
            $obra = $this->service->find($row->id);
            # Verificando se existe vinculo com o currículo
            if(count($obra['acervo']->exemplares) == 0) {
                $html .= '<li><a class="btn-floating excluir" href="deleteAcervo/'.$row->id.'" title="Excluir disciplina"><i class="material-icons">delete</i></a></li>
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

        #Retorno para view
        return view('biblioteca.acervo.create', compact('loadFields'));
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

            //dd($data);

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
            $retorno = $this->service->find($id);
            $model = $retorno['acervo'];
            $segundaEntrada = $retorno['segundaEntrada'];
            $primeiraEntrada = $retorno['primeiraEntrada'];
            //dd($segundaEntrada);

            #Tratando as datas
           // $aluno = $this->service->getAlunoWithDateFormatPtBr($aluno);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('biblioteca.acervo.edit', compact('model', 'segundaEntrada', 'primeiraEntrada','loadFields'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
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
            //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

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

}

<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Biblioteca\ArcevoPeriodicoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Biblioteca\ArcevoPeriodicoValidator;

class ArcevoPeriodicoController extends Controller
{
    /**
    * @var ArcevoPeriodicoService
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
        'Biblioteca\\TipoAcervo|tipoAcervoP,2',
        'Biblioteca\Responsavel',
        'Biblioteca\TipoAutor',
        'Biblioteca\Corredor',
        'Biblioteca\Estante',
        'Biblioteca\Colecao',
        'Biblioteca\Genero',
        'Biblioteca\Situacao',
        'Graduacao\Curso'
    ];

    /**
    * @param ArcevoPeriodicoService $service
    * @param ArcevoValidator $validator
    */
    public function __construct(ArcevoPeriodicoService $service, ArcevoPeriodicoValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('biblioteca.acervoPeriodico.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_arcevos')
            ->leftJoin(\DB::raw('(SELECT arcevos_id, count(*) as qtd_exemplares FROM bib_exemplares GROUP BY arcevos_id)exemplares'), function ($join) {
                $join->on('exemplares.arcevos_id', '=', 'bib_arcevos.id');
            })
            ->where('tipo_periodico', '=', '2')
            ->select([
                'bib_arcevos.id',
                'bib_arcevos.titulo',
                'bib_arcevos.cdd',
                'exemplares.qtd_exemplares',
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html       = '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                            <li><a class="btn-floating" href="editAcervoP/'.$row->id.'" title="Editar disciplina"><i class="material-icons">edit</i></a></li>';
            $obra = $this->service->find($row->id);
            # Verificando se existe vinculo com o currículo
            if(count($obra['acervo']->exemplares) == 0) {
                $html .= '<li><a class="btn-floating excluir" href="deleteAcervoP/'.$row->id.'" title="Excluir disciplina"><i class="material-icons">delete</i></a></li>
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
        return view('biblioteca.acervoPeriodico.create', compact('loadFields'));
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
            $retorno = $this->service->find($id);
            $model = $retorno['acervo'];
            $segundaEntrada = $retorno['segundaEntrada'];
            $primeiraEntrada = $retorno['primeiraEntrada'];


            #Tratando as datas
            $model = $this->service->getDateFormatPtBr($model);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('biblioteca.acervoPeriodico.edit', compact('model', 'segundaEntrada', 'primeiraEntrada','loadFields'));
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

}

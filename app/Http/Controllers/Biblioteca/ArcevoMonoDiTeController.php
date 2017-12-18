<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Biblioteca\ArcevoMonoDiTeService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Biblioteca\ArcevoMonoDiTeValidator;

class ArcevoMonoDiTeController extends Controller
{
    /**
    * @var ArcevoMonoDiTeService
    */
    private $service;

    /**
    * @var ArcevoMonoDiTeValidator
    */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Biblioteca\\TipoAcervo|tipoAcervoMDT,1',
        'Biblioteca\Responsavel',
        'Biblioteca\TipoAutor',
        'Biblioteca\Corredor',
        'Biblioteca\Estante',
        'Biblioteca\Situacao',
        'Graduacao\Curso',
        'Biblioteca\TipoResponsavel'
    ];

    /**
    * @param ArcevoMonoDiTeService $service
    * @param ArcevoMonoDiTeValidator $validator
    */
    public function __construct(ArcevoMonoDiTeService $service,
                                ArcevoMonoDiTeValidator $validator)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('biblioteca.acervomdt.index');
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
            ->leftJoin(\DB::raw('(SELECT arcevos_id, id, responsaveis_id FROM primeira_entrada GROUP BY arcevos_id)entrada'), function ($join) {
                $join->on('entrada.arcevos_id', '=', 'bib_arcevos.id');
            })
//            ->join('primeira_entrada', 'primeira_entrada.arcevos_id', '=', 'bib_arcevos.id')
            ->leftJoin('responsaveis', 'responsaveis.id', '=', 'entrada.responsaveis_id')
            ->where('bib_arcevos.tipo_periodico', '=', '3')
            ->select([
            'bib_arcevos.id',
            'bib_arcevos.titulo',
            'bib_arcevos.subtitulo',
            'bib_arcevos.cutter',
            'bib_arcevos.cdd',
            'exemplares.qtd_exemplares',
            \DB::raw('CASE responsaveis.tipo_reponsavel_id WHEN "2"
            THEN responsaveis.nome WHEN "1"
            THEN CONCAT(responsaveis.sobrenome, ", ", responsaveis.nome) END as autor'),
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html       = '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                            <li><a class="btn-floating" href="editAcervoMonoDiTe/'.$row->id.'" title="Editar disciplina"><i class="material-icons">edit</i></a></li>';
            $obra = $this->service->find($row->id);
            # Verificando se existe vinculo com o currículo
            if(count($obra['acervo']->exemplares) == 0) {
                $html .= '<li><a class="btn-floating excluir" href="deleteAcervoMonoDiTe/'.$row->id.'" title="Excluir disciplina"><i class="material-icons">delete</i></a></li>
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
        $cursos =   $this->service->loadCursos();

        #Retorno para view
        return view('biblioteca.acervomdt.create', compact('loadFields', 'cursos'));
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
        } catch (\Throwable $e) {
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

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);
            $cursos =   $this->service->loadCursos();

            #retorno para view
            return view('biblioteca.acervomdt.edit', compact('model', 'segundaEntrada', 'primeiraEntrada','loadFields', 'cursos'));
        } catch (\Throwable $e) {
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
        } catch (\Throwable $e) {
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
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function getCutter(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $result = $this->service->getCutter($data['dados']);

            #Retorno para a view
            return array('result' => $result);
        } catch (ValidatorException $e) {
            return $this->validator->errors();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

}

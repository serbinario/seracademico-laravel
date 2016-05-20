<?php

namespace Seracademico\Http\Controllers\Biblioteca;

use Illuminate\Http\Request;

use Seracademico\Entities\Biblioteca\Reserva;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Seracademico\Services\Biblioteca\ArcevoService;
use Seracademico\Services\Biblioteca\ReservaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\Biblioteca\ReservaValidator;

class ReservaController extends Controller
{
    /**
    * @var ReservaService
    */
    private $service;

    /**
     * @var ArcevoService
     */
    private $serviceAcervo;

    /**
    * @var ReservaValidator
    */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Aluno'
    ];

    /**
    * @param ReservaService $service
    * @param ReservaValidator $validator
    */
    public function __construct(ReservaService $service, ArcevoService $serviceAcervo, ReservaValidator $validator)
    {
        $this->service   =  $service;
        $this->serviceAcervo   =  $serviceAcervo;
        $this->validator =  $validator;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('biblioteca.controle.reserva.index', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_arcevos')
            ->join('bib_exemplares', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            //->leftJoin('primeira_entrada', 'bib_arcevos.id', '=', 'primeira_entrada.arcevos_id')
            //->leftJoin('responsaveis', 'responsaveis.id', '=', 'primeira_entrada.responsaveis_id')
            ->where('bib_exemplares.situacao_id', '=', '5')
            ->where('bib_exemplares.situacao_id', '!=', '1')
            ->where('bib_exemplares.situacao_id', '!=', '3')
            ->where('bib_exemplares.situacao_id', '!=', '2')
            ->where('bib_exemplares.exemp_principal', '!=', '1')
            ->select(
                'bib_arcevos.titulo',
                'bib_arcevos.id',
                'bib_arcevos.cutter',
                'bib_exemplares.edicao',
                'bib_arcevos.subtitulo as subtitulo'
                )
            ->groupBy('bib_exemplares.edicao', 'bib_exemplares.ano', 'bib_exemplares.isbn');

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html       = '<a class="btn-floating add" href="" title="Editar disciplina"><i class="fa fa-plus"></i></a></li>';

            # Retorno
            return $html;
        })->make(true);
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

            #tratando as rules
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Reserva realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
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

            #tratando as rules
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

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
     * @return mixed
     */
    public function reservados(){

        return view('biblioteca.controle.reserva.reservas');
    }

    /**
     * @param Request $request
     */
    public function gridReservados(Request $request)
    {
        //$dataObj = new \DateTime('now');
        //$this->data    = $dataObj->format('d/m/Y');

        #Criando a consulta
        $rows = Reserva::join('fac_alunos', 'fac_alunos.id', '=', 'bib_reservas.alunos_id')
            ->with(['reservaExemplar.exemplares'])
            ->select(
                ['bib_reservas.codigo',
                    'bib_reservas.*',
                    'fac_alunos.nome',
                    \DB::raw('DATE_FORMAT(bib_reservas.data,"%d/%m/%Y") as data'),
                    \DB::raw('DATE_FORMAT(bib_reservas.data_vencimento,"%d/%m/%Y") as data_vencimento'),
                ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = "";
            //if(!$row->data_devolucao_real) {
                $html .= '<div class="fixed-action-btn horizontal">
                      <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                       <ul>
                       <li><a class="btn-floating excluir" href="confirmarDevolucao/'.$row->id.'" title="Devolver"><i class="material-icons">delete</i></a></li>';
                //if($row->tipo_emprestimo == '1' && strtotime($row->data_devolucao) > strtotime($this->data)) {
                    $html .= '<li><a class="btn-floating renovar" href="renovacao/'.$row->id.'" title="Renovar"><i class="material-icons">edit</i></a></li>
                </ul>
                </div>';
               // }
            //}

            # Retorno
            return $html;
        })->make(true);
    }

}

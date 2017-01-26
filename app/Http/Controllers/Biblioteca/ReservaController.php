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
        'Pessoa'
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
        $reservasPendentes = $this->service->findWherePendencias();

        return view('biblioteca.controle.reserva.index', compact('loadFields', 'reservasPendentes'));
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_exemplares.exemp_principal', '=', '0')
            ->select(
                'bib_arcevos.titulo',
                'bib_arcevos.id as id_acervo',
                'bib_arcevos.cutter',
                'bib_exemplares.edicao',
                'bib_exemplares.situacao_id',
                'bib_exemplares.emprestimo_id as id_emp',
                'bib_arcevos.subtitulo as subtitulo'
                )
            ->groupBy('bib_exemplares.edicao', 'bib_exemplares.ano', 'bib_exemplares.isbn')
            ->having(\DB::raw('sum(bib_exemplares.situacao_id) = count(*) * 5'), '=', '1');

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
        $req = $request->request->all();

        $data = $this->service->store($req);

        $request->session()->put('id_pessoa_reserva', $request['pessoas_id']);

        return $data;
    }

    /**
     * @param Request $request
     */
    public function findWhereReserva(Request $request)
    {
        $pessoaId = $request->request->get('id_pessoa');

        $data = $this->service->findWhere(['pessoas_id' => $pessoaId]);

        return $data;
    }

    /**
     * @param Request $request
     */
    public function deleteReserva($id, $id2)
    {
        $data = $this->service->deleteReserva($id, $id2);

        $result = $data;

        return array();
    }

    /**
     * @param Request $request
     */
    public function confirmarReserva(Request $request)
    {
        $id = $request->get('id_emp');
        $user = \Auth::user();

        $data = $this->service->find($id);
        $data->status = '1';
        $data->users_id = $user->id;
        $data->save();

       return redirect()->back();
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

        #Criando a consulta
        $rows = Reserva::join('pessoas', 'pessoas.id', '=', 'bib_reservas.pessoas_id')
            ->with(['reservaExemplar'])
            ->select([
                'bib_reservas.codigo',
                'bib_reservas.id as id',
                'bib_reservas.*',
                'pessoas.nome',
                \DB::raw('DATE_FORMAT(bib_reservas.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(bib_reservas.data_vencimento,"%d/%m/%Y") as data_vencimento'),
                ]);

        //dd($rows[0]->reservaExemplar[0]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = "";
            //if(!$row->data_devolucao_real) {
                $html .= '<div class="fixed-action-btn horizontal">
                      <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                       <ul>
                       <li><a class="btn-floating excluir" href="" title="Devolver"><i class="material-icons">delete</i></a></li>';
                //if($row->tipo_emprestimo == '1' && strtotime($row->data_devolucao) > strtotime($this->data)) {
                    $html .= '<li><a class="btn-floating renovar" href="" title="Renovar"><i class="material-icons">edit</i></a></li>
                </ul>
                </div>';
               // }
            //}

            # Retorno
            return $html;
        })->addColumn('acervo', function ($row) {

            $rows = Reserva::with(['reservaExemplar.exemplares'])
                ->where('bib_reservas.id', '=', $row->id)
                ->select([
                    'bib_reservas.id',
                ])->first();

            $qtdExemplarAll = 0;

            for ($i = 0; $i < count($rows->reservaExemplar); $i++) {
                for($j = 0; $j < count($rows->reservaExemplar[$i]->exemplares); $j++){

                    if(($rows->reservaExemplar[$i]->exemplares[$j]->edicao == $rows->reservaExemplar[$i]->pivot->edicao || $rows->reservaExemplar[$i]->exemplares[$j]->edicao == "")
                        && $rows->reservaExemplar[$i]->exemplares[$j]->situacao_id == '1' ||
                        ($rows->reservaExemplar[$i]->exemplares[$j]->situacao_id == '3' && $rows->reservaExemplar[$i]->exemplares[$j]->exemp_principal == '0')){
                        $qtdExemplarAll++;
                    }

                }
            }

//dd($qtdExemplarAll);
            //dd(count($rows->reservaExemplar[0]->exemplares->toArray()));

            return $qtdExemplarAll;
        })->make(true);
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function saveEmprestimo(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            //dd($data);

            if(!isset($data['id'])){
                return redirect()->back()->with("error", "É preciso informar pelo menos um acervo!");
            }

           // dd($data);

            #Executando a ação
            $this->service->saveEmprestimo($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Emprestimo realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

}

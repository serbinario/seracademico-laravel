<?php

namespace Seracademico\Http\Controllers\HelpDesk;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\HelpDesk\ChamadoRepository;
use Yajra\Datatables\Datatables;

class ChamadosController extends Controller
{
    /**
     * @var ChamadoRepository
     */
    private $repository;

    /**
     * ChamadosController constructor.
     * @param ChamadoRepository $repository
     */
    public function __construct(ChamadoRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('helpdesk.chamados.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('hp_chamados')
            ->join('users', 'users.id', '=', 'hp_chamados.user_id')
            ->select([
                'hp_chamados.id',
                'hp_chamados.titulo',
                'hp_chamados.descricao',
                'hp_chamados.status',
                'hp_chamados.prioridade',
                \DB::raw('DATE_FORMAT(hp_chamados.created_at, \'%d/%m/%Y\') as data')
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('action', function ($row) {
                $html =  '<div class="fixed-action-btn horizontal">
                            <a class="btn-floating btn-main"><i class="large material-icons">dehaze</i></a>
                            <ul>
                                <li><a class="btn-floating indigo" href="edit/'.$row->id.'" title="Editar chamado"><i class="material-icons">edit</i></a></li>
                                <li><a class="btn-floating indigo" href="destroy/'.$row->id.'" title="Remover chamado"><i class="material-icons">delete</i></a></li>
                                <li><a class="btn-floating indigo" href="javascript:void(0)" id="btnModalRespostas" title="Respostas"><i class="material-icons">call_missed</i></a></li>
                            </ul>
                         </div>';

                return $html;
            })
            ->addColumn('label_prioridade', function ($row) {
                switch ($row->prioridade) {
                    case 'N' : return 'Normal';
                    case 'M' : return 'Moderada';
                    case 'U' : return 'Urgente';
                }
            })
            ->addColumn('label_status', function ($row) {
                switch ($row->status) {
                    case 'N' : return 'Nova';
                    case 'D' : return 'Em desenvolvimento';
                    case 'C' : return 'Concluída';
                }
            })
        ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('helpdesk.chamados.create');
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $dados = $request->all();
            $dados['user_id'] = \Auth::user()->id;
            $dados['status'] = 'N';

            $this->repository->create($dados);

            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $model = $this->repository->find($id);

            #retorno para view
            return view('helpdesk.chamados.edit', compact('model'));
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $chamado = $this->repository->find($id);

            if (count($chamado->respostas) > 0) {
                $chamado->respostas->each(function ($resposta) {
                    $resposta->delete();
                });
            }

            $this->repository->delete($id);

            return redirect()->back()->with("message", "Exclusão realizada com sucesso!");
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
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
            $data = $request->all();

            $this->repository->update($data, $id);

            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }

}

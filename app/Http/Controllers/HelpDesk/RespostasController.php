<?php

namespace Seracademico\Http\Controllers\HelpDesk;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\HelpDesk\RespostaRepository;
use Yajra\Datatables\Datatables;

class RespostasController extends Controller
{
    /**
     * @var RespostaRepository
     */
    private $repository;

    /**
     * RespostasController constructor.
     * @param RespostaRepository $repository
     */
    public function __construct(RespostaRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param $idChamado
     * @return mixed
     */
    public function grid($idChamado)
    {
        $rows = \DB::table('hp_respostas')
            ->join('users', 'users.id', '=', 'hp_respostas.user_id')
            ->where('hp_respostas.chamado_id', $idChamado)
            ->select([
                'hp_respostas.id',
                'hp_respostas.descricao',
                'hp_respostas.status',
                'users.name',
                \DB::raw('DATE_FORMAT(hp_respostas.created_at, \'%d/%m/%Y\') as data')
            ]);

        return Datatables::of($rows)
            ->addColumn('action', function ($row) {
                $html = '<a href="javascript:void(0)" id="btnDestroyResposta" 
                            title="Excluir" class="btn"><i class="material-icons">delete</i></a>';
                return $html;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['user_id'] = \Auth::user()->id;

            $resposta = $this->repository->create($data);
            $chamado = $resposta->chamado;
            $chamado->status = $resposta->status;
            $chamado->save();

            return response()->json(['success' => true,'msg' => "Resposta cadastrada com sucesso"]);
        }  catch (\Throwable $e) {
            return response()->json(['success' => false,'msg' => $e->getMessage()]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);

            return response()->json(['success' => true, 'msg' => 'Resposta removida com sucesso']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}

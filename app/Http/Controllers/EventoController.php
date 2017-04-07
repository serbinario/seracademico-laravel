<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\EventoService;
use Yajra\Datatables\Datatables;

class EventoController extends Controller
{
    /**
     * @var EventoService
     */
    private $service;

    /**
     * @param EventoService $service
     */
    public function __construct(EventoService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateEvento(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            /*#Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);*/

            #Executando a ação
            $this->service->store($data);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    public function storeEvento(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            /*#Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);*/

            #Executando a ação
            $this->service->store($data);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function selectTipoEvento()
    {
        try {
            $selectTipoEvento = \DB::table('tipo_evento')
                ->select('tipo_evento.id',
                    'tipo_evento.nome')
                ->get();

            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $selectTipoEvento]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function selectDiaLetivo()
    {
        try {
            $selectDiaLetivo = \DB::table('dia_letivo')
                ->select('dia_letivo.id',
                    'dia_letivo.nome')
                ->get();

            return \Illuminate\Support\Facades\Response::json(['success' => true, 'dados' => $selectDiaLetivo]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function gridEvento()
    {
        try {
        #Criando a consulta
        $rows = \DB::table('feriados_eventos')
            ->join('dia_letivo', 'dia_letivo.id', '=', 'feriados_eventos.dia_letivo_id')
            ->join('tipo_evento', 'tipo_evento.id', '=', 'feriados_eventos.tipo_evento_id')
            ->select([
                'feriados_eventos.id as id',
                'feriados_eventos.nome as nome',
                \DB::raw('DATE_FORMAT(feriados_eventos.data_feriado,"%d/%m/%Y") as data_feriado'),
                'feriados_eventos.dia_semana',
                'dia_letivo.nome as dia_letivo',
                'dia_letivo.id as dia_letivo_id',
                'tipo_evento.nome as tipo_evento',
                'tipo_evento.id as tipo_evento_id',
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = '<a title="Remover" id="deleteEvento" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i></a>';

            # Retorno
            return $html;
        })->make(true);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function removerEvento($id)
    {
        try {
            #Executando a ação
            $this->service->destroy($id);

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}

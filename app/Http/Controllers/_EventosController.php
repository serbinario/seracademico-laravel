<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Repositories\EventoRepository;
use Seracademico\Validators\EventoValidator;
use Seracademico\Services\EventoService;
use Yajra\Datatables\Datatables;
use Seracademico\Uteis\SerbinarioDateFormat;


class _EventosController extends Controller
{
    /**
     * @var EventoRepository
     */
    protected $repository;

    /**
     * @var EventoService
     */
    private $service;

    /**
     * @var EventoValidator
     */
    protected $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'CalendarioStatus',
        'CalendarioDuracao'
    ];

    /**
     * EventosController constructor.
     * @param EventoRepository $repository
     * @param EventoService $service
     * @param EventoValidator $validator
     */
    public function __construct(EventoRepository $repository,
                                EventoService $service,
                                EventoValidator $validator)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function grid($id)
    {
        #Criando a consulta
        $rows = \DB::table('feriados_eventos')
            ->join('dia_letivo', 'dia_letivo.id', '=', 'feriados_eventos.dia_letivo_id')
            ->join('tipo_evento', 'tipo_evento.id', '=', 'feriados_eventos.tipo_evento_id')
            ->join('calendarios', 'calendarios.id', '=', 'feriados_eventos.calendarios_id')
            ->where('feriados_eventos.calendarios_id', '=', $id)
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
            $html = '<a style="margin-right: 5%;" title="Editar" id="editarEvento" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>';
            $html .= '<a title="Remover" id="deleteEvento" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-remove"></i></a>';

            # Retorno
            return $html;
        })->make(true);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
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

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
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

            # Retorno
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDiaLetivo(Request $request)
    {

        $dias = \DB::table('dia_letivo')
            ->select('dia_letivo.id', 'dia_letivo.nome')
            ->get();

        return response()->json($dias);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDiaSemana(Request $request)
    {

        # Valida se o campo data existe
        if($request->has('data') && $request->get('data') != "") {

            $dia_semana = "";
            
            // Pega a data requisitada
            $dia = $request->get('data');

            $diaa = substr($dia,0,2);

            $mes = substr($dia,3,2);

            $ano = substr($dia,6,4);

            // Recupera o dia da semana
            $diasemana = date("w", mktime(0,0,0,$mes,$diaa,$ano) );

            switch($diasemana) {

                case"0": $dia_semana = "DOMINGO"; break;

                case"1": $dia_semana = "SEGUNDA"; break;

                case"2": $dia_semana = "TERÇA"; break;

                case"3": $dia_semana = "QUARTA"; break;

                case"4": $dia_semana = "QUINTA"; break;

                case"5": $dia_semana = "SEXTA"; break;

                case"6": $dia_semana = "SÁBADO"; break;

            }

            $retorno = $dia_semana;
            
        } else {
            $retorno = "";
        }
        
        return response()->json($retorno);

    }
}

<?php

namespace Seracademico\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\Tecnico\CurriculoService;
use Seracademico\Uteis\SerbinarioDateFormat;

class RelatorioController extends Controller
{
    /**
     * @var CurriculoService
     */
    private $service;

    /**
     * @var array
     */
    private $loadFields = [
        'Tecnico\\Curso|ativo,1',
    ];

    /**
     * @param CurriculoService $service
     */
    public function __construct(CurriculoService $service)
    {
        $this->service   = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexModulosDisciplinas()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('reports.tecnico.views.modulos_disciplinas', compact('loadFields'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modulosDisciplinas(Request $request)
    {

        $modulos = \DB::table('fac_curriculo_disciplina')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('tec_modulos', 'tec_modulos.id', '=', 'fac_curriculo_disciplina.modulo_id')
            ->groupBy('tec_modulos.id', 'tec_modulos.nome')
            ->where('fac_cursos.id', $request->get('curso'))
            ->select([
                'tec_modulos.id',
                'tec_modulos.nome',
                'fac_cursos.nome as curso',
            ])->get();

        foreach ($modulos as $chave => $modulo) {

            $disciplinas = \DB::table('fac_curriculo_disciplina')
                ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_curriculo_disciplina.curriculo_id')
                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
                ->join('tec_modulos', 'tec_modulos.id', '=', 'fac_curriculo_disciplina.modulo_id')
                ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_curriculo_disciplina.disciplina_id')
                ->join('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
                ->where('tec_modulos.id', $modulo->id)
                ->select([
                    'fac_disciplinas.id',
                    'fac_disciplinas.nome',
                    'fac_disciplinas.carga_horaria',
                    'fac_disciplinas.qtd_falta',
                    'fac_tipo_disciplinas.nome as tipo_disciplina',
                ])->get();

            $arrayTemp = (array) $modulos[$chave];
            $modulos[$chave] = (object) array_merge($arrayTemp, ['disciplinas' => $disciplinas]);
        }

        return \PDF::loadView('reports.tecnico.reports.modulos_disciplinas',
            compact('modulos'))->setOrientation('landscape')->stream();
    }

}

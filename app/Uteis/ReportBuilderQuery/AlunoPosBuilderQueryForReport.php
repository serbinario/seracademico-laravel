<?php
namespace Seracademico\Uteis\ReportBuilderQuery;
use Seracademico\Contracts\ReportAluno;

/**
 * Created by PhpStorm.
 * User: AndreyPriscila
 * Date: 29/09/2016
 * Time: 10:09
 */
class AlunoPosBuilderQueryForReport implements ReportAluno
{
    /**
     * @var \DB
     */
    private $query;

    /**
     * AlunoPosBuilderQueryForReport constructor.
     */
    public function __construct()
    {
        $this->query = \DB::table('pos_alunos')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
            ->leftJoin('enderecos', 'enderecos.id', '=', 'pessoas.enderecos_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'enderecos.bairros_id')
            ->leftJoin('cidades', 'cidades.id', '=', 'bairros.cidades_id')
            ->leftJoin('estados', 'estados.id', '=', 'cidades.estados_id');
    }

    /**
     * @return mixed
     */
    private function getQuery()
    {
        return $this->query;
    }

    /**
     * Método Responsável por retorna uma query compátivel
     * com relatórios geráis do aluno de pós-graduação.
     *
     * @return mixed
     */
    public function getBuilderGeral()
    {
        # Retorno da query
        return $this->getQuery()
            ->leftJoin('pos_alunos_cursos', 'pos_alunos_cursos.aluno_id', '=', 'pos_alunos.id')
            ->leftJoin('pos_alunos_turmas', 'pos_alunos_turmas.aluno_id', '=', 'pos_alunos.id')
            ->leftJoin('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id');
    }
}
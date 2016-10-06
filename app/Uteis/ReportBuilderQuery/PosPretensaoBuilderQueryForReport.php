<?php
namespace Seracademico\Uteis\ReportBuilderQuery;
use Seracademico\Contracts\ReportPretensao;

/**
 * Created by PhpStorm.
 * User: AndreyPriscila
 * Date: 29/09/2016
 * Time: 10:09
 */
class PosPretensaoBuilderQueryForReport implements ReportPretensao
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
            ->leftJoin('fac_cursos as pretensao1', 'pretensao1.id', '=', 'pos_alunos.curso_pretendido_1_id')
            ->leftJoin('fac_cursos as pretensao2', 'pretensao2.id', '=', 'pos_alunos.curso_pretendido_2_id')
            ->leftJoin('fac_cursos as pretensao3', 'pretensao3.id', '=', 'pos_alunos.curso_pretendido_3_id')
            ->join('pos_tipos_pretensoes', 'pos_tipos_pretensoes.id', '=', 'pos_alunos.tipo_pretensao_id');
    }
}
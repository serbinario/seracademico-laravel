<?php
/**
 * Created by PhpStorm.
 * User: AndreyPriscila
 * Date: 19/09/2016
 * Time: 09:24
 */

namespace Seracademico\Uteis\ConsultationsBuilders\Aluno\PosGraduacao;


class BuildersUniosCurriculo
{
    /**
     * Método que retorna a query builder para union de disciplinas a cursar
     * do currículo do aluno
     *
     * @param $idAluno
     * @return mixed
     */
    public static function getExtraCurricularACursar($idAluno)
    {
        # Retorno
         return \DB::table('pos_alunos')
            ->join('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join('pos_alunos_extras', 'pos_alunos_extras.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_extras.disciplina_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'pos_alunos_extras.curriculo_id')
             ->join('pos_alunos_turmas', function ($join) {
                 $join->on(
                     'pos_alunos_turmas.id', '=',
                     \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                 );
             })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->groupBy('fac_disciplinas.id')
            ->where('pos_alunos.id', $idAluno)
            ->select([
                'pos_alunos_cursos.id',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_turmas.codigo as turma_codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_credito'
            ]);
    }

    /**
     * Método que retorna a query builder para union de disciplinas a cursar
     * do currículo do aluno
     *
     * @param $idAluno
     * @return mixed
     */
    public static function getEquivalenciasACursar($idAluno)
    {
        # Retorno
        return  \DB::table('pos_alunos')
            ->join('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join('pos_alunos_turmas', function ($join) {
                $join->on(
                    'pos_alunos_turmas.id', '=',
                    \DB::raw('(SELECT turma_atual.id FROM pos_alunos_turmas as turma_atual
                        where turma_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY turma_atual.id DESC LIMIT 1)')
                );
            })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->join('pos_alunos_equivalencias', 'pos_alunos_equivalencias.pos_aluno_curso_id', '=', 'pos_alunos_cursos.id')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'pos_alunos_equivalencias.disciplina_equivalente_id')
            ->groupBy('fac_disciplinas.id')
            ->where('pos_alunos.id', $idAluno)
            ->select([
                'pos_alunos_cursos.id',
                'fac_disciplinas.nome as disciplina_nome',
                'fac_disciplinas.codigo as disciplina_codigo',
                'fac_turmas.codigo as turma_codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_credito'
            ]);

    }
}
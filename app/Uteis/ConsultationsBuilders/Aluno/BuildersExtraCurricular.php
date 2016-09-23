<?php
/**
 * Created by PhpStorm.
 * User: AndreyPriscila
 * Date: 19/09/2016
 * Time: 09:24
 */

namespace Seracademico\Uteis\ConsultationsBuilders\Aluno;


class BuildersExtraCurricular
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
        return \DB::table('fac_alunos_semestres_disciplinas_extras')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_disciplinas_extras.disciplina_id')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_semestres_disciplinas_extras.curriculo_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->leftJoin('fac_disciplinas as pre1', 'pre1.id', '=', 'fac_curriculo_disciplina.pre_requisito_1_id')
            ->leftJoin('fac_disciplinas as pre2', 'pre2.id', '=', 'fac_curriculo_disciplina.pre_requisito_2_id')
            ->leftJoin('fac_disciplinas as co1', 'co1.id', '=', 'fac_curriculo_disciplina.co_requisito_1_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_extras.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_alunos_cursos', function ($join) use ($idAluno) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw("(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual
                    where curso_atual.aluno_id = fac_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)")
                );
            })
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_notas')
                    ->distinct()
                    ->select('fac_disciplinas.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7,10]) // Situação de cumprimento da disciplina
                    ->where('fac_alunos.id', $idAluno);
            })
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_disciplinas.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso',
                \DB::raw('IF(pre1.codigo != "", pre1.codigo, "Não Informado") as pre1Codigo'),
                \DB::raw('IF(pre2.codigo != "", pre1.codigo, "Não Informado") as pre2Codigo'),
                \DB::raw('IF(co1.codigo  != "", pre1.codigo, "Não Informado") as co1Codigo')
            ]);
    }

    /**
     * Método que retorna a query builder para union de disciplinas cursando
     * do currículo do aluno
     *
     * @param $idAluno
     * @return mixed
     */
    public static function getExtraCurricularCursando($idAluno) {
        # Retorno
        return \DB::table('fac_alunos_semestres_disciplinas_extras')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_disciplinas_extras.disciplina_id')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_semestres_disciplinas_extras.curriculo_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->leftJoin('fac_disciplinas as pre1', 'pre1.id', '=', 'fac_curriculo_disciplina.pre_requisito_1_id')
            ->leftJoin('fac_disciplinas as pre2', 'pre2.id', '=', 'fac_curriculo_disciplina.pre_requisito_2_id')
            ->leftJoin('fac_disciplinas as co1', 'co1.id', '=', 'fac_curriculo_disciplina.co_requisito_1_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_extras.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_alunos_cursos', function ($join) use ($idAluno) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw("(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual
                    where curso_atual.aluno_id = fac_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)")
                );
            })
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_alunos_notas', function ($join) {
                $join->on('fac_alunos_notas.aluno_semestre_id', '=', 'fac_alunos_semestres.id')
                    ->on('fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_notas.turma_id')
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereIn('fac_situacao_nota.id', [10]) // Situação de cumprimento da disciplina
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_disciplinas.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso',
                'fac_turmas.codigo as codigoTurma',
                'fac_situacao_nota.nome as nomeSituacao',
                \DB::raw('IF(fac_alunos_notas.nota_unidade_1 != "", fac_alunos_notas.nota_unidade_1 != "", 0.0) as nota_unidade_1'),
                \DB::raw('IF(fac_alunos_notas.nota_unidade_2 != "", fac_alunos_notas.nota_unidade_2 != "", 0.0) as nota_unidade_2'),
                \DB::raw('IF(fac_alunos_notas.nota_2_chamada != "", fac_alunos_notas.nota_2_chamada != "", 0.0) as nota_2_chamada'),
                \DB::raw('IF(fac_alunos_notas.nota_final != "", fac_alunos_notas.nota_final != "", 0.0) as nota_final'),
                \DB::raw('IF(fac_alunos_notas.nota_media != "", fac_alunos_notas.nota_media != "", 0.0) as nota_media')
            ]);
    }

    /**
     * Método que retorna a query builder para union de disciplinas em matricular
     * disciplinas do aluno
     *
     * @param $idAluno
     * @return mixed
     */
    public static function getExtraCurricularMatricular($idAluno) {
        # Retorno
        return \DB::table('fac_alunos_semestres_disciplinas_extras')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_disciplinas_extras.disciplina_id')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_semestres_disciplinas_extras.curriculo_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_disciplinas_extras.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_alunos_cursos', function ($join) use ($idAluno) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw("(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual
                    where curso_atual.aluno_id = fac_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)")
                );
            })
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_notas')
                    ->distinct()
                    ->select('fac_disciplinas.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7,10]) // Situação de cumprimento da disciplina
                    ->where('fac_alunos.id', $idAluno);
            })
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'fac_disciplinas.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso'
            ]);
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public static function getEletivasACursar($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_semestres_eletivas')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_eletivas.disciplina_eletiva_id')
            ->join('fac_disciplinas as eletiva', 'eletiva.id', '=', 'fac_alunos_semestres_eletivas.disciplina_id')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_semestres_eletivas.turma_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->leftJoin('fac_disciplinas as pre1', 'pre1.id', '=', 'fac_curriculo_disciplina.pre_requisito_1_id')
            ->leftJoin('fac_disciplinas as pre2', 'pre2.id', '=', 'fac_curriculo_disciplina.pre_requisito_2_id')
            ->leftJoin('fac_disciplinas as co1', 'co1.id', '=', 'fac_curriculo_disciplina.co_requisito_1_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_eletivas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_notas')
                    ->distinct()
                    ->select('fac_disciplinas.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7,10]) // Situação de cumprimento da disciplina
                    ->where('fac_alunos.id', $idAluno);
            })
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'eletiva.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_disciplinas.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso',
                \DB::raw('IF(pre1.codigo != "", pre1.codigo, "Não Informado") as pre1Codigo'),
                \DB::raw('IF(pre2.codigo != "", pre1.codigo, "Não Informado") as pre2Codigo'),
                \DB::raw('IF(co1.codigo  != "", pre1.codigo, "Não Informado") as co1Codigo')
            ]);

        return $rows;
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public static function getEletivasCursando($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_semestres_eletivas')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_eletivas.disciplina_eletiva_id')
            ->join('fac_disciplinas as eletiva', 'eletiva.id', '=', 'fac_alunos_semestres_eletivas.disciplina_id')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_semestres_eletivas.turma_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_eletivas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('fac_alunos_notas', function ($join) {
                $join->on('fac_alunos_notas.aluno_semestre_id', '=', 'fac_alunos_semestres.id')
                    ->on('fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereIn('fac_situacao_nota.id', [10]) // Situação de cumprimento da disciplina
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'eletiva.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_disciplinas.qtd_credito',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso',
                'fac_turmas.codigo as codigoTurma',
                'fac_situacao_nota.nome as nomeSituacao',
                \DB::raw('IF(fac_alunos_notas.nota_unidade_1 != "", fac_alunos_notas.nota_unidade_1 != "", 0.0) as nota_unidade_1'),
                \DB::raw('IF(fac_alunos_notas.nota_unidade_2 != "", fac_alunos_notas.nota_unidade_2 != "", 0.0) as nota_unidade_2'),
                \DB::raw('IF(fac_alunos_notas.nota_2_chamada != "", fac_alunos_notas.nota_2_chamada != "", 0.0) as nota_2_chamada'),
                \DB::raw('IF(fac_alunos_notas.nota_final != "", fac_alunos_notas.nota_final != "", 0.0) as nota_final'),
                \DB::raw('IF(fac_alunos_notas.nota_media != "", fac_alunos_notas.nota_media != "", 0.0) as nota_media')
            ]);

        return $rows;
    }

    /**
     * @param $idAluno
     * @return mixed
     */
    public static function getEletivasMatricula($idAluno)
    {
        #Criando a consulta
        $rows = \DB::table('fac_alunos_semestres_eletivas')
            ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_semestres_eletivas.disciplina_eletiva_id')
            ->join('fac_disciplinas as eletiva', 'eletiva.id', '=', 'fac_alunos_semestres_eletivas.disciplina_id')
            ->leftjoin('fac_tipo_disciplinas', 'fac_disciplinas.tipo_disciplina_id', '=', 'fac_tipo_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_alunos_semestres_eletivas.turma_id')
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_turmas.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_curriculo_disciplina', function ($join) {
                $join->on('fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
                    ->on('fac_curriculo_disciplina.disciplina_id', '=', 'fac_disciplinas.id');
            })
            ->leftJoin('fac_disciplinas as pre1', 'pre1.id', '=', 'fac_curriculo_disciplina.pre_requisito_1_id')
            ->leftJoin('fac_disciplinas as pre2', 'pre2.id', '=', 'fac_curriculo_disciplina.pre_requisito_2_id')
            ->leftJoin('fac_disciplinas as co1', 'co1.id', '=', 'fac_curriculo_disciplina.co_requisito_1_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_semestres_eletivas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->whereNotIn('fac_disciplinas.id', function ($query) use ($idAluno) {
                $query->from('fac_alunos_notas')
                    ->distinct()
                    ->select('fac_disciplinas.id')
                    ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
                    ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
                    ->join('fac_disciplinas', 'fac_disciplinas.id', '=', 'fac_alunos_notas.disciplina_id')
                    ->join('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
                    ->whereIn('fac_situacao_nota.id', [1,6,7,10]) // Situação de cumprimento da disciplina
                    ->where('fac_alunos.id', $idAluno);
            })
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_disciplinas.id',
                'fac_disciplinas.nome',
                'eletiva.codigo',
                'fac_disciplinas.carga_horaria',
                'fac_disciplinas.qtd_falta',
                'fac_curriculo_disciplina.periodo',
                'fac_tipo_disciplinas.nome as tipo_disciplina',
                'pessoas.nome as nomeAluno',
                'fac_cursos.nome as nomeCurso'
            ]);

        return $rows;
    }

}
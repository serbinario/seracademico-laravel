<?php

namespace Seracademico\Uteis;


class RelatorioCadernetaFrequencia
{
    private $visao = "viewPosCadernetaFrequencia";

    public function obtemDados(array $dadosDaRequisicao) : array
    {
        $alunos = $this->obtemAlunos($dadosDaRequisicao);
        $outrosDados = $this->obtemCursoTurmaDisciplinaProfessor($dadosDaRequisicao);

        return [
            "view" => $this->visao,
            "alunos" => $alunos,
            "cursoTurmaDisciplinaProfessor" => $outrosDados
        ];
    }

    private function obtemCursoTurmaDisciplinaProfessor($dadosDaRequisicao)
    {
        return \DB::table("fac_calendarios")
            ->join("fac_turmas_disciplinas", "fac_turmas_disciplinas.id", "=", "fac_calendarios.turma_disciplina_id")
            ->join('fac_turmas', 'fac_turmas.id', '=', 'fac_turmas_disciplinas.turma_id')
            ->join("fac_disciplinas", "fac_disciplinas.id", "=", "fac_turmas_disciplinas.disciplina_id")
            ->join("fac_curriculos", "fac_curriculos.id", "=", "fac_turmas.curriculo_id")
            ->join("fac_cursos", "fac_cursos.id", "=", "fac_curriculos.curso_id")
            ->join("fac_curriculo_disciplina", function ($join) {
                $join->on("fac_curriculo_disciplina.curriculo_id", "=", "fac_curriculos.id")
                    ->on("fac_curriculo_disciplina.disciplina_id", "=", "fac_disciplinas.id");
            })
            ->join("fac_professores", "fac_professores.id", "=", "fac_calendarios.professor_id")
            ->join("pessoas", "pessoas.id", "=", "fac_professores.pessoa_id")
            ->join('grau_instrucoes', 'pessoas.grau_instrucoes_id', '=', 'grau_instrucoes.id')
            ->where("fac_disciplinas.id", $dadosDaRequisicao["disciplina"])
            ->where("fac_turmas.id", $dadosDaRequisicao["turma"])
            ->select([
                "pessoas.nome as nomeProfessor",
                "fac_turmas.codigo as codigoTurma",
                "fac_disciplinas.nome as nomeDisciplina",
                \DB::raw("IF(fac_curriculo_disciplina.carga_horaria_total != null,
                    fac_curriculo_disciplina.carga_horaria_total, fac_disciplinas.carga_horaria) as cargaHoraria"),
                "grau_instrucoes.nome as nomeTitulacao",
                "fac_cursos.nome as nomeCurso"
            ])
            ->get();
    }

    private function obtemAlunos($dadosDaRequisicao)
    {
        return \DB::table('pos_alunos')
            ->join('pessoas', 'pessoas.id', '=', 'pos_alunos.pessoa_id')
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
            ->join('pos_alunos_situacoes', function ($join) {
                $join->on(
                    'pos_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                       where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                );
            })
            ->join('fac_turmas', 'fac_turmas.id', '=', 'pos_alunos_turmas.turma_id')
            ->join("fac_turmas_disciplinas", "fac_turmas_disciplinas.turma_id", "=", "fac_turmas.id")
            ->join("fac_disciplinas", "fac_disciplinas.id", "=", "fac_turmas_disciplinas.disciplina_id")
            ->where("fac_disciplinas.id", $dadosDaRequisicao["disciplina"])
            ->where("fac_turmas.id", $dadosDaRequisicao["turma"])
            ->orderBy("pessoas.nome", "desc")
            ->select([
                "pessoas.nome"
            ])
            ->get();
    }
}
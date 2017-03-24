<?php

namespace Seracademico\Services\Graduacao\Documento;

trait DocumentoTrait
{
    /**
     * @param $idAluno
     * @return mixed
     *
     * Método que retorna todos os dados gerais do aluno
     * como informações pessoais, curso e currículo ativo,
     * semetre, período.
     */
    private function obtemDadosDoAluno($idAluno)
    {
        # Retorno o resultado da consulta
        return \DB::table('fac_alunos')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->join('fac_alunos_cursos', function ($join) {
                $join->on(
                    'fac_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM fac_alunos_cursos as curso_atual 
                       where curso_atual.aluno_id = fac_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join('fac_curriculos', 'fac_curriculos.id', '=', 'fac_alunos_cursos.curriculo_id')
            ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_curriculos.curso_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.aluno_id', '=', 'fac_alunos.id')
            ->join('fac_semestres', 'fac_semestres.id', '=', 'fac_alunos_semestres.semestre_id')
            ->join('fac_alunos_situacoes', function ($join) {
                $join->on(
                    'fac_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_secundaria.id FROM fac_alunos_situacoes as situacao_secundaria 
                         where situacao_secundaria.aluno_semestre_id = fac_alunos_semestres.id ORDER BY situacao_secundaria.id DESC LIMIT 1)')
                );
            })
            ->join('fac_situacao', 'fac_situacao.id', '=', 'fac_alunos_situacoes.situacao_id')
            ->where('fac_alunos.id', $idAluno)
            ->select([
                'fac_alunos.id',
                'pessoas.nome',
                \DB::raw('if(pessoas.cpf != null AND pessoas.cpf != "", CONCAT(SUBSTR(pessoas.cpf,1,3), ".",
                         SUBSTR(pessoas.cpf,4,3), ".", SUBSTR(pessoas.cpf,7,3), "-", SUBSTR(pessoas.cpf,10,2)), pessoas.cpf) AS cpf'),
                'fac_alunos.matricula',
                'pessoas.identidade',
                'pessoas.cpf',
                'fac_semestres.nome as semestre',
                'fac_alunos_semestres.periodo',
                'fac_curriculos.codigo as codigoCurriculo',
                'fac_curriculos.nome as nomeDoCurriculo',
                'fac_situacao.nome as nomeSituacao',
                'fac_cursos.codigo as codigoCurso',
                'fac_cursos.nome as nomeDoCurso'
            ])
            ->first();
    }
}
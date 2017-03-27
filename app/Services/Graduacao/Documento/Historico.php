<?php

namespace Seracademico\Services\Graduacao\Documento;

class Historico implements DocumentoInterface
{
    use DocumentoTrait;

    public function processaDocumento(int $idDoAluno, array $paremetros)
    {
        $dadosDoAluno  = $this->obtemDadosDoAluno($idDoAluno);
        $dadosDasNotas = $this->obtemDadosDasNotasDoAluno($idDoAluno);

        if(count($dadosDoAluno) == 0 || !$dadosDoAluno) {
            throw new \Exception('Dados do aluno não encontrado');
        }

        if(!is_array($dadosDasNotas)) {
            throw new \Exception('Dados das notas do aluno não foram encontrados');
        }

        $nomeDaView = 'reports.historico_graduacao';

        return compact('dadosDoAluno', 'dadosDasNotas', 'nomeDaView');
    }

    private function obtemDadosDasNotasDoAluno($idDoAluno)
    {
        return \DB::table('fac_disciplinas')
            ->join('fac_turmas_disciplinas', 'fac_turmas_disciplinas.disciplina_id', '=', 'fac_disciplinas.id')
            ->join('fac_turmas', 'fac_turmas_disciplinas.turma_id', '=', 'fac_turmas.id')
            ->join('fac_alunos_notas', function ($join) {
                $join->on('fac_alunos_notas.disciplina_id', '=', 'fac_disciplinas.id')
                    ->on('fac_alunos_notas.turma_id', '=', 'fac_turmas.id');
            })
            ->leftJoin('fac_situacao_nota', 'fac_situacao_nota.id', '=', 'fac_alunos_notas.situacao_id')
            ->join('fac_alunos_semestres', 'fac_alunos_semestres.id', '=', 'fac_alunos_notas.aluno_semestre_id')
            ->join('fac_alunos', 'fac_alunos.id', '=', 'fac_alunos_semestres.aluno_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_alunos.pessoa_id')
            ->where('fac_alunos.id', $idDoAluno)
            ->select([
                'fac_disciplinas.nome',
                'fac_alunos_notas.nota_unidade_1',
                'fac_alunos_notas.nota_unidade_2',
                'fac_alunos_notas.nota_2_chamada',
                'fac_alunos_notas.nota_final',
                'fac_alunos_notas.nota_media',
                'fac_situacao_nota.nome as nomeSituacao'
            ])
            ->get();
    }
}
<?php

namespace Seracademico\Repositories\PosGraduacao;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Pessoa;
use Seracademico\Entities\PosGraduacao\Aluno;

/**
 * Class AlunoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AlunoRepositoryEloquent extends BaseRepository implements AlunoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Aluno::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Método responsável por executar um consulta no banco de dados
     * usando o aluno passado como parâmetro, para verificar se existe
     * um outro cadastro com o mesmo curso ativo.
     *
     * @param $cursoId
     * @param $pessoa
     * @return bool
     */
    public function verificaCursoAtivoEmOutroCadastro($cursoId, $pessoa)
    {
        $alunos = \DB::table("pos_alunos")
            ->join("pessoas", "pessoas.id", "=", "pos_alunos.pessoa_id")
            ->join('pos_alunos_cursos', function ($join) {
                $join->on(
                    'pos_alunos_cursos.id', '=',
                    \DB::raw('(SELECT curso_atual.id FROM pos_alunos_cursos as curso_atual
                        where curso_atual.aluno_id = pos_alunos.id ORDER BY curso_atual.id DESC LIMIT 1)')
                );
            })
            ->join("fac_curriculos", "fac_curriculos.id", "=", "pos_alunos_cursos.curriculo_id")
            ->join("fac_cursos", "fac_cursos.id", "=", "fac_curriculos.curso_id")
            ->join('pos_alunos_situacoes', function ($join) {
                $join->on(
                    'pos_alunos_situacoes.id', '=',
                    \DB::raw('(SELECT situacao_atual.id FROM pos_alunos_situacoes as situacao_atual
                        where situacao_atual.pos_aluno_curso_id = pos_alunos_cursos.id ORDER BY situacao_atual.id DESC LIMIT 1)')
                );
            })
            ->where("pos_alunos.pessoa_id", $pessoa->id)
            ->where("fac_cursos.id", $cursoId)
            ->whereIn("pos_alunos_situacoes.situacao_id", [1, 2])
            ->get();

        return count($alunos) > 0;
    }
}

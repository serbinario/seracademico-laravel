<?php

namespace Seracademico\Repositories\Doutorado;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Doutorado\Professor;
use Seracademico\Repositories\Doutorado\ProfessorRepository;

/**
 * Class ProfessorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProfessorRepositoryEloquent extends BaseRepository implements ProfessorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Professor::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return mixed
     */
    public function getProfessores()
    {
        $professores = \DB::table('fac_professores')
            ->join('pessoas', 'pessoas.id', '=', 'fac_professores.pessoa_id')
            ->select([
                'fac_professores.id',
                'pessoas.nome'
            ])
            ->orderBy('pessoas.nome')
            ->where('fac_professores.tipo_nivel_sistema_id', 3)
            ->orWhere('fac_professores.tipo_nivel_sistema_id', 5)
            ->get();


        /*if (count($professores) == 0){
            throw new \Exception('Professores não encontrados.');
        }*/

        return $professores;
    }
}
<?php

namespace Seracademico\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\SedeValidator;
use Seracademico\Repositories\SedeRepository;
use Seracademico\Entities\Sede;

/**
 * Class SedeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SedeRepositoryEloquent extends BaseRepository implements SedeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sede::class;
    }

    /**
     * @return mixed
     */
    public function sedes()
    {
        $sedes = [];
        $query =\DB::table('sedes')
            ->select([
                'id',
                'nome'
            ])
            ->get();

        foreach ($query as $sede) {
            $sedes[$sede->id] = $sede->nome;
        }

        return $sedes;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

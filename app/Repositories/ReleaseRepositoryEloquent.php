<?php

namespace Seracademico\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\ReleaseRepository;
use Seracademico\Entities\Release;
use Seracademico\Validators\ReleaseValidator;

/**
 * Class ReleaseRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class ReleaseRepositoryEloquent extends BaseRepository implements ReleaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Release::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return array
     */
    public function desenvolvedores()
    {
        $desenvolvedores = [
            '' => 'Desenvolvedor'
        ];
        $query = \DB::table('desenvolvedores')
            ->select([
                'id',
                'nome'
            ])
            ->get();

        foreach ($query as $desenvolvedor) {
            $desenvolvedores[$desenvolvedor->id] = $desenvolvedor->nome;
        }

        return $desenvolvedores;
    }

    /**
     * @return array
     */
    public function tipoLancamento()
    {
        $releaseTypes = [
            '' => 'Selecione'
        ];
        $query = \DB::table('release_type')
            ->select([
                'id',
                'nome'
            ])
            ->get();

        foreach ($query as $type) {
            $releaseTypes[$type->id] = $type->nome;
        }

        return $releaseTypes;
    }
}

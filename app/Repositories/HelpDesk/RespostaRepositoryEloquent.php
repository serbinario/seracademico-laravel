<?php

namespace Seracademico\Repositories\HelpDesk;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\HelpDesk\RespostaRepository;
use Seracademico\Entities\HelpDesk\Resposta;
use Seracademico\Validators\HelpDesk\RespostaValidator;

/**
 * Class RespostaRepositoryEloquent
 * @package namespace Seracademico\Repositories\HelpDesk;
 */
class RespostaRepositoryEloquent extends BaseRepository implements RespostaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Resposta::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

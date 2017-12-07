<?php

namespace Seracademico\Repositories\Vestibular;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Vestibular\VestibularAgendamentoRepository;
use Seracademico\Entities\VestibularAgendamento;

/**
 * Class VestibularAgendamentoRepositoryEloquent
 * @package namespace Seracademico\Repositories;
 */
class VestibularAgendamentoRepositoryEloquent extends BaseRepository implements VestibularAgendamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VestibularAgendamento::class;
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
    public function buscarDatas()
    {
        $datas = [
            '' => 'Selecione uma data'
        ];

        $query = \DB::table('vest_agendamento')
            ->select([
                'id',
                \DB::raw('DATE_FORMAT(vest_agendamento.data, "%d/%m/%Y") as data'),
            ])
            ->get();

        foreach ($query as $data) {
            $datas[$data->id] = $data->data;
        }

        return $datas;
    }
}

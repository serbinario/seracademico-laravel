<?php

namespace Seracademico\Repositories\Graduacao;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Graduacao\Vestibulando;

/**
 * Class VestibulandoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class VestibulandoRepositoryEloquent extends BaseRepository implements VestibulandoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vestibulando::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $idVestibulando
     * @return mixed
     * @throws \Exception
     * @description verificando se existem documentos para o vestibulando em questão
     */
    public function dadosVestibulando($idVestibulando)
    {
        $documentos = DB::table('vest_documentos')
            ->select([
                'id',
                'path',
                'tipo_documento_id',
                'vestibulando_id',
                'confirmacao',
                'observacao'
            ])
            ->where('vestibulando_id', $idVestibulando)
            ->get();

        /*if(count(!$documentos) == 0) {
            throw new \Exception('Nenhum documento encontrado');
        }*/

        if(count($documentos) > 0) {
            return $documentos;
        }
    }
}

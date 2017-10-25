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
            ->join('vest_tipos_documentos', 'vest_tipos_documentos.id', '=', 'vest_documentos.tipo_documento_id')
            ->select([
                'vest_documentos.id',
                'vest_tipos_documentos.nome',
                'vest_documentos.confirmacao',
                'vest_documentos.path',
                'vest_tipos_documentos.descricao',
                'vest_documentos.observacao',
                'vest_documentos.vestibulando_id',
                'vest_documentos.tipo_documento_id',
                'vest_documentos.entregar_pessoalmente',
                'vest_documentos.documento_estado_id',
            ])
            ->where('vest_documentos.vestibulando_id', $idVestibulando)
            ->get();

        /*if(count(!$documentos) == 0) {
            throw new \Exception('Nenhum documento encontrado');
        }*/

        if(count($documentos) > 0) {
            return $documentos;
        }
    }
}

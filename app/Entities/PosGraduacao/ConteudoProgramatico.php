<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\PlanoEnsino;

class ConteudoProgramatico extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_conteudos_programaticos';

    protected $fillable = [ 
		'nome',
		'plano_ensino_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planoEnsino()
    {
        return $this->belongsTo(PlanoEnsino::class);
    }

    /**
     * @param $query
     * @param $idPlanoEnsino
     * @return mixed
     */
    public function scopeByPlanoEnsino($query, $idPlanoEnsino)
    {
        return $query->where('plano_ensino_id', $idPlanoEnsino);
    }

    /**
     * @param $query
     * @param $idPlanoAula
     * @return mixed
     */
    public function scopeByPlanoAula($query, $idPlanoAula, $idPlanoEnsino)
    {
        $query->where('plano_ensino_id', $idPlanoEnsino)
            ->whereNotIn('id', function ($query) use ($idPlanoAula) {
                $query->from('fac_planos_aulas')
                    ->join('fac_planos_aulas_conteudos_programaticos', 'fac_planos_aulas_conteudos_programaticos.plano_aula_id', '=', 'fac_planos_aulas.id')
                    ->join('fac_conteudos_programaticos', 'fac_conteudos_programaticos.id', '=', 'fac_planos_aulas_conteudos_programaticos.conteudo_programatico_id')
                    ->select('fac_conteudos_programaticos.id')
                    ->where('fac_planos_aulas.id', $idPlanoAula)->get();
            });
    }
}
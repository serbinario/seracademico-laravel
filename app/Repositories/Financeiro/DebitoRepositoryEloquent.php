<?php
namespace Seracademico\Repositories\Financeiro;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Entities\Financeiro\Debito;

/**
 * Class DebitoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DebitoRepositoryEloquent extends BaseRepository implements DebitoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Debito::class;
    }

    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * @param $debitanteId
     * @param $tipoDebitante
     * @return mixed
     */
    public function obtemConsultaDebitosPorDebitante($debitanteId, $tipoDebitante)
    {
        return $this->obtemConsultaDebitos()
            ->where('fin_debitos.debitante_id', $debitanteId)
            ->where('fin_debitos.debitante_type', $tipoDebitante);
    }


    /**
     * @return mixed
     */
    protected function obtemConsultaDebitos()
    {
        $model = new $this->model;

        return $model
            ->join('fin_taxas', 'fin_taxas.id', '=', 'fin_debitos.taxa_id')
            ->select([
                "fin_debitos.id",
                "fin_debitos.valor_debito",
                "fin_taxas.nome as nomeTaxa",
                "fin_taxas.valor as valorTaxa",
                "fin_debitos.data_vencimento",
                \DB::raw("IF(fin_debitos.pago = 1, 'Sim', 'Não') as status")
            ]);
    }
}

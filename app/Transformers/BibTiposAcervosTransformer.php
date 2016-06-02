<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BibTiposAcervos;

/**
 * Class BibTiposAcervosTransformer
 * @package namespace App\Transformers;
 */
class BibTiposAcervosTransformer extends TransformerAbstract
{

    /**
     * Transform the \BibTiposAcervos entity
     * @param \BibTiposAcervos $model
     *
     * @return array
     */
    public function transform(BibTiposAcervos $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

<?php
namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Carne extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_carnes';

    protected $fillable = [ 
		'gnet_carnet_id',
		'gnet_status',
		'gnet_cover_link',
		'gnet_link',
        'gnet_code'
	];
}
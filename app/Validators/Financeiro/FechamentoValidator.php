<?php

namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class FechamentoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

	protected $messages   = [];

	protected $attributes = [];


	protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'debito_id' =>  '' ,
			'valor_pago' =>  '' ,
			'data_fechamento' =>  '' ,
			'valor_juros' =>  '' ,
			'valor_tipo_juros' =>  '' ,
			'valor_multa' =>  '' ,
			'valor_tipo_multa' =>  '' ,
			'valor_desconto' =>  '' ,
			'valor_tipo_desconto' =>  '' ,
			'valor_acrescimo' =>  '' ,
			'valor_tipo_acrescimo' =>  '' ,
			'valor_descrecimo' =>  '' ,
			'valor_tipo_descrecimo' =>  '' ,
			'valor_total' =>  '' ,
			'forma_pagamento_id' =>  '' ,
			'local_pagamento_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'debito_id' =>  '' ,
			'valor_pago' =>  '' ,
			'data_fechamento' =>  '' ,
			'valor_juros' =>  '' ,
			'valor_tipo_juros' =>  '' ,
			'valor_multa' =>  '' ,
			'valor_tipo_multa' =>  '' ,
			'valor_desconto' =>  '' ,
			'valor_tipo_desconto' =>  '' ,
			'valor_acrescimo' =>  '' ,
			'valor_tipo_acrescimo' =>  '' ,
			'valor_descrecimo' =>  '' ,
			'valor_tipo_descrecimo' =>  '' ,
			'valor_total' =>  '' ,
			'forma_pagamento_id' =>  '' ,
			'local_pagamento_id' =>  '' ,

        ],
   ];

}

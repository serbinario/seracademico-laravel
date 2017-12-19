<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ExemplarMonoDiTeValidator extends LaravelValidator
{

	use TraitReplaceRulesValidator;

	protected $messages   = [];

	protected $attributes = [
		'img' => 'Foto',
		'numero_pag' =>  'Número de página' ,
		'arcevos_id' =>  'Acervo' ,
	];
	
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

			'img' => 'image|max:500',
			'numero_pag' =>  'required' ,
			'arcevos_id' =>  'required' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
			'img' => 'image|max:500',
			'numero_pag' =>  'required' ,
			'arcevos_id' =>  'required' ,
		],
   ];

}

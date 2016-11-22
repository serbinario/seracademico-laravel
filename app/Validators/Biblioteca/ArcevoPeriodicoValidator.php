<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ArcevoPeriodicoValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [
        'titulo' =>  'Titulo' ,
        'tipos_acervos_id' =>  'Tipo de acervo' ,
        'cdd' =>  'CDD' ,
    ];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'titulo' =>  'required' ,
            'tipos_acervos_id' =>  'required' ,
            'cdd' =>  'required' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            'titulo' =>  'required' ,
            'tipos_acervos_id' =>  'required' ,
            'cdd' =>  'required' ,
        ],
   ];

}

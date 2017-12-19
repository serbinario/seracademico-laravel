<?php

namespace Seracademico\Validators\Biblioteca;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ArcevoMonoDiTeValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [
        'titulo' =>  'Titulo' ,
        'cutter' =>  'Cutter' ,
        'tipos_acervos_id' =>  'Tipo de acervo' ,
        'assunto' =>  'Assunto' ,
        'cdd' =>  'CDD'
    ];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

            'titulo' =>  'required' ,
            'cutter' =>  'required' ,
            'tipos_acervos_id' =>  'required' ,
            'assunto' =>  'required' ,
            'cdd' =>  'required'

        ],
        ValidatorInterface::RULE_UPDATE => [

            'titulo' =>  'required' ,
            'cutter' =>  'required' ,
            'tipos_acervos_id' =>  'required' ,
            'assunto' =>  'required' ,
            'cdd' =>  'required'
            
        ],
    ];

}

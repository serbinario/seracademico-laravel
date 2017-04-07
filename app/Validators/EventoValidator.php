<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EventoValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $attributes = [

    ];

    protected $messages = [

    ];
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}

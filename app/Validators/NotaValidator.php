<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class NotaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    /**
     * @var array
     */
    protected $messages   = [
    ];

    /**
     * @var array
     */
    protected $attributes = [
    ];

    /**
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			'nome' =>  '' ,
			'aluno_tuma_id' =>  '' ,
			'disciplina_id' =>  '' ,
			'situacao_nota_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];

}

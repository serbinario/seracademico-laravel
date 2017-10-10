<?php
namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class FormaPagamentoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [];

    protected $attributes = [
        'nome' => 'Nome',
        'codigo' => 'Código'
    ];


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nome' => 'required',
            'codigo' => 'required',

        ],
        ValidatorInterface::RULE_UPDATE => [
            'nome' => 'required',
            'codigo' => 'required'
        ],
    ];
}

<?php
namespace Seracademico\Validators\Financeiro;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ContaBancariaValidator extends LaravelValidator
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
            'agencia' => 'required',
            'conta' => 'required',
            'banco_id' => 'required|integer'

        ],
        ValidatorInterface::RULE_UPDATE => [
            'nome' => 'required',
            'codigo' => 'required',
            'agencia' => 'required',
            'conta' => 'required',
            'banco_id' => 'required'

        ],
    ];
}

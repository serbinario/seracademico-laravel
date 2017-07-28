<?php
/**
 * Created by PhpStorm.
 * User: serbinario
 * Date: 01/04/16
 * Time: 13:02
 */

namespace Seracademico\Validators\Doutorado;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class CalendarioDisciplinaTurmaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [
    ];

    protected $attributes = [
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
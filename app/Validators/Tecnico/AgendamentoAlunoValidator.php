<?php

namespace Seracademico\Validators\Tecnico;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class AgendamentoAlunoValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $messages   = [
	];

	protected $attributes = [
        'aluno_id' =>  'Aluno',
        'agendamento_sc_id' =>  'Disciplina',
        'disciplina_id' =>  'Agendamento',
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			'aluno_id' =>  'required',
			'agendamento_sc_id' =>  'required',
            'disciplina_id' =>  'required',
        ],

        ValidatorInterface::RULE_UPDATE => [
            'aluno_id' =>  'required',
            'agendamento_sc_id' =>  'required',
            'disciplina_id' =>  'required',
		],
   ];

}

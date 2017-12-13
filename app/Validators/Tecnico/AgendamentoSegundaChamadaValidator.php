<?php

namespace Seracademico\Validators\Tecnico;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class AgendamentoSegundaChamadaValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $messages   = [
	];

	protected $attributes = [
		'data' => 'Data',
		'hora_inicio' => 'Hora inicial',
        'hora_final' => 'Hora final',
        'hora_entrada' => 'Hora de entrada',
        'agendamento_tp_id' => 'Tipo',
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			'data' =>  'required',
			'hora_inicio' =>  'required',
            'hora_final' =>  'required',
            'hora_entrada' =>  'required',
            'agendamento_tp_id' =>  'required',
        ],

        ValidatorInterface::RULE_UPDATE => [
            'data' =>  'required',
            'hora_inicio' =>  'required',
            'hora_final' =>  'required',
            'hora_entrada' =>  'required',
            'agendamento_tp_id' =>  'required',
		],
   ];

}

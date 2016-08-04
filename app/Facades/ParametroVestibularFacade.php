<?php

namespace Seracademico\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * Class ParametroMatricula
 * @package Seracademico\Facades
 */
class ParametroVestibularFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vestibular';
    }
}
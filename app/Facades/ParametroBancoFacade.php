<?php

namespace Seracademico\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * Class ParametroBancoFacade
 * @package Seracademico\Facades
 */
class ParametroBancoFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'banco';
    }
}
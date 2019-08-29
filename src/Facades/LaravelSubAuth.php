<?php

namespace Whitwhoa\LaravelSubAuth\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelSubAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelsubauth';
    }
}

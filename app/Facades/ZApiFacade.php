<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ZApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'z-api';
    }
}
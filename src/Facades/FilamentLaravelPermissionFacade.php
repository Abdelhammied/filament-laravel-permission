<?php

namespace Abdelhammied\FilamentLaravelPermission\Facades;

use Illuminate\Support\Facades\Facade;

class FilamentLaravelPermissionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Abdelhammied\FilamentLaravelPermission\FilamentLaravelPermission::class;
    }
}

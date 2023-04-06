<?php

namespace BlockadeLabs\SDK\Facades;

use Illuminate\Support\Facades\Facade;

class BlockadeLabsClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'blockadelabs.sdk.client';
    }
}

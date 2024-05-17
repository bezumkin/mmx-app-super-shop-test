<?php

namespace MMX\Super\Shop\Services;

use MMX\Super\Shop\App;

class Filesystem extends \Vesp\Services\Filesystem
{
    public static function getCache(): string
    {
        return MODX_CORE_PATH . 'cache/' . App::NAMESPACE . '/';
    }

    protected function getRoot(): string
    {
        return MODX_ASSETS_PATH . 'upload/' . App::NAMESPACE . '/';
    }
}
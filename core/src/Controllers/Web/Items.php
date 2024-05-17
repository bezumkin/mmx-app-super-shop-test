<?php

namespace MMX\Super\Shop\Controllers\Web;

use Illuminate\Database\Eloquent\Builder;
use MMX\Super\Shop\Models\Item;
use Vesp\Controllers\ModelGetController;

class Items extends ModelGetController
{
    protected string $model = Item::class;

    protected function beforeGet(Builder $c): Builder
    {
        return $c->where('active', true);
    }

    protected function beforeCount(Builder $c): Builder
    {
        return $c->where('active', true);
    }
}
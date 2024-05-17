<?php

namespace MMX\Super\Shop\Controllers\Mgr;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MMX\Super\Shop\Models\Product;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class Products extends ModelController
{
    protected string $model = Product::class;

    protected function beforeCount(Builder $c): Builder
    {
        if ($query = trim($this->getProperty('query', ''))) {
            $c->where('title', 'LIKE', "%$query%");
        }

        return $c;
    }

    protected function beforeSave(Model $record): ?ResponseInterface
    {
        /** @var Product $record */
        if ($record->newQuery()->where('title', $record->title)->where('id', '!=', $record->id)->exists()) {
            return $this->failure('errors.product.title_unique');
        }

        return null;
    }

    protected function afterCount(Builder $c): Builder
    {
        $c->with('File:id,updated_at');

        return $c;
    }
}
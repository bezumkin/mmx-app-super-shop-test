<?php

namespace MMX\Super\Shop\Controllers\Mgr;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MMX\Super\Shop\Models\Category;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class Categories extends ModelController
{
    protected string $model = Category::class;

    protected function beforeCount(Builder $c): Builder
    {
        if ($query = trim($this->getProperty('query', ''))) {
            $c->where('title', 'LIKE', "%$query%");
        }

        return $c;
    }

    protected function beforeSave(Model $record): ?ResponseInterface
    {
        /** @var Category $record */
        if ($record->newQuery()->where('title', $record->title)->where('id', '!=', $record->id)->exists()) {
            return $this->failure('errors.category.title_unique');
        }

        return null;
    }
}
<?php

namespace MMX\Super\Shop\Controllers\Mgr\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MMX\Super\Shop\Models\File;
use MMX\Super\Shop\Models\Product;
use MMX\Super\Shop\Models\ProductFile;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class Files extends ModelController
{
    protected ?Product $product;

    protected string $model = ProductFile::class;
    protected string|array $primaryKey = ['product_id', 'file_id'];

    public function checkScope(string $method): ?ResponseInterface
    {
        if ($check = parent::checkScope($method)) {
            return $check;
        }

        if (!$this->product = Product::query()->find($this->getProperty('product_id'))) {
            return $this->failure('', 404);
        }

        return null;
    }

    protected function beforeGet(Builder $c): Builder
    {
        $c->where('product_id', $this->product->id);
        $c->with('file:id,updated_at');

        return $c;
    }

    protected function beforeCount(Builder $c): Builder
    {
        return $this->beforeGet($c);
    }

    protected function afterCount(Builder $c): Builder
    {
        $c->with('file:id,updated_at');
        $c->orderBy('rank');

        return $c;
    }

    protected function afterSave(Model $record): Model
    {
        /** @var ProductFile $record */
        $record->product->setFile();

        return $record;
    }

    public function put(): ResponseInterface
    {
        if (!$data = $this->getProperty('file')) {
            return $this->failure('errors.upload.no_file');
        }
        $file = new File();
        $file->uploadFile($data, $this->getProperty('metadata'));

        $productFile = $this->product->productFiles()->create([
            'file_id' => $file->id,
            'rank' => $this->product->productFiles()->max('rank') + 1,
        ]);
        $this->setProperty('file_id', $file->id);
        $this->afterSave($productFile);

        return $this->get();
    }

    /*public function post(): ResponseInterface
    {
        foreach ($this->getProperty('files') as $file_id => $rank) {
            $this->product->productFiles()->where('file_id', $file_id)->update(['rank' => $rank]);
        }

        return $this->success();
    }*/

    protected function beforeDelete(Model $record): ?ResponseInterface
    {
        /** @var ProductFile $record */
        $record->file->delete();
        $this->product->setFile();

        return null;
    }
}
<?php

namespace MMX\Super\Shop\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $category_id
 * @property int $file_id
 * @property string $title
 * @property string $alias
 * @property string $uri
 * @property bool $active
 * @property int $rank
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Category $category
 * @property-read ProductFile $file
 * @property-read ProductFile[] $productFiles
 */
class Product extends Model
{
    protected $table = 'mmx_super_shop_products';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'active' => 'bool',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(static function (self $model) {
            $model->uri = $model->category->alias . '/' . $model->alias;
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function productFiles(): HasMany
    {
        return $this->hasMany(ProductFile::class);
    }

    public function delete(): ?bool
    {
        /** @var ProductFile $productFile */
        foreach ($this->productFiles()->cursor() as $productFile) {
            $productFile->delete();
        }

        return parent::delete();
    }

    public function setFile(): void
    {
        /** @var ProductFile $first */
        $first = $this->productFiles()
            ->where('active', true)
            ->orderBy('rank')
            ->first();
        $this->file_id = $first?->file_id;
        $this->save();
    }
}
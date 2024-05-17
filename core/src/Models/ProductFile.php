<?php

namespace MMX\Super\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MMX\Database\Models\Traits\CompositeKey;

/**
 * @property int $product_id
 * @property int $file_id
 * @property int $rank
 * @property bool $active
 *
 * @property-read Product $product
 * @property-read File $file
 */
class ProductFile extends Model
{
    use CompositeKey;

    public $primaryKey = ['product_id', 'file_id'];
    public $timestamps = false;
    protected $table = 'mmx_super_shop_product_files';
    protected $guarded = [];
    protected $casts = [
        'active' => 'bool',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function delete(): ?bool
    {
        $this->file->delete();

        return parent::delete();
    }
}
<?php

namespace MMX\Super\Shop\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property bool $active
 * @property int $rank
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Product[] $products
 */
class Category extends Model
{
    protected $table = 'mmx_super_shop_categories';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'active' => 'bool',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
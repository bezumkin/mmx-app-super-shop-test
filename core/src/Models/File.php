<?php

namespace MMX\Super\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MMX\Super\Shop\Services\Filesystem;
use Ramsey\Uuid\Uuid;
use Vesp\Models\Traits\FileModel;

/**
 * @property string $uuid
 *
 * @property-read ProductFile[] $productFiles
 */
class File extends Model
{
    use FileModel;

    protected $fillable = ['file', 'path', 'title', 'type', 'width', 'height', 'size', 'metadata'];
    protected $casts = ['metadata' => 'array'];
    protected $table = 'mmx_super_shop_files';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->filesystem = new Filesystem();
    }

    protected static function boot(): void
    {
        static::creating(static function (self $model) {
            $model->uuid = Uuid::uuid4();
        });
    }

    public function productFiles(): HasMany
    {
        return $this->hasMany(ProductFile::class);
    }

    protected function getSavePath(string $filename, ?string $mime = null): string
    {
        return $filename[0];
    }
}
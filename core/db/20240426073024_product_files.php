<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class ProductFiles extends AbstractMigration
{
    public function up(): void
    {
        $schema = Manager::schema();
        $schema->create(
            'mmx_super_shop_product_files',
            static function (Blueprint $table) {
                $table->foreignId('product_id')
                    ->constrained('mmx_super_shop_products')
                    ->cascadeOnDelete();
                $table->foreignId('file_id')
                    ->constrained('mmx_super_shop_files')
                    ->cascadeOnDelete();
                $table->boolean('active')->default(true);
                $table->unsignedInteger('rank')->default(0);
            }
        );

        $schema->table(
            'mmx_super_shop_products',
            static function (Blueprint $table) {
                $table->foreignId('file_id')
                    ->nullable()
                    ->after('category_id')
                    ->constrained('mmx_super_shop_files')
                    ->nullOnDelete();
            }
        );
    }

    public function down(): void
    {
        $schema = Manager::schema();
        $schema->table(
            'mmx_super_shop_products',
            static function (Blueprint $table) {
                $table->dropConstrainedForeignId('file_id');
            }
        );
        $schema->drop('mmx_super_shop_product_files');
    }
}

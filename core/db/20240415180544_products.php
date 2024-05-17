<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class Products extends AbstractMigration
{
    public function up(): void
    {
        $schema = Manager::schema();
        $schema->create(
            'mmx_super_shop_products',
            static function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')
                    ->constrained('mmx_super_shop_categories')
                    ->restrictOnDelete();
                $table->string('title');
                $table->string('alias');
                $table->string('uri')->unique();
                $table->boolean('active')->default(true);
                $table->unsignedInteger('rank')->default(0);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        $schema = Manager::schema();
        $schema->drop('mmx_super_shop_products');
    }
}

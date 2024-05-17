<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class Categories extends AbstractMigration
{
    public function up(): void
    {
        $schema = Manager::schema();
        $schema->create(
            'mmx_super_shop_categories',
            static function (Blueprint $table) {
                $table->id();
                $table->string('title')->unique();
                $table->string('alias')->unique();
                $table->boolean('active')->default(true);
                $table->unsignedInteger('rank')->default(0);
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        $schema = Manager::schema();
        $schema->drop('mmx_super_shop_categories');
    }
}

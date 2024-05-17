<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

final class Files extends AbstractMigration
{
    public function up(): void
    {
        $schema = Manager::schema();
        $schema->create(
            'mmx_super_shop_files',
            static function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->string('file');
                $table->string('path');
                $table->string('title')->nullable();
                $table->string('type')->nullable();
                $table->unsignedSmallInteger('width')->nullable();
                $table->unsignedSmallInteger('height')->nullable();
                $table->unsignedInteger('size')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        $schema = Manager::schema();
        $schema->drop('mmx_super_shop_files');
    }
}

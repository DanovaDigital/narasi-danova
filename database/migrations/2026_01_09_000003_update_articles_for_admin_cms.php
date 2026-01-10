<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();

            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->softDeletes();

            $table->index(['is_published', 'published_at']);
            $table->index(['is_featured']);
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'admin_id')) {
                $table->dropConstrainedForeignId('admin_id');
            }

            $columns = [
                'featured_image',
                'is_featured',
                'is_published',
                'views_count',
                'meta_title',
                'meta_description',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('articles', $col)) {
                    $table->dropColumn($col);
                }
            }

            if (Schema::hasColumn('articles', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};

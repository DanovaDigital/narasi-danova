<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('article_views', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('article_id');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->string('referer')->nullable()->after('user_agent');

            $table->index(['ip_address']);
        });
    }

    public function down(): void
    {
        Schema::table('article_views', function (Blueprint $table) {
            if (Schema::hasColumn('article_views', 'ip_address')) {
                $table->dropIndex(['ip_address']);
                $table->dropColumn(['ip_address', 'user_agent', 'referer']);
            }
        });
    }
};

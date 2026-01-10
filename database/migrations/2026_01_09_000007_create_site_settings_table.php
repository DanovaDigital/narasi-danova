<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('group')->default('general');
            $table->timestamps();
        });

        DB::table('site_settings')->insert([
            ['key' => 'site_name', 'value' => 'News Portal', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_description', 'value' => 'Portal berita terkini', 'type' => 'textarea', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'whatsapp_number', 'value' => '62812XXXXXXXX', 'type' => 'text', 'group' => 'contact', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'whatsapp_message', 'value' => 'Halo, saya ingin mengajukan berita', 'type' => 'textarea', 'group' => 'contact', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'footer_text', 'value' => '© 2024 News Portal. All rights reserved.', 'type' => 'textarea', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'articles_per_page', 'value' => '12', 'type' => 'text', 'group' => 'display', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'featured_articles_count', 'value' => '5', 'type' => 'text', 'group' => 'display', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

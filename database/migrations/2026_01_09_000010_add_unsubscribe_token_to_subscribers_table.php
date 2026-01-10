<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->string('unsubscribe_token')->nullable()->after('verification_token');
        });

        // Backfill for existing rows.
        \App\Models\Subscriber::query()
            ->whereNull('unsubscribe_token')
            ->chunkById(200, function ($subscribers) {
                foreach ($subscribers as $subscriber) {
                    $subscriber->forceFill([
                        'unsubscribe_token' => Str::random(40),
                    ])->save();
                }
            });
    }

    public function down(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropColumn('unsubscribe_token');
        });
    }
};

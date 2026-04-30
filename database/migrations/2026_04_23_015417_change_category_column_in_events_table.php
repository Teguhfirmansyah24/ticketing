<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('event_category_id')->after('user_id')->constrained()->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['event_category_id']);
            $table->dropColumn('event_category_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->enum('category', ['music', 'sports', 'seminar', 'exhibition', 'other']);
        });
    }
};

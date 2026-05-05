<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kita buat nullable() dulu supaya data lama yang kosong tidak bikin error
            if (!Schema::hasColumn('orders', 'event_id')) {
                $table->foreignId('event_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            }

            // Gunakan nullable() jika tabel sudah ada isinya agar tidak gagal bayang
            $table->string('name')->nullable()->after('order_code');
            $table->string('email')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('id_number')->nullable()->after('phone');
            $table->string('snap_token')->nullable()->after('total_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus constraint dulu baru hapus kolom
            if (Schema::hasColumn('orders', 'event_id')) {
                $table->dropForeign(['event_id']);
            }
            $table->dropColumn(['event_id', 'name', 'email', 'phone', 'id_number', 'snap_token']);
        });
    }
};
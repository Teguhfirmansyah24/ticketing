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
            $table->string('contact_name')->nullable()->after('status');
            $table->string('contact_email')->nullable()->after('contact_name');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->integer('max_tickets_per_transaction')->default(5)->after('contact_phone');
            $table->boolean('one_email_one_transaction')->default(false)->after('max_tickets_per_transaction');
            $table->boolean('one_ticket_one_buyer')->default(false)->after('one_email_one_transaction');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'contact_name',
                'contact_email',
                'contact_phone',
                'max_tickets_per_transaction',
                'one_email_one_transaction',
                'one_ticket_one_buyer',
            ]);
        });
    }
};

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
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['individu', 'badan_hukum']);
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');

            // Individu
            $table->string('ktp_number')->nullable();
            $table->string('ktp_file')->nullable();
            $table->string('ktp_name')->nullable();
            $table->text('ktp_address')->nullable();

            // NPWP (shared)
            $table->string('npwp_number')->nullable();
            $table->string('npwp_file')->nullable();
            $table->string('npwp_name')->nullable();
            $table->text('npwp_address')->nullable();

            // Badan Hukum
            $table->string('deed_number')->nullable();
            $table->string('deed_file')->nullable();
            $table->string('deed_name')->nullable();
            $table->text('deed_address')->nullable();

            $table->text('notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};

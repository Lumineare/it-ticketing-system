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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique()->index();
            $table->string('nama_pelapor');
            $table->string('unit');
            $table->text('deskripsi_kerusakan');
            $table->string('foto')->nullable();
            $table->enum('jenis_trouble', ['Hardware', 'Network', 'Komunikasi', 'Software'])->nullable();
            $table->enum('prioritas', ['Low', 'Medium', 'High', 'Critical'])->nullable();
            $table->foreignId('teknisi')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['OPEN', 'PROGRESS', 'COMPLETE'])->default('OPEN');
            $table->text('note_perbaikan')->nullable();
            $table->text('tindakan_lanjutan')->nullable();
            $table->timestamp('waktu_laporan')->useCurrent();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

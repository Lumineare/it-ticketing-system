<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('tickets', function (Blueprint $table) {
        // Tambah kolom untuk menyimpan nama & email pelapor (nullable karena tiket lama mungkin punya user_id)
        $table->string('reporter_name')->nullable()->after('user_id');
        $table->string('reporter_email')->nullable()->after('reporter_name');
        
        // Opsional: Jika user_id tidak lagi wajib untuk tiket publik
        $table->foreignId('user_id')->nullable()->change(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};

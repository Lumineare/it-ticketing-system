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
    Schema::table('tickets', function (Blueprint $table) {
        // Hapus kolom email lama
        $table->dropColumn('reporter_email');
        
        // Tambah kolom unit_id
        $table->foreignId('unit_id')->nullable()->after('reporter_name')->constrained()->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->string('reporter_email')->nullable();
        $table->dropForeign(['unit_id']);
        $table->dropColumn('unit_id');
    });
}
};

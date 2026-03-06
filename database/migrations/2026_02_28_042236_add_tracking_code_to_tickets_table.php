<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Tambahkan kolom tracking_code dengan tipe string dan unique
            $table->string('tracking_code')->unique()->after('id'); 
            // 'after(id)' agar posisinya setelah ID, opsional
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('tracking_code');
        });
    }
};

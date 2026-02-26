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
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pelapor
        $table->string('subject');
        $table->text('description');
        $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
        $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
        $table->foreignId('assigned_to')->nullable()->constrained('users'); // Teknisi yang menangani
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

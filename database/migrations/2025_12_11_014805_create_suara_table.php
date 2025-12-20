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
        Schema::create('suara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pemilihan_id')->constrained('pemilihan')->onDelete('cascade');
            $table->foreignId('kandidat_id')->constrained('kandidat')->onDelete('cascade');
            $table->timestamp('waktu_memilih');
            $table->timestamps();

            $table->unique(['user_id', 'pemilihan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suara');
    }
};

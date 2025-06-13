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
        Schema::create('trocs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('objet_offert_id')->constrained('objets')->onDelete('cascade');
        $table->foreignId('objet_demande_id')->constrained('objets')->onDelete('cascade');
        $table->foreignId('user_propose_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('user_cible_id')->constrained('users')->onDelete('cascade');
        $table->enum('status', ['en_attente', 'accepté', 'refusé'])->default('en_attente');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trocs');
    }
};

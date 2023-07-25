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
        Schema::create('club_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id_1')->constrained('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('club_id_2')->constrained('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('score_1');
            $table->bigInteger('score_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_matches');
    }
};

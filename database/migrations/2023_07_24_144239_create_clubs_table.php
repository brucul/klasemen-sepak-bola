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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug_name');
            $table->string('city');
            $table->bigInteger('match')->default(0);
            $table->bigInteger('win')->default(0);
            $table->bigInteger('draw')->default(0);
            $table->bigInteger('lose')->default(0);
            $table->bigInteger('goals_for')->default(0);
            $table->bigInteger('goals_against')->default(0);
            $table->bigInteger('point')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};

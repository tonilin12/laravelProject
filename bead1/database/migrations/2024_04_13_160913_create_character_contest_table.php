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
        Schema::create('character_contests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
    

            $table->float('hero_hp')->default(20);
            $table->float('enemy_hp')->default(20);
            
            $table->foreignId('hero_id')
                ->constrained('characters', 'id')
                ->onDelete('cascade');

            $table->foreignId('enemy_id')
                ->constrained('characters', 'id')
                ->onDelete('cascade');
            
            $table->foreignId('contest_id')
                ->constrained()
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_contests');
    }
};

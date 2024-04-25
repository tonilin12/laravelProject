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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->boolean('enemy')->default(false);

            $table->unsignedInteger('defence'); 

            $table->unsignedBigInteger('strength'); 
            $table->unsignedBigInteger('accuracy');
            $table->unsignedBigInteger('magic'); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

        });
        


    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('character');
    }
};

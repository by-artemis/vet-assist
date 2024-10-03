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
        Schema::create('pet_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
                ->onDelete('cascade');

            $table->string('age');
            $table->date('birthdate');

            $table->string('coat')
                ->comment("The pet's distinct fur color")
                ->nullable();
            $table->string('pattern')
                ->comment("The pet's distinct fur pattern")
                ->nullable();

            $table->double('weight')
                ->nullable();
            $table->date('last_weighed_at')
                ->nullable();

            $table->boolean('is_disabled')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_details');
    }
};

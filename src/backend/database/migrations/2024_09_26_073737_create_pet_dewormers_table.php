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
        Schema::create('pet_dewormers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
                ->onDelete('cascade');

            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinics')
                ->onDelete('cascade');

            $table->string('dewormer')
                ->comment("The dewormer's name given to the pet")
                ->nullable();
            $table->date('last_dewormed_at')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_dewormers');
    }
};

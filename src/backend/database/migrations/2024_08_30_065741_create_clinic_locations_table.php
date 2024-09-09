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
        Schema::create('clinic_locations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinics')
                ->onDelete('cascade');

            $table->double('longitude');
            $table->double('latitude');

            $table->string('city')->default('Cebu');
            $table->string('country')->default('Philippines');
            $table->string('zip_code')->default('6000')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_locations');
    }
};

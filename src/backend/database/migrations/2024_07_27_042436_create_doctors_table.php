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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinics')
                ->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_licensed')->default(1);
            $table->string('specialty')->default('Animal Welfare')
                ->comment("Animal Welfare, Anesthesia, Behavioral, Nutrition, Dentistry, Emergency and Critical Care, Surgery, Dermatology, Microbiology, Public Health & Food Safety");

            $table->string('email')->unique();
            $table->string('phone_number')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

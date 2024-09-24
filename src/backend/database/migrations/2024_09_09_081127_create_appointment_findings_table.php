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
        Schema::create('appointment_findings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')
                ->references('id')
                ->on('doctor_appointments')
                ->onDelete('cascade');

            $table->string('overall_findings', 500);
            $table->string('diagnosis', 500)->nullable(); // Store the diagnosis if any
            $table->string('treatments', 500)->nullable(); // Store prescribed treatments/medications
            $table->string('tests_conducted', 500)->nullable(); // Store any tests performed
            $table->string('recommendations', 500)->nullable(); // Store recommendations for future care

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_findings');
    }
};

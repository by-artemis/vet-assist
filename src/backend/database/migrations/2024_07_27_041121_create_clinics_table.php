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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('address', 255);
            $table->string('office_hours');
            $table->string('is_24_7');
            $table->string('phone_number');
            $table->string('logo')->nullable();
            $table->string('photos')->nullable();
            $table->string('payment_option_ids');
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('description', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};

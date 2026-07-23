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
        Schema::create('reserved_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blood_unit_id')->unique();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('reserved_by_user_id');
            $table->dateTime('reservation_date');
            $table->dateTime('expiration_date');
            $table->enum('status', ['active', 'fulfilled', 'expired', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserved_units');
    }
};

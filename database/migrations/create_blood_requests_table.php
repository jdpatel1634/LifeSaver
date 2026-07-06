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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('requester_user_id')->nullable();
            $table->unsignedBigInteger('blood_group_id');
            $table->integer('units_requested');
            $table->enum('urgency_level', ['routine', 'urgent', 'emergency']);
            $table->date('request_date');
            $table->date('required_by_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'fulfilled', 'rejected', 'canceled']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};

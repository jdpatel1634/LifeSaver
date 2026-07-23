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
        Schema::create('transfusion_reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('blood_unit_id')->nullable();
            $table->dateTime('reaction_date');
            $table->string('reaction_type');
            $table->enum('severity', ['mild', 'moderate', 'severe', 'fatal']);
            $table->text('description');
            $table->unsignedBigInteger('reported_by_user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfusion_reactions');
    }
};

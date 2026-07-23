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
        Schema::create('serology_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blood_unit_id');
            $table->string('test_type');
            $table->enum('result', ['positive', 'negative', 'indeterminate']);
            $table->date('test_date');
            $table->unsignedBigInteger('tested_by_user_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serology_tests');
    }
};

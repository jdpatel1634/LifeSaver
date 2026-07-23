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
        Schema::create('camp_staff', function (Blueprint $table) {
            $table->unsignedBigInteger('camp_id');
            $table->unsignedBigInteger('user_id');
            $table->string('role_in_camp')->nullable();
            $table->timestamps();

            $table->primary(['camp_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camp_staff');
    }
};

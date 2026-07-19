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
        Schema::create('blood_units', function (Blueprint $table) {
            $table->id();
            $table->string('unique_bag_id')->unique();
            $table->unsignedBigInteger('donor_id');
            $table->unsignedBigInteger('blood_group_id');
            $table->date('collection_date');
            $table->date('expiry_date');
            $table->enum('component_type', ['whole_blood', 'plasma', 'platelet', 'red_blood_cells']);
            $table->integer('volume_ml')->nullable();
            $table->unsignedBigInteger('collection_camp_id')->nullable();
            $table->enum('status', ['collected', 'test_awaited', 'tested', 'ready_for_issue', 'issued', 'expired', 'discarded', 'quarantined']);
            $table->enum('serology_test_status', ['pending', 'passed', 'failed']);
            $table->string('storage_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_units');
    }
};

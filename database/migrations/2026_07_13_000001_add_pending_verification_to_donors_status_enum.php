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
        Schema::table('donors', function (Blueprint $table) {
            // Drop the old status column
            $table->dropColumn('status');
        });

        Schema::table('donors', function (Blueprint $table) {
            // Recreate the status column with the new enum options
            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'pending_verification',
            ])->default('pending_verification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donors', function (Blueprint $table) {
            // Drop the updated status column
            $table->dropColumn('status');
        });

        Schema::table('donors', function (Blueprint $table) {
            // Recreate the original enum column (without pending_verification)
            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
            ])->default('active');
        });
    }
};

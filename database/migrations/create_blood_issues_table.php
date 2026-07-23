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
        Schema::create('blood_issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blood_request_id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('blood_unit_id')->unique();
            $table->dateTime('issue_date');
            $table->unsignedBigInteger('issued_by_user_id');
            $table->enum('cross_match_status', ['pending', 'passed', 'failed', 'not_performed']);
            $table->enum('payment_status', ['pending', 'paid', 'waived']);
            $table->decimal('total_amount', 10, 2);
            $table->text('adjustment_details')->nullable();
            $table->string('receipt_number')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_issues');
    }
};

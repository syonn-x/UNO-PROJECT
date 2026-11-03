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
        Schema::create('safety_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_code', 30)->unique();
            $table->foreignId('reporter_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('reported_user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onUpdate('cascade')->onDelete('set null');
            $table->string('category', 50)->default('damage_dispute');
            $table->string('title', 150);
            $table->text('description');
            $table->string('evidence_photo', 255)->nullable();
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['pending', 'investigating', 'resolved', 'action_taken'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('status');
            $table->index('severity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_reports');
    }
};

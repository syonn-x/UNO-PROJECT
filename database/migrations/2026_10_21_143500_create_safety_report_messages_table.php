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
        Schema::create('safety_report_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('safety_report_id')->constrained('safety_reports')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('message');
            $table->string('attachment', 255)->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();

            $table->index('safety_report_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_report_messages');
    }
};

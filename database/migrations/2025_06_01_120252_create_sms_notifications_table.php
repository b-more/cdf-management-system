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
        Schema::create('sms_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipient_id')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('subject', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('message_type', 50)->nullable();
            $table->string('priority', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->boolean('schedule_send')->nullable()->default(false);
            $table->datetime('scheduled_at')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->datetime('delivered_at')->nullable();
            $table->datetime('failed_at')->nullable();
            $table->text('delivery_report')->nullable();
            $table->text('error_message')->nullable();
            $table->unsignedBigInteger('sent_by_id')->nullable();
            $table->integer('retry_count')->nullable()->default(0);
            $table->timestamps();

            $table->index(['phone_number', 'status']);
            $table->index('message_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_notifications');
    }
};

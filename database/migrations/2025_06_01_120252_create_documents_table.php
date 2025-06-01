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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('document_type', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('file_path', 500)->nullable();
            $table->string('documentable_type', 255)->nullable();
            $table->unsignedBigInteger('documentable_id')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->string('version', 10)->nullable();
            $table->boolean('is_public')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);
            $table->datetime('expires_at')->nullable();
            $table->string('access_level', 50)->nullable();
            $table->text('access_notes')->nullable();
            $table->unsignedBigInteger('uploaded_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();

            $table->index(['documentable_type', 'documentable_id']);
            $table->index('document_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

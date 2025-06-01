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
       Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('module', 100)->nullable();
            $table->boolean('create')->nullable()->default(false);
            $table->boolean('read')->nullable()->default(false);
            $table->boolean('update')->nullable()->default(false);
            $table->boolean('delete')->nullable()->default(false);
            $table->timestamps();

            $table->index(['role_id', 'module']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};

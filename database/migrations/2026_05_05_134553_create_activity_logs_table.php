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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('book_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('action', ['uploaded', 'purchased', 'downloaded'])->default('downloaded');
            $table->string('description')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id', 'idx_activity_user');
            $table->index('book_id', 'idx_activity_book');
            $table->index('created_at', 'idx_activity_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

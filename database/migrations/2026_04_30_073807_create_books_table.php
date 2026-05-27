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
        Schema::create('books', function (Blueprint $table) {
          $table->id();
          $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
          $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
          $table->string('title');
          $table->string('author', 150);
          $table->string('cover_image', 500)->nullable();
          $table->string('file_path', 500);
          $table->text('description')->nullable();
          $table->enum('access_type', ['free', 'paid'])->default('free');
          $table->decimal('price', 8, 2)->default(0.00);
          $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
          $table->text('rejection_reason')->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

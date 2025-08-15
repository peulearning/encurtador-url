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
        Schema::create('links', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->text('original_url');
                $table->string('slug', 32)->unique();
                $table->enum('status', ['active','expired','inactive'])->default('active');
                $table->timestampTz('expires_at')->nullable()->index();
                $table->unsignedBigInteger('click_count')->default(0);
                $table->timestamps();
                $table->index(['status']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};

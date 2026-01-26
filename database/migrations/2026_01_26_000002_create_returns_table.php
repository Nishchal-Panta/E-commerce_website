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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('return_reason_id')->nullable()->constrained()->onDelete('set null');
            $table->text('custom_reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending')->index();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['order_item_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};

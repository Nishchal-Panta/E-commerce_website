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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['active', 'deleted'])->default('active')->after('is_blocked');
            
            // Make username and email nullable and remove unique constraint
            $table->dropUnique(['username']);
            $table->dropUnique(['email']);
            $table->string('username')->nullable()->change();
            $table->string('email')->nullable()->change();
            
            // Add composite unique constraint that only applies to active users
            $table->unique(['username', 'status'], 'users_username_status_unique');
            $table->unique(['email', 'status'], 'users_email_status_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_username_status_unique');
            $table->dropUnique('users_email_status_unique');
            $table->dropColumn('status');
            $table->string('username')->unique()->change();
            $table->string('email')->unique()->change();
        });
    }
};

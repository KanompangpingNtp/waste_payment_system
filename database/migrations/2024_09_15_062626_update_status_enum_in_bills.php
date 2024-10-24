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
        Schema::table('bills', function (Blueprint $table) {
            //
            Schema::table('bills', function (Blueprint $table) {
                // Drop the old 'status' column
                $table->dropColumn('status');
            });

            Schema::table('bills', function (Blueprint $table) {
                // Re-add the 'status' column with the new enum values
                $table->enum('status', ['paid', 'unpaid', 'pending'])->default('unpaid');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            // Drop the new 'status' column
            $table->dropColumn('status');
        });

        Schema::table('bills', function (Blueprint $table) {
            // Re-add the 'status' column with the old enum values
            $table->enum('status', ['paid', 'unpaid'])->default('pending');
        });
    }
};

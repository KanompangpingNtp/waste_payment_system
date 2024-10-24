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
        Schema::create('bills', function (Blueprint $table) {
            $table->id('bill_id'); // Primary Key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // เชื่อมกับคอลัมน์ id ใน users
            $table->date('billing_month');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->enum('status', ['paid', 'unpaid']);
            $table->timestamps(); // Created_at, Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id'); // Primary Key
            $table->foreignId('bill_id')->constrained('bills', 'bill_id')->onDelete('cascade'); // Foreign Key to bills
            $table->date('payment_date');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_method');
            $table->timestamps(); // Created_at, Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

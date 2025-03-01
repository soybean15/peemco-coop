<?php

use App\Models\CashAdvanceItem;
use App\Models\Loan;
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
        Schema::create('cash_advance_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Loan::class)->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('amount_to_pay')->default(0);

            $table->decimal('charge_amount')->default(0);
            $table->decimal('penalty')->default(0);
            $table->decimal('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_advance_items');
    }
};

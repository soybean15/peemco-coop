<?php

use App\Models\LoanItem;
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
        Schema::create('loan_item_penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LoanItem::class);
            $table->decimal('amount',20,2)->nullable();
            $table->date('penalty_date')->nullable();
            $table->decimal('running_balance',20,2)->default(0)->nullable();
            $table->decimal('rate',8,2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_item_penalties');
    }
};

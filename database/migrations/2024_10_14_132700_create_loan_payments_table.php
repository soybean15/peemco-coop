<?php

use App\Models\Loan;
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
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Loan::class)->nullable();

            $table->foreignIdFor(LoanItem::class)->nullable();
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users');
            $table->date('date')->nullable();
            $table->string('or_cdv')->nullable();
            $table->decimal('amount_paid',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};

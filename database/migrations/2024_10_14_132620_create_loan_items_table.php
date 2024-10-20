<?php

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
        Schema::create('loan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Loan::class)->nullable()->constrained();
            $table->integer('loan_period')->nullable();
            $table->decimal('interest')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('amount_due',10,2)->default(0);
            $table->decimal('past_due',10,2)->default(0);
            $table->decimal('running_balance',10,2)->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_items');
    }
};
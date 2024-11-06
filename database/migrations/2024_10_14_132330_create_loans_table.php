<?php

use App\Models\LoanType;
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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_application_no')->unique()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            // $table->foreignIdFor(LoanType::class)->nullable();
            $table->unsignedBigInteger('loan_type_id')->nullable();
            $table->foreign('loan_type_id')->references('id')->on('loan_types');

            $table->string('loan_type')->nullable();


            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->foreign('confirmed_by')->references('id')->on('users');

            $table->date('date_applied')->nullable();
            $table->date('date_confirmed')->nullable();
            $table->decimal('principal_amount', 11, 2)->nullable();

            $table->bigInteger('terms_of_loan')->nullable();
            $table->bigInteger('no_of_installment')->nullable();
            $table->decimal('other_charges', 11, 2)->nullable();
            $table->decimal('annual_interest_rate', 11, 2)->nullable();
            $table->decimal('monthly_interest_rate', 11, 2)->nullable();
            $table->decimal('monthly_payment', 11, 2)->nullable();

            $table->string('status')->nullable(); //Approved or Pending
            $table->string('remarks')->nullable(); //Closed or Active(Renew) or Paid


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

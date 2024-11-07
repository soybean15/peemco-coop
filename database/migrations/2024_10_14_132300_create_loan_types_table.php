<?php

use App\Models\LoanReleaseDate;
use App\Models\User;
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
        Schema::create('loan_types', function (Blueprint $table) {
            $table->id();

            $table->string('loan_type')->nullable();
            $table->string('type')->comment('regular, cash advance')->nullable();
            $table->decimal('annual_rate',8,2)->comment('for regular')->nullable();
            $table->decimal('maximum_amount',20,3)->nullable();
            $table->decimal('minimum_amount',20,3)->nullable();


            $table->decimal('charges',8,2)->comment('%')->nullable();


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_types');
    }
};

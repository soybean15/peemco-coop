<?php

use App\Models\LoanType;
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
        Schema::create('loan_type_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LoanType::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_type_users');
    }
};

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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('tin_no')->nullable();
            $table->date('date_accepted')->nullable();
            $table->string('acceptance_membership_bod_resolution_no')->nullable();
            $table->string('type_of_membership')->nullable();
            $table->string('number_of_share')->nullable();
            $table->string('amount')->nullable();
            $table->string('initial_paid_up')->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->text('highest_educational_attainment')->nullable();
            $table->text('occupation_income_source')->nullable();
            $table->text('number_of_dependents')->nullable();
            $table->text('religion_social_affiliation')->nullable();
            $table->string('annual_income')->nullable();
            $table->text('termination_membership_bod_resolution_no')->nullable();
            $table->date('termination_membership_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_profile');
    }
};

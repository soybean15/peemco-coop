<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('cash_advance_items', function (Blueprint $table) {
            // Change 'status' column from decimal to string
            $table->string('status')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('cash_advance_items', function (Blueprint $table) {
            // Revert 'status' column from string back to decimal
            $table->decimal('status', 8, 2)->change();
        });
    }
};

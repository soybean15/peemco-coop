<?php

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
        Schema::create('job_processes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('batch_id')->nullable();
            $table->foreignIdFor(User::class)->nullable();

            $table->string('process_for')->nullable();
            $table->integer('total_rows')->default(0)->nullable();

            $table->integer('processed_rows')->default(0)->nullable();
            $table->integer('failed_rows')->default(0)->nullable();
            $table->string('processed_time')->nullable();
            $table->morphs('job_processable');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_processes');
    }
};

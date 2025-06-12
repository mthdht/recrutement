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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('contract_type');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('salary')->nullable();
            $table->string('status')->default('draft'); // ex: 'draft', 'published', 'archived'
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

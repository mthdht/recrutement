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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Candidat
            $table->foreignId('job_offer_id')->constrained()->cascadeOnDelete();

            $table->string('cv')->nullable(); // possibilité d’envoyer un CV différent
            $table->text('cover_letter')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'job_offer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

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
            Schema::create('encounters', function (Blueprint $table) {
                $table->id();

                $table->foreignId('patient_id')->constrained()->onDelete('cascade');

                $table->text('chief_complaint')->nullable();
                $table->text('notes')->nullable();
                $table->text('diagnosis')->nullable();

                $table->timestamp('encounter_date')->useCurrent();

                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};

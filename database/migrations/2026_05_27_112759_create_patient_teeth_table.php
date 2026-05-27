<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_teeth', function (Blueprint $table) {

            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('tooth_number', 10);

            // current persistent state
            $table->string('state')->nullable();

            $table->timestamps();

            $table->unique([
                'patient_id',
                'tooth_number'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_teeth');
    }
};
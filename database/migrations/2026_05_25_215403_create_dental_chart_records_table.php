<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_chart_records', function (Blueprint $table) {

            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('tooth_number', 10);

            $table->string('surface', 20);

            $table->text('remarks')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Prevent duplicate tooth surface records
            $table->unique([
                'patient_id',
                'tooth_number',
                'surface',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_chart_records');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_forms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('category');
            $table->text('remarks')->nullable();

            $table->string('file_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_forms');
    }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('clinic_id')->nullable();

            $table->string('patient_code')->nullable()->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();

            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();

            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();

            $table->timestamps();

            $table->index(['clinic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
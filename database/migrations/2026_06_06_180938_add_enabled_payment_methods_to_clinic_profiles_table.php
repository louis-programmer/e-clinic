<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clinic_profiles', function (Blueprint $table) {

            $table->json('enabled_payment_methods')
                  ->nullable()
                  ->after('payment_methods');

        });
    }

    public function down(): void
    {
        Schema::table('clinic_profiles', function (Blueprint $table) {

            $table->dropColumn('enabled_payment_methods');

        });
    }
};
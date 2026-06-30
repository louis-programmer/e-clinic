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
    Schema::table('licenses', function (Blueprint $table) {

        $table->unsignedBigInteger('clinic_id')->after('activation_code');

        $table->string('plan')->after('clinic_id');

        $table->date('expires_at')->after('plan');

        $table->integer('grace_days')
              ->default(5)
              ->after('expires_at');

    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('licenses', function (Blueprint $table) {

        $table->dropColumn([
            'clinic_id',
            'plan',
            'expires_at',
            'grace_days',
        ]);

    });
}
};

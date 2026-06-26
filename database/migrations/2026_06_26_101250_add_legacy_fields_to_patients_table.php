<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {

            $table->string('occupation')
                ->nullable()
                ->after('email');

            $table->string('tags')
                ->nullable()
                ->after('occupation');

            $table->unsignedBigInteger('legacy_id')
                ->default(0)
                ->after('tags');

            $table->boolean('is_legacy')
                ->default(false)
                ->after('legacy_id');

        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {

            $table->dropColumn([
                'occupation',
                'tags',
                'legacy_id',
                'is_legacy',
            ]);

        });
    }
};
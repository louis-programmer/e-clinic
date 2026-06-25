<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('invoices', function (Blueprint $table) {

        $table->boolean('is_void')
              ->default(false)
              ->after('status');

        $table->timestamp('voided_at')
              ->nullable();

        $table->foreignId('voided_by')
              ->nullable();

        $table->text('void_reason')
              ->nullable();
    });
}

public function down()
{
    Schema::table('invoices', function (Blueprint $table) {

        $table->dropColumn([
            'is_void',
            'voided_at',
            'void_reason',
        ]);

        $table->dropColumn('voided_by');
    });
}
};

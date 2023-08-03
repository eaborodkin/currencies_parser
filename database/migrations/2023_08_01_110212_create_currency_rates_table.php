<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->double('rate');
            $table->date('created_at');
            $table->timestamp('updated_at');
        });

        DB::unprepared('ALTER TABLE `currency_rates` DROP PRIMARY KEY, ADD PRIMARY KEY (  `code` ,  `created_at` )');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};

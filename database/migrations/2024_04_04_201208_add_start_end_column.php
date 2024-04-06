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
        Schema::table('shift_times', function (Blueprint $table) {
            $table->timestamp('start');
            $table->timestamp('end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shift_times', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('end');
        });
    }
};

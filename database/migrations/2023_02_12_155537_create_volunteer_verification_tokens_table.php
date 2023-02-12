<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_verification_tokens', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedBigInteger('volunteer_id');
            $table->timestamps();

            $table->foreign('volunteer_id')->references('id')->on('volunteers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteer_verification_tokens');
    }
};

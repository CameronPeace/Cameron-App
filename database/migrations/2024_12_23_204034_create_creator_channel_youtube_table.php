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
        Schema::create('creator_channel_youtube', function (Blueprint $table) {
            $table->id();
            $table->string('handle', length:64);
            $table->string('channel_id', length: 64);
            $table->string('auth_code', length: 256)->nullable();
            $table->string('access_token', length: 2048)->nullable();
            $table->string('refresh_token', length: 512)->nullable();
            $table->foreignId('creator_id');
            $table->foreign('creator_id')->references('id')->on('creator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_channel_youtube');
    }
};

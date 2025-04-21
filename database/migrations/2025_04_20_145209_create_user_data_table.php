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
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->index()->comment('Identifiant unique généré côté client');
            $table->string('url');
            $table->string('referrer')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('language', 20)->nullable();
            $table->string('screen_resolution', 20)->nullable();
            $table->string('window_size', 20)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->boolean('cookies_enabled')->default(true);
            $table->string('do_not_track', 10)->nullable();
            $table->string('platform', 50)->nullable();
            $table->string('connection_type', 30)->nullable();
            $table->json('additional_data')->nullable()->comment('Données supplémentaires au format JSON');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_data');
    }
};

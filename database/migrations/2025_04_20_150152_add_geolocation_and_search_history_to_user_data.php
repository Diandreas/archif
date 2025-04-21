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
        Schema::table('user_data', function (Blueprint $table) {
            // Ajout des champs de géolocalisation
            $table->string('country', 100)->nullable()->after('ip_address');
            $table->string('city', 100)->nullable()->after('country');
            $table->string('region', 100)->nullable()->after('city');
            $table->decimal('latitude', 10, 7)->nullable()->after('region');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            
            // Historique de recherche et comportement
            $table->json('search_history')->nullable()->after('additional_data');
            $table->json('page_views')->nullable()->after('search_history');
            $table->integer('visit_count')->default(1)->after('page_views');
            $table->dateTime('last_visit')->nullable()->after('visit_count');
            $table->integer('time_spent')->nullable()->after('last_visit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_data', function (Blueprint $table) {
            $table->dropColumn([
                'country',
                'city',
                'region',
                'latitude',
                'longitude',
                'search_history',
                'page_views',
                'visit_count',
                'last_visit',
                'time_spent'
            ]);
        });
    }
};

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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            
            // Géolocalisation
            $table->string('country')->nullable();
            $table->string('region')->nullable(); // Abidjan, Bouaké, etc.
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Tracking de session
            $table->timestamp('first_visit')->useCurrent();
            $table->timestamp('last_activity')->useCurrent();
            $table->integer('page_views')->default(1);
            $table->integer('session_duration')->default(0); // en secondes
            $table->boolean('is_bounce')->default(false);
            
            // Source de trafic
            $table->string('referrer')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('landing_page')->nullable();
            
            // Conversions
            $table->integer('whatsapp_clicks')->default(0);
            $table->integer('product_views')->default(0);
            $table->integer('searches')->default(0);
            $table->boolean('converted')->default(false);
            
            $table->timestamps();
            
            $table->index(['ip_address', 'created_at']);
            $table->index(['region', 'created_at']);
            $table->index(['device_type', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

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
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('metric_type'); // 'daily', 'weekly', 'monthly'
            
            // KPIs de vente
            $table->decimal('revenue', 15, 2)->default(0);
            $table->integer('orders_count')->default(0);
            $table->integer('whatsapp_clicks')->default(0);
            $table->decimal('average_order_value', 10, 2)->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0);
            
            // KPIs de trafic
            $table->integer('visitors')->default(0);
            $table->integer('page_views')->default(0);
            $table->integer('unique_visitors')->default(0);
            $table->decimal('bounce_rate', 5, 2)->default(0);
            $table->integer('session_duration')->default(0); // en secondes
            
            // KPIs géographiques
            $table->integer('abidjan_visitors')->default(0);
            $table->integer('interior_visitors')->default(0);
            $table->integer('international_visitors')->default(0);
            
            // KPIs produits
            $table->integer('products_viewed')->default(0);
            $table->integer('searches_count')->default(0);
            $table->json('top_products')->nullable();
            $table->json('top_categories')->nullable();
            $table->json('top_search_terms')->nullable();
            
            // KPIs SEO
            $table->integer('organic_traffic')->default(0);
            $table->decimal('avg_position', 5, 2)->nullable();
            $table->integer('indexed_pages')->default(0);
            $table->json('keyword_positions')->nullable();
            
            $table->timestamps();
            
            $table->unique(['date', 'metric_type']);
            $table->index(['date', 'metric_type']);
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};

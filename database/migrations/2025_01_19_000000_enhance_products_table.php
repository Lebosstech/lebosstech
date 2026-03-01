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
        Schema::table('products', function (Blueprint $table) {
            // Prix avancés
            $table->decimal('compare_price', 10, 2)->nullable()->after('price');
            $table->decimal('cost_price', 10, 2)->nullable()->after('compare_price');
            $table->decimal('tax_rate', 5, 2)->default(0)->after('cost_price');
            
            // Marges et remises calculées
            $table->decimal('margin_amount', 10, 2)->nullable()->after('tax_rate');
            $table->decimal('margin_percent', 5, 2)->nullable()->after('margin_amount');
            $table->decimal('discount_percent', 5, 2)->nullable()->after('margin_percent');
            
            // Gestion du stock avancée
            $table->integer('min_stock')->default(5)->after('stock');
            $table->integer('max_stock')->nullable()->after('min_stock');
            $table->boolean('track_stock')->default(true)->after('max_stock');
            $table->boolean('allow_backorder')->default(false)->after('track_stock');
            $table->boolean('notify_low_stock')->default(true)->after('allow_backorder');
            
            // Dimensions et poids
            $table->decimal('weight', 8, 2)->nullable()->after('notify_low_stock');
            $table->decimal('length', 8, 2)->nullable()->after('weight');
            $table->decimal('width', 8, 2)->nullable()->after('length');
            $table->decimal('height', 8, 2)->nullable()->after('width');
            $table->json('package_dimensions')->nullable()->after('height');
            
            // Gestion des brouillons
            $table->boolean('is_draft')->default(false)->after('is_featured');
            
            // SEO et tags
            $table->string('tags')->nullable()->after('meta_description');
            
            // Index pour améliorer les performances
            $table->index(['is_active', 'is_featured']);
            $table->index(['category_id', 'is_active']);
            $table->index(['brand']);
            $table->index(['condition']);
            $table->index(['is_draft']);
            $table->index(['stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'is_featured']);
            $table->dropIndex(['category_id', 'is_active']);
            $table->dropIndex(['brand']);
            $table->dropIndex(['condition']);
            $table->dropIndex(['is_draft']);
            $table->dropIndex(['stock']);
            
            $table->dropColumn([
                'compare_price',
                'cost_price',
                'tax_rate',
                'margin_amount',
                'margin_percent',
                'discount_percent',
                'min_stock',
                'max_stock',
                'track_stock',
                'allow_backorder',
                'notify_low_stock',
                'weight',
                'length',
                'width',
                'height',
                'package_dimensions',
                'is_draft',
                'tags'
            ]);
        });
    }
}; 
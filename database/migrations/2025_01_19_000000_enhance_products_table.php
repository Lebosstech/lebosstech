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
            if (!Schema::hasColumn('products', 'compare_price')) {
                $table->decimal('compare_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'cost_price')) {
                $table->decimal('cost_price', 10, 2)->nullable()->after('compare_price');
            }
            if (!Schema::hasColumn('products', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->default(0)->after('cost_price');
            }
            
            // Marges et remises calculées
            if (!Schema::hasColumn('products', 'margin_amount')) {
                $table->decimal('margin_amount', 10, 2)->nullable()->after('tax_rate');
            }
            if (!Schema::hasColumn('products', 'margin_percent')) {
                $table->decimal('margin_percent', 5, 2)->nullable()->after('margin_amount');
            }
            if (!Schema::hasColumn('products', 'discount_percent')) {
                $table->decimal('discount_percent', 5, 2)->nullable()->after('margin_percent');
            }
            
            // Gestion du stock avancée
            if (!Schema::hasColumn('products', 'min_stock')) {
                $table->integer('min_stock')->default(5)->after('stock');
            }
            if (!Schema::hasColumn('products', 'max_stock')) {
                $table->integer('max_stock')->nullable()->after('min_stock');
            }
            if (!Schema::hasColumn('products', 'track_stock')) {
                $table->boolean('track_stock')->default(true)->after('max_stock');
            }
            if (!Schema::hasColumn('products', 'allow_backorder')) {
                $table->boolean('allow_backorder')->default(false)->after('track_stock');
            }
            if (!Schema::hasColumn('products', 'notify_low_stock')) {
                $table->boolean('notify_low_stock')->default(true)->after('allow_backorder');
            }
            
            // Dimensions et poids
            if (!Schema::hasColumn('products', 'weight')) {
                $table->decimal('weight', 8, 2)->nullable()->after('notify_low_stock');
            }
            if (!Schema::hasColumn('products', 'length')) {
                $table->decimal('length', 8, 2)->nullable()->after('weight');
            }
            if (!Schema::hasColumn('products', 'width')) {
                $table->decimal('width', 8, 2)->nullable()->after('length');
            }
            if (!Schema::hasColumn('products', 'height')) {
                $table->decimal('height', 8, 2)->nullable()->after('width');
            }
            if (!Schema::hasColumn('products', 'package_dimensions')) {
                $table->json('package_dimensions')->nullable()->after('height');
            }
            
            // Gestion des brouillons
            if (!Schema::hasColumn('products', 'is_draft')) {
                $table->boolean('is_draft')->default(false)->after('is_featured');
            }
            
            // SEO et tags
            if (!Schema::hasColumn('products', 'tags')) {
                $table->string('tags')->nullable()->after('meta_description');
            }
        });

        // Index pour améliorer les performances (using separate closure or try-catch context)
        $indexes = [
            'products_is_active_is_featured_index' => ['is_active', 'is_featured'],
            'products_category_id_is_active_index' => ['category_id', 'is_active'],
            'products_brand_index' => ['brand'],
            'products_condition_index' => ['condition'],
            'products_is_draft_index' => ['is_draft'],
            'products_stock_index' => ['stock'],
        ];

        foreach ($indexes as $name => $columns) {
            if (!Schema::hasIndex('products', $name)) {
                Schema::table('products', function (Blueprint $table) use ($columns) {
                    $table->index($columns);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $indexes = [
            'products_is_active_is_featured_index' => ['is_active', 'is_featured'],
            'products_category_id_is_active_index' => ['category_id', 'is_active'],
            'products_brand_index' => ['brand'],
            'products_condition_index' => ['condition'],
            'products_is_draft_index' => ['is_draft'],
            'products_stock_index' => ['stock'],
        ];

        foreach ($indexes as $name => $columns) {
            if (Schema::hasIndex('products', $name)) {
                Schema::table('products', function (Blueprint $table) use ($name) {
                    $table->dropIndex($name);
                });
            }
        }

        Schema::table('products', function (Blueprint $table) {
            $columnsToDrop = [
                'compare_price', 'cost_price', 'tax_rate', 'margin_amount',
                'margin_percent', 'discount_percent', 'min_stock', 'max_stock',
                'track_stock', 'allow_backorder', 'notify_low_stock', 'weight',
                'length', 'width', 'height', 'package_dimensions', 'is_draft', 'tags'
            ];

            $actualColumnsToDrop = array_filter($columnsToDrop, function ($column) {
                return Schema::hasColumn('products', $column);
            });

            if (!empty($actualColumnsToDrop)) {
                $table->dropColumn($actualColumnsToDrop);
            }
        });
    }
}; 
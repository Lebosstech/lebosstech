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
            $table->string('brand')->nullable()->after('category_id');
            $table->enum('condition', ['neuf', 'excellent', 'tres_bon', 'bon', 'correct'])
                  ->default('bon')->after('brand');
            
            // Index pour améliorer les performances de recherche
            $table->index(['brand', 'condition']);
            $table->index(['name', 'brand']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['brand', 'condition']);
            $table->dropIndex(['name', 'brand']);
            $table->dropColumn(['brand', 'condition']);
        });
    }
};

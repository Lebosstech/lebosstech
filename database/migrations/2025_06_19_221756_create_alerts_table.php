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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // 'stock', 'traffic', 'sales', 'seo'
            $table->string('metric'); // 'stock_level', 'visitors_count', 'revenue', etc.
            $table->string('condition'); // 'less_than', 'greater_than', 'equals'
            $table->decimal('threshold', 15, 2);
            $table->string('frequency'); // 'real_time', 'hourly', 'daily', 'weekly'
            
            // Notifications
            $table->boolean('email_enabled')->default(true);
            $table->json('email_recipients')->nullable();
            $table->boolean('sms_enabled')->default(false);
            $table->json('sms_recipients')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_triggered')->nullable();
            $table->integer('trigger_count')->default(0);
            
            // Configuration avancée
            $table->json('conditions')->nullable(); // Conditions multiples
            $table->text('message_template')->nullable();
            $table->integer('cooldown_minutes')->default(60); // Éviter spam
            
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};

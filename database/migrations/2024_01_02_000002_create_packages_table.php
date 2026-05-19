<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tier');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('discount_price')->nullable();
            $table->unsignedInteger('duration_days')->default(365);
            $table->unsignedInteger('max_photos')->default(5);
            $table->unsignedInteger('max_guests')->default(100);
            $table->unsignedInteger('max_templates')->default(1);
            $table->boolean('has_rsvp')->default(false);
            $table->boolean('has_music')->default(false);
            $table->boolean('has_guestbook')->default(true);
            $table->boolean('has_gallery')->default(true);
            $table->boolean('has_countdown')->default(true);
            $table->boolean('has_maps')->default(true);
            $table->boolean('has_love_story')->default(false);
            $table->boolean('has_digital_envelope')->default(false);
            $table->boolean('has_qr_checkin')->default(false);
            $table->boolean('has_custom_domain')->default(false);
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_whatsapp_blast')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->restrictOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('status')->default('draft');

            // Mempelai
            $table->string('groom_name');
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->string('groom_photo')->nullable();
            $table->text('groom_bio')->nullable();
            $table->string('groom_instagram')->nullable();

            $table->string('bride_name');
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            $table->string('bride_photo')->nullable();
            $table->text('bride_bio')->nullable();
            $table->string('bride_instagram')->nullable();

            // Event Details
            $table->date('event_date');
            $table->time('event_time_start');
            $table->time('event_time_end')->nullable();
            $table->string('event_venue');
            $table->text('event_address')->nullable();
            $table->string('event_maps_url')->nullable();
            $table->decimal('event_latitude', 10, 8)->nullable();
            $table->decimal('event_longitude', 11, 8)->nullable();

            // Resepsi (optional second event)
            $table->date('reception_date')->nullable();
            $table->time('reception_time_start')->nullable();
            $table->time('reception_time_end')->nullable();
            $table->string('reception_venue')->nullable();
            $table->text('reception_address')->nullable();
            $table->string('reception_maps_url')->nullable();

            // Content
            $table->text('opening_text')->nullable();
            $table->text('closing_text')->nullable();
            $table->text('love_story')->nullable();
            $table->string('dress_code')->nullable();
            $table->text('gift_info')->nullable();
            $table->string('qris_image')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_holder')->nullable();

            // Media
            $table->string('cover_image')->nullable();
            $table->string('music_url')->nullable();
            $table->boolean('music_autoplay')->default(true);

            // Customization
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('font_family')->nullable();
            $table->json('custom_css')->nullable();

            // Settings
            $table->boolean('is_rsvp_enabled')->default(true);
            $table->boolean('is_guestbook_enabled')->default(true);
            $table->boolean('is_gallery_enabled')->default(true);
            $table->boolean('is_countdown_enabled')->default(true);
            $table->boolean('is_music_enabled')->default(true);
            $table->boolean('is_maps_enabled')->default(true);
            $table->boolean('is_love_story_enabled')->default(false);
            $table->boolean('is_gift_enabled')->default(false);

            // Analytics
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('event_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};

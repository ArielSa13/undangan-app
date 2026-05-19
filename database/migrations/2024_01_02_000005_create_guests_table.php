<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('group')->nullable();
            $table->unsignedTinyInteger('max_pax')->default(2);
            $table->string('rsvp_status')->default('pending');
            $table->unsignedTinyInteger('attending_count')->default(0);
            $table->text('rsvp_note')->nullable();
            $table->timestamp('rsvp_at')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->string('qr_code')->nullable();
            $table->boolean('is_checked_in')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->unsignedInteger('open_count')->default(0);
            $table->timestamp('last_opened_at')->nullable();
            $table->timestamps();

            $table->unique(['invitation_id', 'slug']);
            $table->index('rsvp_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};

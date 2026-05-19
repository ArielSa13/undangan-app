<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(
        private User $user,
        private string $code,
    ) {}

    public function handle(): void
    {
        $this->user->notify(new OtpNotification($this->code));
    }
}

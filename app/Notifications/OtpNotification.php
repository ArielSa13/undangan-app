<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification implements \Illuminate\Contracts\Queue\ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $code,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Verifikasi - Undangan Digital Premium')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Kode verifikasi Anda adalah:')
            ->line('**' . $this->code . '**')
            ->line('Kode ini berlaku selama 10 menit.')
            ->line('Jika Anda tidak merasa melakukan registrasi, abaikan email ini.')
            ->salutation('Salam, Tim Undangan Digital Premium');
    }
}

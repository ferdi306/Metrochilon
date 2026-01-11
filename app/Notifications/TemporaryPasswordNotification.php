<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TemporaryPasswordNotification extends Notification
{
    use Queueable;

    protected string $tempPassword;

    public function __construct(string $tempPassword)
    {
        $this->tempPassword = $tempPassword;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Password Sementara - Metrochilon')
            ->greeting('Halo ' . ($notifiable->name ?? ''))
            ->line('Admin telah menetapkan password sementara untuk akun Anda.')
            ->line('Password sementara: ' . $this->tempPassword)
            ->line('Silakan masuk menggunakan password ini lalu segera ubah password Anda.')
            ->salutation('Salam, Metrochilon');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Сброс пароля")
            ->line('Вы получили это письмо т.к. кто-то запросил сброс пароля для вашего аккаунта')
            ->action('Сбросить пароль', $this->resetUrl($notifiable))
            ->line('Если вы не запрашивали сброс пароля, от вас не требуется никаких действий');
    }

    /**
     * Get the reset password URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        $appUrl = config('app.client_url', config('app.url'));

        return url("$appUrl/password/reset/$this->token").'?email='.urlencode($notifiable->email);
    }
}
